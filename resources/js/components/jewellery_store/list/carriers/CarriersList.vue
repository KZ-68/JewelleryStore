<script setup lang="ts">
import type { Carrier } from '@/types/carrier'
import { router } from '@inertiajs/vue3'
import Button from '@/components/ui/button/Button.vue';
import { ref } from "vue";
import { route } from '../../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../../ziggy.js';

interface CarriersListProps {
    classname:string
    carriers: Carrier[]
    sortBy: string
    order: 'asc' | 'desc'
    locale: string
}

const props = defineProps<CarriersListProps>()

const selected = ref<string[]>([]);

const deleteCarrier = (name: string) => {
    router.post(route('delete-carrier', {locale: props.locale, slug: name}, false, Ziggy), {locale: props.locale, name: name})
}

const getSelected = () => {
    return selected.value
}

defineExpose({
    getSelected
});
</script>

<template>
    <section id="carriers-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-4 sm:px-8">
        <ul v-if="carriers.length > 0" id="carriers-list" class="flex flex-col gap-4">
            <li v-for="carrier in carriers" v-bind:key="carrier.id" class="flex flex-row items-center gap-3 justify-between bg-white rounded-md py-4 px-4 sm:px-5 my-3">
                <input
                    id="delete"
                    type="checkbox"
                    name="delete"
                    :value="carrier.name"
                    v-model="selected"
                    :tabindex="1"
                    class="shrink-0"
                />
                <p class="flex-1 min-w-0 break-words">{{ carrier.name }}</p>
                <Button class="shrink-0" @click="deleteCarrier(carrier.name)">Delete</Button>
            </li>
        </ul>
        <ul v-else id="carriers-list" class="flex flex-col gap-4">
            <li class="text-center bg-white rounded-md py-4 px-5 my-3 min-h-[5rem]">
                <p>No Carrier registered</p>
            </li>
        </ul>
    </section>
</template>