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
    <section class="py-8 px-4 lg:px-0">
        <div class="mx-auto w-full max-w-[60rem] lg:max-w-none flex flex-col gap-1">

            <button
                @click="$emit('selectStep', 0)"
                class="bg-white py-6 my-2 w-full rounded-t-md text-left hover:bg-gray-50 cursor-pointer focus-visible:ring-2 focus-visible:ring-shop-primary focus-visible:ring-offset-2 transition-colors"
                aria-label="Go back to step 1: Connecting an account"
            >
                <h2 class="text-xl px-3 py-4">1. Connecting an account</h2>
            </button>

            <div class="bg-white py-6 w-full rounded-t-md" aria-current="step">
                <h2 class="text-xl px-3 py-4">2. Delivery address</h2>
            </div>

            <div v-if="props.addresses.length === 0 || isNewAddress === true">
                <AddressCreateForm classname="" :countries="countries" :isOrder="true" :locale="props.locale" />
            </div>
            <div v-else class="bg-white w-full">
                <h3 class="text-lg px-6 mt-8 mb-4">Select an address</h3>
                <AddressesList
                    classname=""
                    :addresses="addresses"
                    :isOrder="true"
                    :locale="props.locale"
                />
                <button
                    v-if="!isNewAddress"
                    @click="displayNewAddressForm"
                    class="mb-10 mx-4 sm:mx-8 py-4 px-6 bg-shop-primary text-white font-bold rounded-lg hover:bg-[#a32a32] focus-visible:ring-2 focus-visible:ring-shop-primary focus-visible:ring-offset-2 transition-colors"
                >Add a new address</button>
            </div>

            <button
                @click="$emit('selectStep', 2)"
                :disabled="!isAddressSelected"
                class="bg-white py-6 my-2 w-full rounded-t-md text-left transition-colors"
                :class="isAddressSelected
                    ? 'hover:bg-gray-50 cursor-pointer focus-visible:ring-2 focus-visible:ring-shop-primary focus-visible:ring-offset-2'
                    : 'opacity-50 cursor-not-allowed'"
                aria-label="Step 3: Select a carrier"
            >
                <h2 class="text-xl px-3 py-4">3. Select a carrier</h2>
            </button>

        </div>
    </section>
</template>
