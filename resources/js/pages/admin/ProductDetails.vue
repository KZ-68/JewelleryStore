<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminProductMainForm from '@/components/jewellery_store/form/AdminProductMainForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import type { Product } from '@/types/product'
import { showProducts } from '@/routes/admin/back-office';
import { TaxRuleGroup } from '@/types/taxRuleGroup';

interface ProductDetailsProps {
  product: Product
  taxRuleGroups: TaxRuleGroup[]
}  

const props = defineProps<ProductDetailsProps>()
</script>


<template>
    <Head :title=props.product.name />
    <AppLayout>
      <AdminProductMainForm classname="" :product=props.product :taxRuleGroups=props.taxRuleGroups></AdminProductMainForm>
      <div id="product-page-footer-wrapper" class="px-6 py-8">
            <nav id="product-nav-links" class="flex flex-row gap-4">
                 <Link :href="showProducts()" class="w-fit inline-block rounded-sm border border-[#19140035] px-5 py-1.5 mx-6 my-8 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                    Back to products list
                </Link>         
                <a href="#">Show product on store</a>
            </nav>
      </div>
    </AppLayout>
</template>