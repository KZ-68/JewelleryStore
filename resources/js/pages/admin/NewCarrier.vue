<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminCarrierCreateForm from '@/components/jewellery_store/form/AdminCarrierCreateForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import { showCarriers } from '@/routes/admin/back-office';

interface NewCarrierProps {
  locale: string
}  

const props = defineProps<NewCarrierProps>()
</script>


<template>
  <Head title='New Carrier'/>
  <AppLayout :locale="props.locale">
    <section id="new-carrier-page-wrapper" class="flex flex-col mx-2">
      <hgroup id="new-carrier-page-top" class="mx-4 mt-8 mb-4">
        <h1 id="new-carrier-page-heading" class="text-xl">Add a new carrier</h1>            
      </hgroup>
      <AdminCarrierCreateForm classname="" :locale="props.locale"></AdminCarrierCreateForm>
      <Link :href="showCarriers({locale: props.locale})" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
        Back to carriers list
      </Link>
    </section>
  </AppLayout>
</template>