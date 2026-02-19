<script setup lang="ts">
import { Country } from '@/types/country';
import AddressCreateForm from '../jewellery_store/form/AddressCreateForm.vue';
import { onMounted, ref } from 'vue'
import { Address } from '@/types/address';
import AddressesList from './list/addresses/AddressesList.vue';

interface OrderAddressStepProps {
    classname:string
    status?: string
    countries: Country[]
    addresses: Address[]
}

const props = defineProps<OrderAddressStepProps>();

defineEmits(['next', 'prev']);

onMounted(async () => {

})
</script>

<template>
    <section id="order-address-step-wrapper" class="py-8">
        <div id="order-address-step" class="flex flex-col my-2 mx-4 w-[60rem] max-w-[60rem] gap-1">
            <button @click="$emit('prev')" id="order-address-step-tab" class="bg-white py-6 my-2 w-[60rem] max-w-[60rem] rounded-t-md">
                <h2 class="text-left text-xl px-3 py-4">1. Connecting an account</h2>
            </button>
            <div id="order-address-step-tab" class="bg-white py-6 w-[60rem] max-w-[60rem] rounded-t-md">
                <h2 class="text-xl px-3 py-4">2. Delivery Address</h2>
            </div>
            <div v-if="props.addresses.length === 0">
                <AddressCreateForm  classname="" :countries="countries"/>
            </div>
            <div v-else class="bg-white">
                <h3 class="text-lg px-6 mt-8 mb-4">Select an Address</h3>
                <AddressesList
                    classname=""
                    :addresses=addresses
                    :isOrder="true"
                />
            </div>
        </div>
    </section>
</template>