<script setup lang="ts">
import CategoryFrontController from '@/actions/App/Http/Controllers/Admin/CategoryFrontController';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form } from '@inertiajs/vue3';
import { ref } from "vue";
import type { TreeNode } from '@/types/treenode';
import Tree from "vue3-treeview";
import { checkMode } from '@/types/IConfiguration';
import 'vue3-treeview/dist/style.css';
import { Category } from '@/types/category';

interface AdminCategoryMainFormProps {
    classname:string;
    categories: Array<TreeNode[]>
    root: Category
}   

const props = defineProps<AdminCategoryMainFormProps>();

const categories = Object.assign({}, ...props.categories);

const config = ref({
    roots: ["1"],
    checkboxes: true,
    dragAndDrop: false,
    checkMode: checkMode.manual,
    keyboardNavigation: false,
})

const parentCategory = ref({
    parent_id: null as number | string | null,
})

// Get the parent category selected
function selectParentCategory(id: number) {
    parentCategory.value.parent_id = id
}

function resetSelectedParent() {
    parentCategory.value.parent_id = null
}

function log(s: string): void {
    console.log(s);
}
</script>

<template>
    <section id="admin-category-form-wrapper" class="my-2 mx-4 max-w-[900px] flex-start p-8 gap-1 rounded-lg bg-white p-1 dark:bg-neutral-800">
        <Form
            v-bind="CategoryFrontController.create.form()"
            :reset-on-success="['category-details']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name" class="text-lg">Category Name</Label>
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
                    <Label for="description" class="text-lg">Category Description</Label>
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

                <section id="category-tree">
                    <Label for="parent_id" class="text-lg my-2">Choose a parent category</Label>
                    <div class="border-black border-[2px] rounded-md p-2">
                        <Tree
                            :nodes=categories
                            :config="config"
                            @node-opened="log(`node-opened`)"
                            @node-closed="log('node-closed')"
                            @node-focus="log('node-focus')"
                            @node-toggle="log('node-toggle')"
                            @node-blur="log('node-blur')"
                            @node-edit="log('node-edit')"
                            @node-checked="selectParentCategory($event.id)"
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

                <input id="parent_id" name="parent_id" type="hidden" :value=parentCategory.parent_id>

                <section id="admin-category-details-footer" class="flex flex-row gap-4 py-8">
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