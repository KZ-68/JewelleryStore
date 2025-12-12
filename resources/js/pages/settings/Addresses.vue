<script setup lang="ts">
import { Head, Link} from '@inertiajs/vue3';
import type { Address } from '@/types/address'
import AddressesList from '@/components/jewellery_store/list/addresses/AddressesList.vue'
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { newAddress } from '@/actions/App/Http/Controllers/Web/AddressFrontController';

interface AddressesProps {
  addresses: Address[]
}

const props = defineProps<AddressesProps>()
</script>

<template>
    <Head title="Your Addresses" />
    <SettingsLayout>
      <div id="addresses-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 dark:bg-[#0a0a0a]">
        <h2 class="text-3xl my-6">Your Addresses</h2>
        <section id="addresses-top-wrapper" class="flex flex-row justify-between items-center">
          <nav id="addresses-top-nav" class="flex flex-row">
            <Link
                :href="newAddress()"
                class="inline-block rounded-md border px-5 py-3 text-sm leading-normal bg-black text-white dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
            >
                Add a new address
            </Link>
          </nav>
        </section>
        
        <AddressesList
          classname=""
          :addresses=props.addresses
        />
      </div>
    </SettingsLayout>
</template>