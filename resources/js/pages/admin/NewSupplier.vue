<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminSupplierCreateForm from '@/components/jewellery_store/form/AdminSupplierCreateForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import { showSuppliers } from '@/routes/admin/back-office';

interface NewSupplierProps {
}  

const props = defineProps<NewSupplierProps>()
</script>


<template>
  <Head title='New Supplier'/>
  <AppLayout>
    <section id="new-product-page-wrapper" class="flex flex-col mx-2">
      <hgroup id="new-supplier-page-top" class="mx-4 mt-8 mb-4">
        <h1 id="new-supplier-page-heading" class="text-xl">Add a new supplier</h1>
      </hgroup>
      <AdminSupplierCreateForm classname=""></AdminSupplierCreateForm>
      <Link :href="showSuppliers()" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
        Back to suppliers list
      </Link>
    </section>
  </AppLayout>
</template>