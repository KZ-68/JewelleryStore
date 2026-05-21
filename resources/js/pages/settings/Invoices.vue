<script setup lang="ts">
import { Head} from '@inertiajs/vue3';
import type { Invoice } from '@/types/invoice'
import InvoicesList from '@/components/jewellery_store/list/invoices/InvoicesList.vue'
import SettingsLayout from '@/layouts/settings/Layout.vue';

interface InvoicesProps {
  invoices: Invoice[]
  locale: string
}

const props = defineProps<InvoicesProps>()
</script>

<template>
    <Head title="Your Invoices" />
    <SettingsLayout :locale="props.locale" :wide="true">
      <div class="w-full">
        <h2 class="text-3xl mb-6">Your Invoices</h2>
        <InvoicesList
          classname=""
          :invoices="props.invoices"
          :locale="props.locale"
        />
      </div>
    </SettingsLayout>
</template>