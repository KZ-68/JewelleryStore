<script setup lang="ts">
import TaxFrontController from '@/actions/App/Http/Controllers/Admin/TaxFrontController';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Country } from '@/types/country';
import { Tax } from '@/types/tax';
import { Form } from '@inertiajs/vue3';
import { ref } from "vue";

interface AdminTaxRuleGroupCreateFormProps {
    classname:string;
    countries: Country[]
    taxes: Tax[]
}   

const props = defineProps<AdminTaxRuleGroupCreateFormProps>();

const countriesSelected = ref(['']);
const taxSelected = ref('');
</script>

<template>
    <section id="new-admin-tax-rule-group-form-wrapper" class="my-2 mx-4 max-w-[900px] flex-start p-8 gap-1 rounded-lg bg-white p-1 dark:bg-neutral-800">
        <Form
            v-bind="TaxFrontController.create.form()"
            :reset-on-success="['tax-details']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Tax Rule Group Name</Label>
                    <Input
                        id="name"
                        type="text"
                        name="name"
                        required
                        autofocus
                        :tabindex="1"
                        placeholder="Add a name..."
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="active" class="text-lg">Activate</Label>
                    <select id="active" name="active" required>
                        <option :value=1 :selected=true>Yes</option>
                        <option :value=0>No</option>
                    </select>
                </div>

                <div class="grid gap-2">
                    <Label for="country" class="text-md">Countries</Label>
                    <select name="countries" v-model="countriesSelected" class="border-2 rounded-md">
                        <option value="">--Please choose a country--</option>
                        <option v-for="country in countries" :value="country.local">{{ country.name }}</option>
                    </select>
                   <input id="country" name="country" type="hidden" :value=countriesSelected>
                </div>

                <div class="grid gap-2">
                    <Label for="taxes" class="text-md">Taxes</Label>
                    <select name="taxes" v-model="taxSelected" class="border-2 rounded-md">
                        <option value="">--Please choose a tax--</option>
                        <option v-for="tax in taxes" :value="tax.name">{{ tax.name }}</option>
                    </select>
                   <input id="tax" name="tax" type="hidden" :value=taxSelected>
                </div>

                <div class="grid gap-2">
                    <Label for="behavior">Rule Behavior</Label>
                    <Input
                        id="behavior"
                        type="text"
                        name="behavior"
                        required
                        autofocus
                        :tabindex="4"
                        placeholder="..."
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.behavior" />
                </div>

                <div class="grid gap-2">
                    <Label for="rate_order">Rate Order</Label>
                    <Input
                        id="rate_order"
                        type="number"
                        name="rate_order"
                        autofocus
                        :tabindex="5"
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.rate_order" />
                </div>

                <section id="new-admin-tax-rule-group-details-footer" class="flex flex-row gap-4 py-8">
                    <Button
                    type="submit"
                    class="w-20 bg-black text-white"
                    :tabindex="6"
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