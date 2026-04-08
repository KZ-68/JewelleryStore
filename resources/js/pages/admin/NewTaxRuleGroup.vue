<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminTaxRuleGroupCreateForm from '@/components/jewellery_store/form/AdminTaxRuleGroupCreateForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import { showTaxes } from '@/routes/admin/back-office';
import { Country } from '@/types/country';
import { Tax } from '@/types/tax';

interface NewTaxProps {
  countries: Country[]
  taxes: Tax[]
  locale: string
}  

const props = defineProps<NewTaxProps>()
</script>


<template>
  <Head title='New Tax'/>
  <AppLayout :locale="props.locale">
    <section id="new-product-page-wrapper" class="flex flex-col mx-2">
      <hgroup id="new-tax-page-top" class="mx-4 mt-8 mb-4">
        <h1 id="new-tax-page-heading" class="text-xl">Add a new tax</h1>
      </hgroup>
      <AdminTaxRuleGroupCreateForm classname="" :countries=props.countries :taxes=props.taxes :locale="props.locale"></AdminTaxRuleGroupCreateForm>
      <Link :href="showTaxes({locale: props.locale})" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
        Back to taxes list
      </Link>
    </section>
  </AppLayout>
</template>