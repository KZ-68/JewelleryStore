<script setup lang="ts">
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import { Navigation } from 'swiper/modules';
import { Product } from "@/types/product";
import ProductCard from "../card/ProductCard.vue";

interface TopProductCarouselProps {
    topProducts: Product[]
}

const props = defineProps<TopProductCarouselProps>();
</script>

<template>
    <section id="top-product-carousel-section" class="w-7xl">
        <div id="top-product-carousel-wrapper">
            <hgroup id="top-product-carousel-heading">
                <h2 class="px-3 py-14 font-bold text-3xl">Top Products</h2>
            </hgroup>
            <div class="pl-6">
                <swiper :navigation="true" :modules="[Navigation]" :slides-per-view="4" :space-between="10" class="mySwiper">
                    <swiper-slide v-for="topProduct in props.topProducts" :key="topProduct.id">
                        <ProductCard classname="" :product="topProduct" :image="topProduct.image"></ProductCard>
                    </swiper-slide>
                </swiper>
            </div>
        </div>
    </section>
</template>