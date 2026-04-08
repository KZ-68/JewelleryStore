<script setup lang="ts">
import { Country } from '@/types/country';
import ShippingRateTable from '@/components/jewellery_store/table/ShippingRateTable.vue';
import AppLayout from '@/layouts/AppLayout.vue'; 

interface ShippingRatesProps {
    countries: Country[]
    form: {
        name: string
        description : string
        min_total: number
        max_total: number
        price: number
    }
    isLast: boolean
    locale: string
} 

const props = defineProps<ShippingRatesProps>()

defineEmits(['prev', 'submit'])
</script>

<template>
    <AppLayout :locale="props.locale">
        <div id="shipping-rates-wrapper" class="flex flex-col gap-4 py-8 px-20">
            <ShippingRateTable classname="" :countries="props.countries" :form="props.form"></ShippingRateTable>
            <div class="flex justify-between mt-4">
                <button @click="$emit('prev')" class="px-4 py-2 text-white bg-black rounded-md">
                    Previous
                </button>

                <button
                    @click="$emit('submit')"
                    class="px-4 py-2 text-white bg-black rounded-md"
                    :disabled="form.processing"
                >
                    Create
                </button>
            </div>
        </div>
    </AppLayout>
</template>