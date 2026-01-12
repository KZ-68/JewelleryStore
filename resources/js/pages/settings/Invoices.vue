<script setup lang="ts">
import { Head, Link} from '@inertiajs/vue3';
import type { Invoice } from '@/types/invoice'
import InvoicesList from '@/components/jewellery_store/list/invoices/InvoicesList.vue'
import SettingsLayout from '@/layouts/settings/Layout.vue';

interface InvoicesProps {
  invoices: Invoice[]
}

const props = defineProps<InvoicesProps>()
</script>

<template>
    <Head title="Your Invoices" />
    <SettingsLayout>
      <div id="invoices-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 dark:bg-[#0a0a0a]">
        <h2 class="text-3xl my-6">Your Invoices</h2>
        <InvoicesList
          classname=""
          :invoices=props.invoices
        />
      </div>
    </SettingsLayout>
</template>