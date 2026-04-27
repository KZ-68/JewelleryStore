<script setup lang="ts">
import SettingsLayout from '@/layouts/settings/Layout.vue';
import AddressCreateForm from '@/components/jewellery_store/form/AddressCreateForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import { showAddresses } from '@/routes/addresses';
import { Country } from '@/types/country';

interface NewAddressProps {
  countries: Country[]
  locale: string
}  

const props = defineProps<NewAddressProps>()
</script>


<template>
  <Head title='New Address'/>
  <SettingsLayout :locale="props.locale">
    <section id="new-carrier-page-wrapper" class="flex flex-col mx-2">
      <hgroup id="new-carrier-page-top" class="mx-4 mt-8 mb-4">
        <h1 id="new-carrier-page-heading" class="text-xl">Add a new address</h1>            
      </hgroup>
      <AddressCreateForm classname="" :countries="countries" :locale="props.locale"></AddressCreateForm>
      <Link :href="showAddresses({locale: props.locale})" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
        Back to addresses list
      </Link>
    </section>
  </SettingsLayout>
</template>