<script setup lang="ts">
import axios from 'axios'
import type { Payment } from '@/types/payment'
import { ref, Ref, inject } from 'vue'
import { route } from '../../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../../ziggy.js';
import StripePayment from '../../stripe/StripePayment.vue';

interface OrderPaymentsAvailableProps {
    classname: string
    payments: Payment[]
    total_price: number
    locale: string
}

const props = defineProps<OrderPaymentsAvailableProps>()
const selectedPayment = ref<Payment|null>(null)
const isPaymentSelected = inject<Ref<boolean>>('isPaymentSelected')!

const selectPayment = async (payment: Payment|null) => {
    if (payment !== null) {
        try {
            await axios.post(
                route('order.selectPayment', {locale: props.locale, paymentId: payment.id}, false, Ziggy)
            ).then((response) => {
                isPaymentSelected.value = response.data.isPaymentSelected
            })
        } catch (error) {
            console.error('Error:', error);
        }
    }
}
</script>

<template>
    <section class="flex flex-col w-full max-w-[60rem] lg:max-w-none bg-gray-100 rounded-lg py-4 px-4 sm:px-8 my-2 mx-auto">

        <button
            @click="$emit('selectStep', 0)"
            class="bg-white py-6 my-2 w-full rounded-t-md text-left hover:bg-gray-50 cursor-pointer focus-visible:ring-2 focus-visible:ring-shop-primary focus-visible:ring-offset-2 transition-colors"
            aria-label="Go back to step 1: Connecting an account"
        >
            <h2 class="text-xl px-3 py-4">1. Connecting an account</h2>
        </button>

        <button
            @click="$emit('selectStep', 1)"
            class="bg-white py-6 my-2 w-full rounded-t-md text-left hover:bg-gray-50 cursor-pointer focus-visible:ring-2 focus-visible:ring-shop-primary focus-visible:ring-offset-2 transition-colors"
            aria-label="Go back to step 2: Delivery address"
        >
            <h2 class="text-xl px-3 py-4">2. Delivery address</h2>
        </button>

        <button
            @click="$emit('selectStep', 2)"
            class="bg-white py-6 my-2 w-full rounded-t-md text-left hover:bg-gray-50 cursor-pointer focus-visible:ring-2 focus-visible:ring-shop-primary focus-visible:ring-offset-2 transition-colors"
            aria-label="Go back to step 3: Select a carrier"
        >
            <h2 class="text-xl px-3 py-4">3. Select a carrier</h2>
        </button>

        <div class="bg-white py-6 w-full rounded-t-md" aria-current="step">
            <h2 class="text-xl px-3 py-4">4. Select a payment</h2>
        </div>

        <fieldset v-if="props.payments.length > 0" class="w-full bg-white px-4 sm:px-8 py-6">
            <legend class="sr-only">Available payment methods</legend>
            <ul class="flex flex-col gap-4" role="list">
                <li v-for="payment in payments" :key="payment.id">
                    <label
                        :for="'payment-' + payment.id"
                        class="flex flex-row justify-between items-center gap-4 bg-gray-100 rounded-md py-4 px-5 cursor-pointer hover:bg-gray-200 transition-colors"
                    >
                        <div class="flex flex-row gap-6 items-center">
                            <figure class="shrink-0">
                                <img
                                    :src="`/storage/img/icons/payments/${payment.slug}_small.png`"
                                    :alt="payment.name + ' logo'"
                                >
                            </figure>
                            <span class="font-medium">{{ payment.name }}</span>
                        </div>
                        <input
                            type="radio"
                            :id="'payment-' + payment.id"
                            name="payment"
                            :value="payment"
                            v-model="selectedPayment"
                            class="w-5 h-5 accent-shop-primary shrink-0"
                        >
                    </label>
                </li>
            </ul>
            <button
                @click="selectPayment(selectedPayment)"
                class="mt-6 bg-shop-primary text-white font-bold rounded-lg hover:bg-[#a32a32] py-4 px-6 w-full sm:w-auto sm:mx-8 focus-visible:ring-2 focus-visible:ring-shop-primary focus-visible:ring-offset-2 transition-colors"
            >Choose this payment</button>
            <StripePayment v-if="selectedPayment?.name === 'Stripe' && isPaymentSelected" :amount="props.total_price" :locale="props.locale" />
        </fieldset>

        <div v-else class="bg-white rounded-md py-8 px-5 my-3 text-center">
            <p>No payment available</p>
        </div>

    </section>
</template>
