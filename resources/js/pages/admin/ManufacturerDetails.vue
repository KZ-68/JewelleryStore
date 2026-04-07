<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminManufacturerMainForm from '@/components/jewellery_store/form/AdminManufacturerMainForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import type { Manufacturer } from '@/types/manufacturer'
import { showManufacturers } from '@/routes/admin/back-office';

interface ManufacturerDetailsProps {
  manufacturer: Manufacturer
  locale: string
}  

const props = defineProps<ManufacturerDetailsProps>()
</script>


<template>
    <Head :title=props.manufacturer.name />
    <AppLayout :locale="locale">
      <AdminManufacturerMainForm classname="" :manufacturer=props.manufacturer :locale="props.locale"></AdminManufacturerMainForm>
      <Link :href="showManufacturers({locale: props.locale})" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
          Back to manufacturers list
      </Link>
    </AppLayout>
</template>