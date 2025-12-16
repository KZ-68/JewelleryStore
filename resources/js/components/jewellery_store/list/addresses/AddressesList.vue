<script setup lang="ts">
import type { Address } from '@/types/address';
import AddressCard from '../../card/AddressCard.vue';

interface AddressesListProps {
    classname:string
    addresses: Address[]
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

defineProps<AddressesListProps>()
</script>

<template>
    <section id="addresses-list-wrapper" class="rounded-lg py-4 px-8">
        <ul v-if="addresses.length > 0" id="addresses-list" class="flex flex-col gap-4">
            <li v-for="address in addresses" v-bind:key="address.id" class="flex flex-row justify-between bg-white rounded-md py-4 px-5 my-3">
                <AddressCard classname="" :address="address"/>
            </li>
        </ul>
        <ul v-else id="addresses-list" class="flex flex-col gap-4">
            <li class="border-black border-2 focus:border-red-800 rounded-lg py-4 px-8">
                <p>No Address registered</p>
            </li>
        </ul>
    </section>
</template>