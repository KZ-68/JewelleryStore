<script setup lang="ts">
import type { Address } from '@/types/address';
import AddressCard from '../../card/AddressCard.vue';

interface AddressesListProps {
    classname:string
    addresses: Address[]
    isOrder: boolean
    locale: string
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const props = defineProps<AddressesListProps>()
</script>

<template>
    <section id="addresses-list-wrapper" class="h-[36rem] rounded-lg">
        <ul v-if="addresses.length > 0" id="addresses-list" class="flex flex-col md:flex-row flex-wrap gap-2 mx-4">
            <li v-for="address in addresses" v-bind:key="address.id" class="bg-white rounded-md my-3">
                <AddressCard classname="" :address="address" :isOrder="props.isOrder" :locale="props.locale"/>
            </li>
        </ul>
        <ul v-else id="addresses-list" class="flex flex-row flex-wrap gap-2">
            <li class="border-black border-2 focus:border-red-800 rounded-lg py-4 px-8">
                <p>No Address registered</p>
            </li>
        </ul>
    </section>
</template>