<script setup lang="ts">
import axios from 'axios'
import type { Carrier } from '@/types/carrier'
import { ref, Ref, inject } from 'vue'
import { route } from '../../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../../ziggy.js';
import Label from '@/components/ui/label/Label.vue';

interface OrderCarriersListProps {
    classname:string
    carriers: Carrier[]
    locale: string
}

const props = defineProps<OrderCarriersListProps>()
const selectedCarrier = ref<Carrier|null>(null)
const isCarrierSelected = inject<Ref<boolean>>('isCarrierSelected')!

const selectCarrier = async (carrier: Carrier|null) => {
    if (carrier !== null) {
        try {
            await axios.post(
                route('order.selectCarrier', {locale: props.locale, carrierId: carrier.id}, false, Ziggy)
            ).then((response) => {
                isCarrierSelected.value = response.data.isCarrierSelected;
            })
        } catch (error) {
            console.error('Error:', error);
        }
    }
}
</script>

<template>
    <section id="carriers-list-wrapper" class="flex flex-col w-[60rem] max-w-[60rem] bg-gray-100 rounded-lg py-4 px-8 my-2 mx-4">
        <button @click="$emit('selectStep', 0)" id="order-address-step-tab" class="bg-white py-6 my-2 w-[60rem] max-w-[60rem] rounded-t-md hover:cursor-pointer hover:bg-gray-50">
                <h2 class="text-left text-xl px-3 py-4">1. Connecting an account</h2>
        </button>
        <button @click="$emit('selectStep', 1)" id="order-address-step-tab" class="bg-white py-6 my-2 w-[60rem] max-w-[60rem] rounded-t-md hover:cursor-pointer hover:bg-gray-50">
            <h2 class="text-left text-xl px-3 py-4">2. Delivery address</h2>
        </button>
        <div id="order-address-step-tab" class="bg-white py-6 w-[60rem] max-w-[60rem] rounded-t-md">
            <h2 for="carrierId" class="text-xl px-3 py-4">3. Select a carrier</h2>
        </div>
        <ul v-if="props.carriers.length > 0" id="carriers-list" class="flex flex-col gap-4 w-[60rem] max-w-[60rem] bg-white px-8 py-6">
            <li v-for="carrier in carriers" v-bind:key="carrier.id" class="flex flex-row justify-between items-center gap-6 bg-gray-100 rounded-md py-4 px-5 my-3">
                <div id="carrier-item-left" class="flex flex-row gap-10 items-center">
                    <figure>
                        <img :src="`/storage/img/icons/carriers/${carrier.slug}_small.png`" alt="Carrier Icon">
                    </figure>
                    <Label for="carrier">{{ carrier.name }}</Label>
                    <p class="ml-4">{{ carrier.description }}</p>
                </div>
                <input type="radio" name="carrier" id="carrier" :value="carrier" v-model="selectedCarrier" class="w-5 h-5">
            </li>
            <button @click="selectCarrier(selectedCarrier)" id="validate-select-carrier-btn" class="bg-[#84070F] text-white font-bold rounded-lg hover:cursor-pointer hover:bg-[#a32a32] py-4 px-6 my-6 mx-8">Choose this carrier</button>
        </ul>
        <ul v-else id="carriers-list" class="flex flex-col gap-4">
            <li class="text-center bg-white rounded-md py-4 px-5 my-3 min-h-[5rem]">
                <p>No carrier available</p>
            </li>
        </ul>
    </section>
</template>