<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminTaxMainForm from '@/components/jewellery_store/form/AdminTaxMainForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import type { Tax } from '@/types/tax'
import { showTaxes } from '@/routes/admin/back-office';

interface TaxDetailsProps {
  tax: Tax
  locale: string
}  

const props = defineProps<TaxDetailsProps>()
</script>


<template>
    <Head :title=props.tax.name />
    <AppLayout :locale="props.locale">
      <AdminTaxMainForm classname="" :tax=props.tax :locale="props.locale"></AdminTaxMainForm>
      <Link :href="showTaxes({locale: props.locale})" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
          Back to taxes list
      </Link>
    </AppLayout>
</template>