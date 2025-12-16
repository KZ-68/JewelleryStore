<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminSupplierMainForm from '@/components/jewellery_store/form/AdminSupplierMainForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import type { Supplier } from '@/types/supplier'
import { showSuppliers } from '@/routes/admin/back-office';

interface SupplierDetailsProps {
  supplier: Supplier
}  

const props = defineProps<SupplierDetailsProps>()
</script>


<template>
    <Head :title=props.supplier.name />
    <AppLayout>
      <AdminSupplierMainForm classname="" :supplier=props.supplier></AdminSupplierMainForm>
      <Link :href="showSuppliers()" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
          Back to suppliers list
      </Link>
    </AppLayout>
</template>