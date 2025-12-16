<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminCategoryMainForm from '@/components/jewellery_store/form/AdminCategoryMainForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import type { Category } from '@/types/category';
import { showCategories } from '@/routes/admin/back-office';
import { TreeNode } from '@/types/treenode';

interface CategoryDetailsProps {
  category: Category
  categories: Array<TreeNode[]>
}  

const props = defineProps<CategoryDetailsProps>()
</script>


<template>
    <Head :title=props.category.name />
    <AppLayout>
      <AdminCategoryMainForm classname="" :category=props.category :categories=props.categories></AdminCategoryMainForm>
      <Link :href="showCategories()" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
          Back to categories list
      </Link>
    </AppLayout>
</template>