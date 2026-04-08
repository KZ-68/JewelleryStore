<script setup lang="ts">
import { Country } from '@/types/country';
import AddressCreateForm from '../jewellery_store/form/AddressCreateForm.vue';
import { ref } from 'vue'
import { Address } from '@/types/address';
import AddressesList from './list/addresses/AddressesList.vue';

interface OrderAddressStepProps {
    status?: string
    countries: Country[]
    addresses: Address[]
    isAddressSelected: boolean
    locale: string
}

const props = defineProps<OrderAddressStepProps>();
const isNewAddress = ref(false);

const displayNewAddressForm = () => {
    isNewAddress.value = true
}

defineEmits(['selectStep']);
</script>

<template>
    <section id="order-address-step-wrapper" class="py-8">
        <div id="order-address-step" class="flex flex-col items-center md:items-stretch my-2 mx-4 w-80 lg:w-[60rem] lg:max-w-[60rem] gap-1">
            <button @click="$emit('selectStep', 0)" id="order-address-step-tab" class="bg-white py-6 my-2 w-80 lg:w-[60rem] lg:max-w-[60rem] rounded-t-md  hover:cursor-pointer hover:bg-gray-50">
                <h2 class="text-left text-xl px-3 py-4">1. Connecting an account</h2>
            </button>
            <div id="order-address-step-tab" class="bg-white py-6 w-80 lg:w-[60rem] lg:max-w-[60rem] rounded-t-md">
                <h2 class="text-xl px-3 py-4">2. Delivery address</h2>
            </div>
            <div v-if="props.addresses.length === 0 || isNewAddress === true">
                <AddressCreateForm  classname="" :countries="countries" :isOrder="true" :locale="props.locale"/>
            </div>
            <div v-else class="bg-white w-80 lg:w-[60rem]">
                <h3 class="text-lg px-6 mt-8 mb-4">Select an address</h3>
                <AddressesList
                    classname=""
                    :addresses=addresses
                    :isOrder="true"
                    :locale="props.locale"
                />
                <button v-if="isNewAddress === false" @click="displayNewAddressForm" class="mb-10 mx-8 py-4 px-6 bg-[#84070F] text-white font-bold rounded-lg hover:cursor-pointer hover:bg-[#a32a32]">Add a new address</button>
            </div>
            <button v-if="isAddressSelected === true" @click="$emit('selectStep', 2)" id="order-address-step-tab" class="bg-white py-6 my-2 w-80 lg:w-[60rem] lg:max-w-[60rem] rounded-t-md hover:cursor-pointer hover:bg-gray-50">
                <h2 class="text-left text-xl px-3 py-4">3. Select a carrier</h2>
            </button>
            <button v-else id="order-address-step-tab" class="bg-white py-6 my-2 w-80 lg:w-[60rem] lg:max-w-[60rem] rounded-t-md">
                <h2 class="text-left text-xl px-3 py-4">3. Select a carrier</h2>
            </button>
        </div>
    </section>
</template>