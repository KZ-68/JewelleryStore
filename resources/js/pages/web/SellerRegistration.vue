<script setup lang="ts">
import SellerRegisterForm from '@/components/jewellery_store/form/SellerRegisterForm.vue';

interface SellerRegistrationProps {
    classname:string
    status?: string;
}   

const props = defineProps<SellerRegistrationProps>();
</script>

<template>
    <main class="flex flex-row bg-gray-100 rounded-xl border-t-[1px] border-gray-100">
        <section id="seller-registration-section" class="lg:ml-10 lg:my-10 lg:px-10 lg:py-10 rounded-l-xl lg:w-50/50 bg-white">
            <SellerRegisterForm></SellerRegisterForm>
        </section>
        <aside id="seller-form-background" class="lg:mr-10 lg:my-10 lg:w-50/50 lg:h-5xl">
            <figure id="seller-form-figure" class="lg:h-full">
                <img src="/storage/img/forms/elegant-tea-party-assortment_original.jpg" alt="Japanese Jewellery Stock Image" class="rounded-r-xl lg:h-full object-cover">
            </figure>
        </aside>
    </main>
</template>
