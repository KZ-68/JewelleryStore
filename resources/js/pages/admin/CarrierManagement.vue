<script setup lang="ts">
import CarrierInfo from './CarrierInfo.vue'
import ShippingRates from './ShippingRates.vue'
import { useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { Carrier } from '@/types/carrier'
import { Country } from '@/types/country'
import { route } from '../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../ziggy.js';
 
interface CarrierManagementProps {
    carrier: Carrier
    countries: Country[]
    isUpdate: boolean
} 

const props = defineProps<CarrierManagementProps>()

const steps = [
  CarrierInfo,
  ShippingRates
]

const currentStep = ref(0)

const form = useForm({
  name: props.isUpdate === true ? props.carrier.name : '',
  description: props.isUpdate === true ? props.carrier.description : '',
  min_total: 0.00,
  max_total: 0.00,
  price: 0.00,
  id_carrier: props.carrier.id,
  countries: props.countries
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

const submit = () => {
  form.post(route('carrierManagementUpdate', {slug: props.carrier.slug}, false, Ziggy))
}
</script>

<template>
  <div id="carrier-management-steps-wrapper">
     <component
      :is="currentComponent"
      :form="form"
      :countries="countries"
      :is-last="currentStep === steps.length - 1"
      @next="next"
      @prev="prev"
      @submit="submit"
    />
  </div>
</template>