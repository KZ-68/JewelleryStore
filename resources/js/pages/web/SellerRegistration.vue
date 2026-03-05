<script setup lang="ts">
import SellerRegisterForm from '@/components/jewellery_store/form/SellerRegisterForm.vue';

interface SellerRegistrationProps {
    classname:string
    status?: string;
}   

const props = defineProps<SellerRegistrationProps>();
</script>

<template>
    <section id="seller-registration-section">
        <SellerRegisterForm></SellerRegisterForm>
    </section>
</template>
