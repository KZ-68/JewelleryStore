<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { Carrier } from '@/types/carrier'
import { Country } from '@/types/country'
import { Customer } from '@/types/customer'
import { Payment } from '@/types/payment'
import { route } from '../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../ziggy.js';
 
interface OrderPageProps {
    customer: Customer
    carriers: Carrier[]
    countries: Country[]
    payments: Payment[]
} 

const props = defineProps<OrderPageProps>()

const steps = [
    Account,
    Address,
    CarrierChoice,
    PaymentChoice
]

const currentStep = ref(0)

const accountForm = useForm({
    email: '',
    plainPassword: ''
})

const addressForm = useForm({
    country_id: 0,
    customer_id: 0,
    manufacturer_id: 0,
    supplier_id: 0,
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

const submitLogin = () => {
  addressForm.post(route('login', {}, false, Ziggy))
}
</script>

<template>
  <div id="carrier-management-steps-wrapper">
     <component
      :is="currentComponent"
      :accountForm="accountForm"
      :addressForm="addressForm"
      :countries="countries"
      :is-last="currentStep === steps.length - 1"
      @next="next"
      @prev="prev"
      @submitAddressForm="submitAddressForm"
      @submitLogin="submitLogin"
    />
  </div>
</template>