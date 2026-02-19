<script setup lang="ts">
import type { Address } from '@/types/address'
import Button from '@/components/ui/button/Button.vue';
import { route } from '../../../../../vendor/tightenco/ziggy/src/js';
import { router } from '@inertiajs/vue3'
import { TrashIcon } from 'lucide-vue-next';
import { Ziggy } from '../../../ziggy.js';

interface AddressCardProps {
    classname:string
    address: Address
    isOrder: boolean
}

const deleteAddress = (name: string) => {
    router.post(route('addresses.deleteAddress', {name: name}, false, Ziggy), {name: name})
}

const selectAddress = (id: number) => {
    router.post(route('order.selectAddress', {addressId: id}, false, Ziggy), {addressId: id})
}

const props = defineProps<AddressCardProps>()
</script>

<template>
    <section id="address-card-wrapper" class="m-2 text-sm">
        <div v-if="props.isOrder === false" class="w-3xs max-w-3xs border-black border-2 focus:border-red-800 rounded-lg py-4 px-4">
            <Button @click="deleteAddress(props.address.name)"><TrashIcon class="text-red-500" /></Button>
            <hgroup class="flex flex-col border-b-[2px] border-black my-2">
                <h2 class="my-2">{{ props.address.name }}</h2>
            </hgroup>
            <ul class="flex flex-col gap-2 py-2">
                <li class="font-semibold">{{ props.address.address_line_1 }}</li>
                <li v-if="props.address.address_line_2 !== null" class="font-semibold">{{ props.address.address_line_2 }}</li>
                <li class="font-semibold">{{ props.address.city }}</li>
                <li v-if="props.address.region !== null" class="font-semibold">{{ props.address.region }}</li>
                <li v-if="props.address.postal_code !== null" class="font-semibold">{{ props.address.postal_code }}</li>
                <li v-if="props.address.country_id !== null" class="font-semibold">{{ props.address.country }}</li>
                <li v-if="props.address.district !== null" class="font-semibold">{{ props.address.district }}</li>
                <li v-if="props.address.sub_district !== null" class="font-semibold">{{ props.address.sub_district }}</li>
                <li v-if="props.address.locality !== null" class="font-semibold">{{ props.address.locality }}</li>
                <li v-if="props.address.sub_locality !== null" class="font-semibold">{{ props.address.sub_locality }}</li>
            </ul>
        </div>
        <div v-else class="w-3xs max-w-3xs border-black border-2 focus:border-red-800 rounded-lg py-4 px-4">
            <button @click="selectAddress(props.address.id)" class="flex flex-col items-start hover:cursor-pointer">
                <hgroup class="flex flex-col border-b-[2px] border-black my-2">
                    <h2 class="my-2">{{ props.address.name }}</h2>
                </hgroup>
                <ul class="flex flex-col items-start gap-2 py-2">
                    <li class="font-semibold">{{ props.address.address_line_1 }}</li>
                    <li v-if="props.address.address_line_2 !== null" class="font-semibold">{{ props.address.address_line_2 }}</li>
                    <li class="font-semibold">{{ props.address.city }}</li>
                    <li v-if="props.address.region !== null" class="font-semibold">{{ props.address.region }}</li>
                    <li v-if="props.address.postal_code !== null" class="font-semibold">{{ props.address.postal_code }}</li>
                    <li v-if="props.address.country_id !== null" class="font-semibold">{{ props.address.country }}</li>
                    <li v-if="props.address.district !== null" class="font-semibold">{{ props.address.district }}</li>
                    <li v-if="props.address.sub_district !== null" class="font-semibold">{{ props.address.sub_district }}</li>
                    <li v-if="props.address.locality !== null" class="font-semibold">{{ props.address.locality }}</li>
                    <li v-if="props.address.sub_locality !== null" class="font-semibold">{{ props.address.sub_locality }}</li>
                </ul>
            </button>
        </div>
    </section>
</template>