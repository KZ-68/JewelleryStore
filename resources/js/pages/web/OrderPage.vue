<script setup lang="ts">
import Account from '@/components/jewellery_store/tab/OrderAccountChoiceTab.vue'
import AddressStep from '@/components/jewellery_store/OrderAddressStep.vue'
import CarrierChoice from '@/components/jewellery_store/list/carriers/OrderCarriersAvailable.vue'
import PaymentChoice from '@/components/jewellery_store/list/payments/OrderPaymentsAvailable.vue'
import { usePage } from '@inertiajs/vue3'
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
} 

const props = defineProps<OrderPageProps>()

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
      if (usePage().props.auth.customer) {
        currentStep.value++
      }
  } catch (error) {
      console.error('Erreur:', error);
  }

})
</script>

<template>
  <main id="order-page-wrapper" class="flex flex-col items-center lg:flex-row py-6 gap-2 justify-evenly bg-gray-100">
    <div id="order-page-steps-wrapper">
      <component
        :is="currentComponent"
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
    <OrderSummary :products="props.products" :total_price="total_price"></OrderSummary>
  </main>
</template>