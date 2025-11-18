<script setup lang="ts">
import ProductFrontController from '@/actions/App/Http/Controllers/Admin/ProductFrontController';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form } from '@inertiajs/vue3';

interface AdminProductCreateFormProps {
    classname:string;
}   

const props = defineProps<AdminProductCreateFormProps>();
</script>

<template>
    <section id="new-admin-product-form-wrapper" class="my-2 mx-4 max-w-[900px] flex-start p-8 gap-1 rounded-lg bg-white p-1 dark:bg-neutral-800">
        <Form
            v-bind="ProductFrontController.create.form()"
            :reset-on-success="['product-details']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name" class="text-lg">Product Name</Label>
                    <Input
                        id="name"
                        type="text"
                        name="name"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.name" />
                </div>

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
                        placeholder="Add the product reference..."
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
                        placeholder="How many products ?"
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.quantity" />
                </div>

                <div class="grid gap-2">
                    <Label for="retailPrice" class="text-lg">Retail Price</Label>
                    <Input
                        id="retail-price"
                        type="number" 
                        name="retailPrice"
                        step="0.0"
                        required
                        :tabindex="5"
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.retailPrice" />
                </div>

                <div class="grid gap-2">
                    <Label for="active" class="text-lg">Activate Product</Label>
                    <select id="active" name="active" required>
                        <option :value=0 :selected=true>No</option>
                        <option :value=1>Yes</option>
                    </select>
                </div>

                <section id="new-admin-product-details-footer" class="flex flex-row gap-4 py-8">
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