<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminCategoryCreateForm from '@/components/jewellery_store/form/AdminCategoryCreateForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import { showCategories } from '@/routes/admin/back-office';
import { TreeNode } from '@/types/treenode';

interface NewCategoryProps {
    categories: Array<TreeNode[]>
}  

const props = defineProps<NewCategoryProps>()
</script>

<template>
    <Head title='New Category'/>
    <AppLayout>
        <section id="new-product-page-wrapper" class="flex flex-col mx-2">
            <hgroup id="new-product-page-top" class="mx-4 mt-8 mb-4">
                <h1 id="new-product-page-heading" class="text-xl">Add a new category</h1>
            </hgroup>
            <AdminCategoryCreateForm classname="" :categories=props.categories></AdminCategoryCreateForm>
            <Link :href="showCategories()" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                Back to products list
            </Link>
        </section>
    </AppLayout>
</template>