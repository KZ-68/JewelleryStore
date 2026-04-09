<script setup lang="ts">
import axios from 'axios'
import type { Payment } from '@/types/payment'
import { ref, Ref, inject } from 'vue'
import { route } from '../../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../../ziggy.js';
import Label from '@/components/ui/label/Label.vue';
import StripePayment from '../../stripe/StripePayment.vue';

interface OrderPaymentsAvailableProps {
    classname:string
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
    <section id="payments-list-wrapper" class="flex flex-col w-[60rem] max-w-[60rem] bg-gray-100 rounded-lg py-4 px-8 my-2 mx-4">
        <button @click="$emit('selectStep', 0)" id="order-address-step-tab" class="bg-white py-6 my-2 w-[60rem] max-w-[60rem] rounded-t-md hover:cursor-pointer hover:bg-gray-50">
                <h2 class="text-left text-xl px-3 py-4">1. Connecting an account</h2>
        </button>
        <button @click="$emit('selectStep', 1)" id="order-address-step-tab" class="bg-white py-6 my-2 w-[60rem] max-w-[60rem] rounded-t-md hover:cursor-pointer hover:bg-gray-50">
            <h2 class="text-left text-xl px-3 py-4">2. Delivery address</h2>
        </button>
        <button @click="$emit('selectStep', 2)" id="order-address-step-tab" class="bg-white py-6 my-2 w-[60rem] max-w-[60rem] rounded-t-md hover:cursor-pointer hover:bg-gray-50">
            <h2 class="text-left text-xl px-3 py-4">3. Select a carrier</h2>
        </button>
        <div id="order-address-step-tab" class="bg-white py-6 w-[60rem] max-w-[60rem] rounded-t-md">
            <h2 for="paymentId" class="text-xl px-3 py-4">4. Select a payment</h2>
        </div>
        <ul v-if="props.payments.length > 0" id="payments-list" class="flex flex-col gap-4 w-[60rem] max-w-[60rem] bg-white px-8 py-6">
            <li v-for="payment in payments" v-bind:key="payment.id" class="flex flex-row justify-between items-center gap-6 bg-gray-100 rounded-md py-4 px-5 my-3">
                <div id="payment-item-left" class="flex flex-row gap-10 items-center">
                    <figure>
                        <img :src="`/storage/img/icons/payments/${payment.slug}_small.png`" alt="Payment Icon">
                    </figure>
                    <Label for="payment">{{ payment.name }}</Label>
                </div>
                <input type="radio" name="payment" id="payment" :value="payment" v-model="selectedPayment" class="w-5 h-5">
            </li>
            <button @click="selectPayment(selectedPayment)" id="validate-select-payment-btn" class="bg-shop-primary text-white font-bold rounded-lg hover:cursor-pointer hover:bg-[#a32a32] py-4 px-6 my-6 mx-8">Choose this payment</button>
            <StripePayment v-if="selectedPayment?.name === 'Stripe' && isPaymentSelected == true" :amount="props.total_price"></StripePayment>
        </ul>
        <ul v-else id="payments-list" class="flex flex-col gap-4">
            <li class="text-center bg-white rounded-md py-4 px-5 my-3 min-h-[5rem]">
                <p>No payment available</p>
            </li>
        </ul>
    </section>
</template>