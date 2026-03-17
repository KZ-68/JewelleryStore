<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminCustomerCreateForm from '@/components/jewellery_store/form/AdminCustomerCreateForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import { showCustomers } from '@/routes/admin/back-office';
</script>


<template>
  <Head title='New Customer'/>
  <AppLayout>
    <section id="new-customer-page-wrapper" class="flex flex-col mx-2">
      <hgroup id="new-customer-page-top" class="mx-4 mt-8 mb-4">
        <h1 id="new-customer-page-heading" class="text-xl">Add a new customer</h1>
      </hgroup>
      <AdminCustomerCreateForm classname=""></AdminCustomerCreateForm>
      <Link :href="showCustomers()" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
        Back to customers list
      </Link>
    </section>
  </AppLayout>
</template>