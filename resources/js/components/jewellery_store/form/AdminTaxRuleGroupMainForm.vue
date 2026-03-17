<script setup lang="ts">
import TaxRuleGroupFrontController from '@/actions/App/Http/Controllers/Admin/TaxRuleGroupFrontController';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Country } from '@/types/country';
import { Tax } from '@/types/tax';
import { TaxRule } from '@/types/taxRule';
import { TaxRuleGroup } from '@/types/taxRuleGroup';
import { Form } from '@inertiajs/vue3';
import { ref } from "vue";

interface AdminTaxRuleGroupMainFormProps {
    classname:string
    countries: Country[]
    taxRuleGroup: TaxRuleGroup
    taxRules: TaxRule[]
    taxes: Tax[]
}   

const props = defineProps<AdminTaxRuleGroupMainFormProps>();
const isActivated = ref(props.taxRuleGroup.active);
</script>

<template>
    <section id="new-admin-tax-rule-group-form-wrapper" class="my-2 mx-4 max-w-[900px] flex-start p-8 gap-1 rounded-lg bg-white p-1 dark:bg-neutral-800">
        <Form
            v-bind="TaxRuleGroupFrontController.updateRuleGroup.form({ slug: taxRuleGroup.slug })"
            :reset-on-success="['tax-details']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <h2 class="text-2xl">Edit Tax Rule Group</h2>
                <div class="grid gap-2">
                    <Label for="name" class="text-base">Tax Rule Group Name</Label>
                    <Input
                        id="name"
                        type="text"
                        name="name"
                        required
                        autofocus
                        :tabindex="1"
                        :default-value=props.taxRuleGroup.name
                        class="p-1 file:text-lg md:text-base text-lg h-8"
                    />
                    <InputError :message="errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="active" class="text-base">Activate</Label>
                    <select v-model="isActivated" id="active" name="active" class="border-2 rounded-md" required>
                        <option :value=1>Yes</option>
                        <option :value=0>No</option>
                    </select>
                </div>
                <hr class="mt-8 border">
                <section>
                    <h3 class="my-2 text-xl">Tax Rules</h3>
                    <ul id="tax-rules-list-wrapper" class="h-110 overflow-auto">
                        <li class="my-6 p-4 flex flex-col gap-8 bg-gray-100 rounded-sm" v-for="taxRule in taxRules">
                            <h4 class="text-lg">Rule Number #{{ taxRule.rate_order }}</h4>
                            <div>
                                <Label for="countries" class="text-base">Countries</Label>
                                <select id="countries" name="countries" class="border-2 rounded-md" required>
                                    <option disabled value="">--Please choose a country--</option>
                                    <option v-for="country in countries" :value="country.local" :key="country.id" :selected="taxRule.country_id == country.id ? true : false">{{ country.name }}</option>
                                </select>
                                <input id="selected-country" name="selected-country" type="hidden" :value=taxRule.country_id>
                            </div>

                            <div>
                                <Label for="taxes" class="text-base">Taxes</Label>
                                <select id="taxes" name="taxes" class="border-2 rounded-md">
                                    <option disabled value="">--Please choose a tax--</option>
                                    <option v-for="tax in taxes" :value="tax.name" :key="tax.id">{{ tax.name }}</option>
                                </select>
                                <input id="tax" name="tax" type="hidden" :value=taxRule.tax_id>
                            </div>
                            <div>
                                <Label for="behavior" class="text-base">Rule Behavior</Label>
                                <Input
                                    id="behavior"
                                    type="text"
                                    name="behavior"
                                    required
                                    autofocus
                                    :tabindex="4"
                                    :default-value=taxRule.behavior
                                    class="p-1 text-lg md:text-base text-lg h-8"
                                />
                                <InputError :message="errors.behavior" />
                            </div>
                            <div>
                                <Label for="rate_order" class="text-base">Rate Order</Label>
                                <Input
                                    id="rate_order"
                                    type="number"
                                    name="rate_order"
                                    autofocus
                                    :tabindex="5"
                                    :default-value=taxRule.rate_order
                                    class="p-1 text-lg md:text-base text-lg h-8"
                                />
                                <InputError :message="errors.rate_order" />
                            </div>
                        </li>
                    </ul>
                </section>

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