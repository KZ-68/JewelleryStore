<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue'; 
 
interface CarrierInfoProps {
    form: {
        name: string
        description : string
        min_total: number
        max_total: number
        price: number
    }
} 

const props = defineProps<CarrierInfoProps>()

defineEmits(['next'])
</script>

<template>
    <AppLayout>
        <div id="carrier-info-wrapper" class="flex flex-col gap-4 py-8 px-20">
            <div class="grid gap-2">
                <Label for="name" class="text-lg">Carrier Name</Label>
                <Input
                    :v-model="props.form.name"
                    id="name"
                    type="text"
                    name="name"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="name"
                    class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    :default-value=props.form.name
                />
            </div>

            <div class="grid gap-2">
                <Label for="description" class="text-lg">Carrier Description</Label>
                <Input
                    :v-model="props.form.description"
                    id="description"
                    type="text"
                    name="description"
                    required
                    autofocus
                    :tabindex="2"
                    autocomplete="description"
                    class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    :default-value=props.form.description
                />
            </div>
            <button @click="$emit('next')" class="btn mt-4">
                Next
            </button>
        </div>
    </AppLayout>
</template>