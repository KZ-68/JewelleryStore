<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { Manufacturer } from '@/types/manufacturer'
import ManufacturersList from '@/components/jewellery_store/list/manufacturers/ManufacturersList.vue'

interface ManufacturersProps {
  manufacturers: Manufacturer[]
}

const props = defineProps<ManufacturersProps>()
</script>

<template>
    <Head title="Manufacturers" />
    <div id="manufacturers-page-wrapper"  class="items-center min-h-screen bg-[#FDFDFC] p-10 text-[#1b1b18] lg:justify-center lg:p-14 bg-neutral-200 dark:bg-[#0a0a0a]">
      <ManufacturersList
        classname=""
        :manufacturers=props.manufacturers
      />
    </div>
</template>