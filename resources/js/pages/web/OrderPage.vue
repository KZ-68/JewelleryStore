<script setup lang="ts">
import Account from '@/components/jewellery_store/tab/OrderAccountChoiceTab.vue'
import AddressStep from '@/components/jewellery_store/OrderAddressStep.vue'
import CarrierChoice from '@/components/jewellery_store/list/carriers/OrderCarriersAvailable.vue'
import { usePage } from '@inertiajs/vue3'
import { ref, computed, onMounted } from 'vue'
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
    // PaymentChoice
]

const currentStep = ref(0);
const isAddressSelected = ref(false);

const currentComponent = computed(() => steps[currentStep.value])


const next = () => {
  if (currentStep.value < steps.length - 1) {
    currentStep.value++
  }
}

const prev = () => {
  if (currentStep.value > 0) {
    currentStep.value--
  }
}

onMounted(async () => {
  try {
      if(usePage().props.auth.customer) {
        currentStep.value++
      }
      if(isAddressSelected.value === true) {
        currentStep.value === 3;
      }
  } catch (error) {
      console.error('Erreur:', error);
  }
})
</script>

<template>
  <main id="order-page-wrapper" class="flex flex-row py-6 gap-2 justify-evenly bg-gray-100">
    <div id="order-page-steps-wrapper">
      <component
        :is="currentComponent"
        :countries="countries"
        :addresses="addresses"
        :is-last="currentStep === steps.length - 1"
        @next="next"
        @prev="prev"
      />
    </div>
    <OrderSummary :products="props.products" :total_price="total_price"></OrderSummary>
  </main>
</template>