<script setup lang="ts">
import { ref, onMounted } from 'vue'
import {
    Stripe,
    StripeElements,
    VueStripeProvider,
    VueStripeElements,
    VueStripePaymentElement,
    usePaymentIntent
} from '@vue-stripe/vue-stripe'

interface StripePaymentProps {
    amount: number
}   
const publishableKey = import.meta.env.VITE_APP_STRIPE_KEY
const props = defineProps<StripePaymentProps>()
const clientSecret = ref('')
const loading = ref(false)
const errorMessage = ref('')

// Capture instances from component events
const stripeInstance = ref<Stripe | null>(null)
const elementsInstance = ref<StripeElements | null>(null)

const onStripeLoad = (stripe: Stripe) => {
  stripeInstance.value = stripe
}

const onElementsReady = (elements: StripeElements) => {
  elementsInstance.value = elements
}

onMounted(async () => {
  try {
    const response = await fetch('/stripe/payment/create-intent', {
      method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
      body: JSON.stringify({amount: props.amount, gift:false, valid:false, returned:false})
    })
    const data = await response.json()
    clientSecret.value = data.clientSecret
  } catch(err){
    errorMessage.value = 'Failed to initialize payment'
  }
})

const handleSubmit = async () => {
  if (!stripeInstance.value || !elementsInstance.value) return

  loading.value = true
  errorMessage.value = ''

  const { error } = await stripeInstance.value.confirmPayment({
    elements: elementsInstance.value,
    confirmParams: {
      return_url: `${window.location.origin}/order/confirmation`
    }
  })

  if (error) {
    errorMessage.value = error.message || 'Payment failed'
    loading.value = false
  }
}
</script>

<template>
  <VueStripeProvider :publishable-key="publishableKey"  @load="onStripeLoad">
    <VueStripeElements
      v-if="clientSecret"
      :client-secret="clientSecret"
      @ready="onElementsReady"
    >
      <form @submit.prevent="handleSubmit" class="flex flex-col gap-4">
        <VueStripePaymentElement />

        <div v-if="errorMessage" class="error">
          {{ errorMessage }}
        </div>

        <button type="submit" :disabled="loading" class=" disabled:cursor-not-allowed disabled:opacity-[0.5] bg-[#635bff] text-white p-3 rounded-md text-md cursor-pointer">
          {{ loading ? 'Processing...' : 'Pay Now' }}
        </button>
      </form>
    </VueStripeElements>
    <template v-else>
      <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
      <p v-else>Loading payment form...</p>
    </template>
  </VueStripeProvider>
</template>