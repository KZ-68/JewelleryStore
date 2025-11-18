<script setup lang="ts">
import AdminProductMainForm from '@/components/jewellery_store/form/AdminProductMainForm.vue';
import { Head } from '@inertiajs/vue3';
import type { Product } from '@/types/product'

interface ProductDetailsProps {
  product: Product
}  

const props = defineProps<ProductDetailsProps>()
</script>


<template>
    <Head :title=props.product.name />
    
    <AdminProductMainForm classname="" :product=props.product></AdminProductMainForm>
</template>