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
}

const deleteAddress = (name: string) => {
    router.post(route('addresses.deleteAddress', {name: name}, false, Ziggy), {name: name})
}

defineProps<AddressCardProps>()
</script>

<template>
    <section id="address-card-wrapper" class="m-2">
        <div class="border-black border-2 focus:border-red-800 rounded-lg py-4 px-8 w-xs">
            <Button @click="deleteAddress(address.name)"><TrashIcon class="text-red-500" /></Button>
            <hgroup class="flex flex-col border-b-[2px] border-black my-2">
                <h2 class="my-2">{{ address.name }}</h2>
            </hgroup>
            <ul class="flex flex-col gap-2 py-2">
                <li class="font-semibold">{{ address.address_line_1 }}</li>
                <li v-if="address.address_line_2 !== null" class="font-semibold">{{ address.address_line_2 }}</li>
                <li class="font-semibold">{{ address.city }}</li>
                <li v-if="address.region !== null" class="font-semibold">{{ address.region }}</li>
                <li v-if="address.postal_code !== null" class="font-semibold">{{ address.postal_code }}</li>
                <li v-if="address.country_id !== null" class="font-semibold">{{ address.country }}</li>
                <li v-if="address.district !== null" class="font-semibold">{{ address.district }}</li>
                <li v-if="address.sub_district !== null" class="font-semibold">{{ address.sub_district }}</li>
                <li v-if="address.locality !== null" class="font-semibold">{{ address.locality }}</li>
                <li v-if="address.sub_locality !== null" class="font-semibold">{{ address.sub_locality }}</li>
            </ul>
            
        </div>
    </section>
</template>