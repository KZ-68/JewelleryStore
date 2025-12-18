<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminCustomerMainForm from '@/components/jewellery_store/form/AdminCustomerMainForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import type { Customer } from '@/types/customer'
import { showCustomers } from '@/routes/admin/back-office';

interface CustomerAdminSettings {
  customer: Customer
}  

const props = defineProps<CustomerAdminSettings>()
</script>


<template>
    <Head :title=props.customer.name />
    <AppLayout>
      <AdminCustomerMainForm classname="" :customer=props.customer></AdminCustomerMainForm>
      <Link :href="showCustomers()" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
          Back to customers list
      </Link>
    </AppLayout>
</template>