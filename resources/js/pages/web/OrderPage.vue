<script setup lang="ts">
import Account from '@/components/jewellery_store/tab/OrderAccountChoiceTab.vue'
import { useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { Carrier } from '@/types/carrier'
import { Country } from '@/types/country'
import { Customer } from '@/types/customer'
import { Payment } from '@/types/payment'
import { route } from '../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../ziggy.js';
import OrderSummary from '@/components/jewellery_store/OrderSummary.vue'
 
interface CartProduct {
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
} 

const props = defineProps<OrderPageProps>()

const steps = [
    Account,
    // Address,
    // CarrierChoice,
    // PaymentChoice
]

const currentStep = ref(0)

const addressForm = useForm({
    country_id: 0,
    customer_id: props.customer ? props.customer.id : 0,
    name: '',
    address_line_1: '',
    address_line_2: '',
    city: '',
    postal_code: '',
    region: '',
    district: '',
    sub_district: '',
    locality: '',
    sub_locality: '',
    country: {}
})

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

const submitAddressForm = () => {
  addressForm.post(route('newAddress', {}, false, Ziggy))
}
</script>

<template>
  <main id="order-page-wrapper" class="flex flex-row py-6 gap-2 justify-evenly bg-gray-100">
    <div id="order-page-steps-wrapper">
      <component
        :is="currentComponent"
        :addressForm="addressForm"
        :countries="countries"
        :is-last="currentStep === steps.length - 1"
        @next="next"
        @prev="prev"
        @submitAddressForm="submitAddressForm"
      />
    </div>
    <OrderSummary :products="props.products"></OrderSummary>
  </main>
</template>