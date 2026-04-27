<script setup lang="ts">
import axios from 'axios'
import type { Carrier } from '@/types/carrier'
import { ref, Ref, inject } from 'vue'
import { route } from '../../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../../ziggy.js';

interface OrderCarriersListProps {
    classname: string
    carriers: Carrier[]
    locale: string
}

const props = defineProps<OrderCarriersListProps>()
const selectedCarrier = ref<Carrier|null>(null)
const isCarrierSelected = inject<Ref<boolean>>('isCarrierSelected')!
const shippingCost = inject<Ref<number>>('shippingCost')!

const selectCarrier = async (carrier: Carrier|null) => {
    if (carrier !== null) {
        try {
            await axios.post(
                route('order.selectCarrier', {locale: props.locale, carrierId: carrier.id}, false, Ziggy)
            ).then((response) => {
                isCarrierSelected.value = response.data.isCarrierSelected;
                shippingCost.value = response.data.shipping_cost;
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

        <div class="bg-white py-6 w-full rounded-t-md" aria-current="step">
            <h2 class="text-xl px-3 py-4">3. Select a carrier</h2>
        </div>

        <fieldset v-if="props.carriers.length > 0" class="w-full bg-white px-4 sm:px-8 py-6">
            <legend class="sr-only">Available carriers</legend>
            <ul class="flex flex-col gap-4" role="list">
                <li v-for="carrier in carriers" :key="carrier.id">
                    <label
                        :for="'carrier-' + carrier.id"
                        class="flex flex-row justify-between items-center gap-4 bg-gray-100 rounded-md py-4 px-5 cursor-pointer hover:bg-gray-200 transition-colors"
                    >
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-8 items-start sm:items-center">
                            <figure class="shrink-0">
                                <img
                                    :src="`/storage/img/icons/carriers/${carrier.slug}_small.png`"
                                    :alt="carrier.name + ' logo'"
                                    class="w-12 h-12 object-contain"
                                >
                            </figure>
                            <span class="font-medium">{{ carrier.name }}</span>
                            <p class="text-sm text-gray-600">{{ carrier.description }}</p>
                        </div>
                        <input
                            type="radio"
                            :id="'carrier-' + carrier.id"
                            name="carrier"
                            :value="carrier"
                            v-model="selectedCarrier"
                            class="w-5 h-5 accent-shop-primary shrink-0"
                        >
                    </label>
                </li>
            </ul>
            <button
                @click="selectCarrier(selectedCarrier)"
                class="mt-6 bg-shop-primary text-white font-bold rounded-lg hover:bg-[#a32a32] py-4 px-6 w-full sm:w-auto sm:mx-8 focus-visible:ring-2 focus-visible:ring-shop-primary focus-visible:ring-offset-2 transition-colors"
            >Choose this carrier</button>
        </fieldset>

        <div v-else class="bg-white rounded-md py-8 px-5 my-3 text-center">
            <p>No carrier available</p>
        </div>

    </section>
</template>
