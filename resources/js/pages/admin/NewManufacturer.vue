<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminManufacturerCreateForm from '@/components/jewellery_store/form/AdminManufacturerCreateForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import { showManufacturers } from '@/routes/admin/back-office';

interface NewManufacturerProps {
}  

const props = defineProps<NewManufacturerProps>()
</script>


<template>
  <Head title='New Manufacturer'/>
  <AppLayout>
    <section id="new-manufacturer-page-wrapper" class="flex flex-col mx-2">
      <hgroup id="new-manufacturer-page-top" class="mx-4 mt-8 mb-4">
        <h1 id="new-manufacturer-page-heading" class="text-xl">Add a new manufacturer</h1>            
      </hgroup>
      <AdminManufacturerCreateForm classname=""></AdminManufacturerCreateForm>
      <Link :href="showManufacturers()" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
        Back to manufacturers list
      </Link>
    </section>
  </AppLayout>
</template>