<script setup lang="ts">
import ProductFrontController from '@/actions/App/Http/Controllers/Admin/ProductFrontController';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form } from '@inertiajs/vue3';
import type { Product } from '@/types/product'
import { TaxRuleGroup } from '@/types/taxRuleGroup';
import { ref } from "vue";

interface AdminProductMainFormProps {
    classname:string;
    product: Product;
    taxRuleGroups: TaxRuleGroup[]
    priceWithTax: number
    taxRuleGroupId: number
}   

const props = defineProps<AdminProductMainFormProps>();
const selectedTaxRuleGroup = ref(props.taxRuleGroupId ? props.taxRuleGroupId : '');
</script>

<template>
    <section id="admin-product-form-wrapper" class="my-2 mx-4 max-w-[900px] flex-start p-8 gap-1 rounded-lg bg-white dark:bg-neutral-800">
        <Form
            v-bind="ProductFrontController.update.form({ slug: props.product.slug })"
            :reset-on-success="['product-details']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div id="product-page-header-wrapper" class="flex flex-row gap-6 align-center items-center px-8 py-10">
                <figure class="border h-40 w-40">
                    <figcaption>An product image</figcaption>
                </figure>
                <h1 id="product-heading">
                    <Input
                        id="name"
                        type="text"
                        name="name"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        :default-value=props.product.name
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                </h1>
                <InputError :message="errors.name" />
            </div>
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="description" class="text-lg">Product Description</Label>
                    <textarea
                        id="product-description"
                        name="description"
                        rows="5" 
                        cols="100"
                        min="3"
                        max="500"
                        autofocus
                        :tabindex="2"
                        placeholder="Add a description..."
                        :value=props.product.description
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.description" />
                </div>

                <div class="grid gap-2">
                    <Label for="reference" class="text-lg">Product Reference</Label>
                    <Input
                        id="reference"
                        type="text"
                        name="reference"
                        required
                        autofocus
                        :tabindex="3"
                        autocomplete="reference"
                        :default-value=props.product.reference
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.reference" />
                </div>

                <div class="grid gap-2">
                    <Label for="ean13" class="text-lg">EAN13 Bar Code</Label>
                    <Input
                        id="ean13"
                        type="text"
                        name="ean13"
                        autofocus
                        :tabindex="4"
                        autocomplete="ean13"
                        :default-value=props.product.ean13
                        placeholder="Add a bar code for your product"
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.ean13" />
                </div>

                <div class="grid gap-2">
                    <Label for="quantity" class="text-lg">Quantity</Label>
                    <Input
                        id="quantity"
                        type="number"
                        name="quantity"
                        required
                        :tabindex="5"
                        :default-value=props.product.quantity
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.quantity" />
                </div>

                <div class="grid gap-2">
                    <Label for="price_ht" class="text-lg">Price without Tax</Label>
                    <Input
                        id="price_ht"
                        type="number" 
                        name="price_ht"
                        step=".01"
                        required
                        :tabindex="5"
                        :default-value=props.product.price_ht
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.cost_price" />
                </div>

                <div class="flex flex-col gap-2">
                    <p>Price with tax :</p>
                    <data class="price-with-tax" :value=props.priceWithTax>{{ props.priceWithTax }}</data>
                </div>

                <div class="grid gap-2">
                    <Label for="cost_price" class="text-lg">Cost price</Label>
                    <Input
                        id="cost_price"
                        type="number" 
                        name="cost_price"
                        step=".01"
                        required
                        :tabindex="5"
                        :default-value=props.product.cost_price
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.cost_price" />
                </div>

                <div>
                    <Label for="taxRuleGroups" class="text-base">Select a tax rule group :</Label>
                    <select v-model="selectedTaxRuleGroup" id="taxRuleGroups" name="taxRuleGroups" class="border-2 rounded-md">
                        <option v-for="taxRuleGroup in taxRuleGroups" :value="taxRuleGroup.id" :key="taxRuleGroup.id">{{ taxRuleGroup.name }}</option>
                    </select>
                    <input id="tax_rule_group_id" name="tax_rule_group_id" type="hidden" :value=selectedTaxRuleGroup>
                </div>

                <section id="admin-product-details-footer" class="flex flex-row gap-4 py-8">
                    <Button
                    type="submit"
                    class="w-20 bg-black text-white"
                    :tabindex="5"
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