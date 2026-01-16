<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminTaxRuleGroupMainForm from '@/components/jewellery_store/form/AdminTaxRuleGroupMainForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import type { TaxRuleGroup } from '@/types/taxRuleGroup'
import type { TaxRule } from '@/types/taxRule'
import type { Tax } from '@/types/tax'
import { showTaxes } from '@/routes/admin/back-office';
import { Country } from '@/types/country';

interface TaxRuleGroupDetails {
  taxRuleGroup: TaxRuleGroup
  taxRules: TaxRule[]
  countries: Country[]
  taxes: Tax[]
}  

const props = defineProps<TaxRuleGroupDetails>()
</script>


<template>
    <Head :title=props.taxRuleGroup.name />
    <AppLayout>
      <AdminTaxRuleGroupMainForm classname="" :taxRuleGroup=props.taxRuleGroup :taxRules="props.taxRules" :countries=props.countries :taxes="props.taxes"></AdminTaxRuleGroupMainForm>
      <Link :href="showTaxes()" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
          Back to taxes list
      </Link>
    </AppLayout>
</template>