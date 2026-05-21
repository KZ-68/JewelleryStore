<script setup lang="ts">
import ProductFrontController from '@/actions/App/Http/Controllers/Admin/ProductFrontController';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form } from '@inertiajs/vue3';
import { ref } from "vue";
import type { TreeNode } from '@/types/treenode';
import Tree from "vue3-treeview";
import { checkMode } from '@/types/IConfiguration';
import 'vue3-treeview/dist/style.css';

interface AdminProductCreateFormProps {
    classname:string;
    categories: Array<TreeNode[]>
    locale: string
}

const props = defineProps<AdminProductCreateFormProps>();
const categories = Object.assign({}, ...props.categories);

const imagePreview = ref<string | null>(null);

function onImageChange(event: Event) {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0];
    if (!file) {
        imagePreview.value = null;
        return;
    }
    imagePreview.value = URL.createObjectURL(file);
}

const config = ref({
    roots: ["1"],
    checkboxes: true,
    dragAndDrop: false,
    checkMode: checkMode.manual,
    keyboardNavigation: false,
})

const category = ref({
    category_id: null as number | string | null,
})

const categoriesSelected = ref([]);

// Get the parent category selected
function selectParentCategory(id: number, event: object) {
    if(event.children.length > 0) {
        event.children.forEach((child: any) => {
            categoriesSelected.value.push(child);
        });
    } else {
        category.value.category_id = id
    }
}

function resetSelectedParent() {
    category.value.category_id = null
}

function log(s: string): void {
    console.log(s);
}
</script>

<template>
    <section id="new-admin-product-form-wrapper" class="w-full my-2 mx-auto max-w-[900px] p-4 sm:p-6 md:p-8 rounded-lg bg-white dark:bg-neutral-800">
        <Form
            v-bind="ProductFrontController.create.form({locale: props.locale})"
            :reset-on-success="['product-details']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
            enctype="multipart/form-data"
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
                        class="w-full text-xl sm:text-2xl h-10"
                    />
                    <InputError :message="errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="description" class="text-lg">Product Description</Label>
                    <textarea
                        id="product-description"
                        name="description"
                        rows="5"
                        min="3"
                        max="500"
                        autofocus
                        :tabindex="2"
                        placeholder="Add a description..."
                        class="w-full bg-gray-100 p-2 rounded-md resize-y dark:bg-neutral-700 dark:text-gray-100"
                    />
                    <InputError :message="errors.description" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                            class="w-full bg-gray-100 p-2 rounded-md"
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
                            class="w-full bg-gray-100 p-2 rounded-md"
                        />
                        <InputError :message="errors.ean13" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="grid gap-2">
                        <Label for="quantity" class="text-lg">Quantity</Label>
                        <Input
                            id="quantity"
                            type="number"
                            name="quantity"
                            required
                            :tabindex="5"
                            placeholder="How many ?"
                            class="w-full bg-gray-100 p-2 rounded-md"
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
                            :tabindex="6"
                            class="w-full bg-gray-100 p-2 rounded-md"
                        />
                        <InputError :message="errors.price_ht" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="cost_price" class="text-lg">Cost price</Label>
                        <Input
                            id="retail-price"
                            type="number"
                            name="cost_price"
                            step=".01"
                            required
                            :tabindex="7"
                            class="w-full bg-gray-100 p-2 rounded-md"
                        />
                        <InputError :message="errors.cost_price" />
                    </div>
                </div>

                <div class="grid gap-2">
                    <Label for="active" class="text-lg">Activate Product</Label>
                    <select id="active" name="active" required class="w-full bg-gray-100 p-2 rounded-md border border-gray-200 dark:bg-neutral-700 dark:text-gray-100">
                        <option :value=0 :selected=true>No</option>
                        <option :value=1>Yes</option>
                    </select>
                </div>

                <div class="grid gap-2">
                    <Label for="image" class="text-lg">Product Image</Label>
                    <input
                        id="image"
                        type="file"
                        name="image"
                        accept="image/jpeg,image/png,image/gif,image/webp"
                        :tabindex="8"
                        class="w-full bg-gray-100 p-2 rounded-md file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-black file:text-white file:cursor-pointer"
                        @change="onImageChange"
                    />
                    <img
                        v-if="imagePreview"
                        :src="imagePreview"
                        alt="Product image preview"
                        class="mt-2 max-h-48 rounded-md object-contain border border-gray-200"
                    />
                    <InputError :message="errors.image" />
                </div>

                <section id="category-tree">
                    <Label for="parent_id" class="text-lg my-2">Attach one or more categories</Label>
                    <div class="border-black border-[2px] rounded-md p-2 overflow-x-auto">
                        <Tree
                            :nodes=categories
                            :config="config"
                            @node-opened="log(`node-opened`)"
                            @node-closed="log('node-closed')"
                            @node-focus="log('node-focus')"
                            @node-toggle="log('node-toggle')"
                            @node-blur="log('node-blur')"
                            @node-edit="log('node-edit')"
                            @node-checked="selectParentCategory($event.id, $event)"
                            @node-unchecked="resetSelectedParent()"
                            @node-dragstart="log('node-dragstart')"
                            @node-dragenter="log('node-dragenter')"
                            @node-dragleave="log('node-dragleave')"
                            @node-dragend="log('node-dragend')"
                            @node-over="log('node-over')"
                            @node-drop="log('node-drop')"
                        />
                    </div>
                </section>

                <input id="category_id" name="category_id" type="hidden" :value=category.category_id>
                <input id="categories_selected" name="categories_selected" type="hidden" :value=JSON.stringify(categoriesSelected)>

                <section id="new-admin-product-details-footer" class="flex flex-row gap-4 pt-4 pb-2">
                    <Button
                        type="submit"
                        class="w-full sm:w-auto px-8 bg-black text-white"
                        :tabindex="9"
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
