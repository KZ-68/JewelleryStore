<script setup lang="ts">
import TaxFrontController from '@/actions/App/Http/Controllers/Admin/TaxFrontController';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form } from '@inertiajs/vue3';
import type { Tax } from '@/types/tax';
import { ref } from 'vue';

interface AdminTaxMainFormProps {
    classname:string;
    tax: Tax;
}   

const props = defineProps<AdminTaxMainFormProps>();

const isApplicable = ref(props.tax.applicable);
</script>

<template>
    <section id="admin-tax-form-wrapper" class="my-2 mx-4 max-w-[900px] flex-start p-8 gap-1 rounded-lg bg-white dark:bg-neutral-800">
        <Form
            v-bind="TaxFrontController.update.form({ name: props.tax.name })"
            :reset-on-success="['tax-details']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="rate" class="text-lg">Tax Rate</Label>
                    <Input
                        id="rate"
                        type="number" 
                        name="rate"
                        step=".01"
                        required
                        :tabindex="1"
                        :default-value=props.tax.rate
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.cost_price" />
                </div>

                <div class="grid gap-2">
                    <Label for="applicable" class="text-lg">Applicable ?</Label>
                    <select v-model="isApplicable" id="applicable" name="applicable" required>
                        <option :value=true>Yes</option>
                        <option :value=false>No</option>
                    </select>
                </div>
                
                <div class="grid gap-2">
                    <Label for="type">Tax Type</Label>
                    <Input
                        id="type"
                        type="text"
                        name="type"
                        required
                        autofocus
                        :tabindex="2"
                        autocomplete="type"
                        :default-value=props.tax.type
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.type" />
                </div>

                <div class="grid gap-2">
                    <Label for="description">Tax Description</Label>
                    <Input
                        id="description"
                        type="text"
                        name="description"
                        required
                        autofocus
                        :tabindex="3"
                        autocomplete="description"
                        :default-value=props.tax.description
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.name" />
                </div>

                <section id="admin-tax-details-footer" class="flex flex-row gap-4 py-8">
                    <Button
                    type="submit"
                    class="w-20 bg-black text-white"
                    :tabindex="4"
                    :disabled="processing"
                    >
                        <LoaderCircle
                            v-if="processing"
                            class="h-4 w-4 animate-spin"
                        />
                        Save
                    </Button>
                </section>
            </div>
        </Form>
    </section>
</template>