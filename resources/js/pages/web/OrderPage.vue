<script setup lang="ts">
import Account from '@/components/jewellery_store/tab/OrderAccountChoiceTab.vue'
import AddressStep from '@/components/jewellery_store/OrderAddressStep.vue'
import CarrierChoice from '@/components/jewellery_store/list/carriers/OrderCarriersAvailable.vue'
import PaymentChoice from '@/components/jewellery_store/list/payments/OrderPaymentsAvailable.vue'
import { Head, usePage } from '@inertiajs/vue3'
import { ref, computed, onMounted, provide, watch } from 'vue'
import { Carrier } from '@/types/carrier'
import { Country } from '@/types/country'
import { Customer } from '@/types/customer'
import { Payment } from '@/types/payment'
import OrderSummary from '@/components/jewellery_store/OrderSummary.vue'
import { Address } from '@/types/address'

interface CartProduct {
    product_id: number
    name: string
    quantity: number
    price : number
}

interface OrderPageProps {
    customer: Customer
    carriers: Carrier[]
    countries: Country[]
    payments: Payment[]
    products: Array<CartProduct>
    total_price: number
    addresses: Address[]
    locale: string
}

const props = defineProps<OrderPageProps>()

const page = usePage()
const flashError = computed(() => (page.props.flash as any)?.error ?? null)

const steps = [
    Account,
    AddressStep,
    CarrierChoice,
    PaymentChoice
]

const currentStep = ref(0);

const currentComponent = computed(() => steps[currentStep.value])

const selectStep = (key: number) => {
  currentStep.value = key
}

const isAddressSelected = ref(false)
provide('isAddressSelected', isAddressSelected)
const isCarrierSelected = ref(false)
provide('isCarrierSelected', isCarrierSelected)
const shippingCost = ref<number>(0)
provide('shippingCost', shippingCost)
const isPaymentSelected = ref(false)
provide('isPaymentSelected', isPaymentSelected)

watch(
  () => isAddressSelected.value, (value) => {
    if (value === true) {
      currentStep.value = 2;
    }
  }
)

watch(
  () => isCarrierSelected.value, (value) => {
    if (value === true) {
      currentStep.value = 3;
    }
  }
)

onMounted(async () => {
  try {
      if (page.props.auth.customer) {
        currentStep.value++
      }
  } catch (error) {
      console.error('Erreur:', error);
  }
})
</script>

<template>
  <Head title="Ma Commande">
      <meta name="description" content="Finalisez votre commande : choisissez votre adresse de livraison, votre transporteur et votre moyen de paiement en toute sécurité." head-key="description" />
  </Head>
  <div v-if="flashError" role="alert" class="mx-auto max-w-screen-xl w-full px-6 lg:px-12 pt-6">
    <div class="flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
      <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
      </svg>
      <span>{{ flashError }}</span>
    </div>
  </div>
  <main id="order-page-wrapper" class="flex flex-col lg:flex-row lg:items-start py-6 md:px-6 lg:px-12 gap-6 justify-evenly bg-gray-100 min-h-screen">
    <div id="order-page-steps-wrapper" class="w-full lg:flex-1 min-w-0">
      <component
        :is="currentComponent"
        :locale="props.locale"
        :countries="countries"
        :addresses="addresses"
        :products="products"
        :carriers="carriers"
        :payments="payments"
        :total_price="total_price"
        :isAddressSelected="isAddressSelected"
        :is-last="currentStep === steps.length - 1"
        @selectStep="selectStep"
      />
    </div>
    <OrderSummary :products="props.products" :total_price="total_price" :shipping_cost="shippingCost" />
  </main>
</template>
