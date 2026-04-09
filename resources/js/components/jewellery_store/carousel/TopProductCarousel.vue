<script setup lang="ts">
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import { Navigation } from 'swiper/modules';
import { Product } from "@/types/product";
import ProductCard from "../card/ProductCard.vue";
import { useTrans } from "@/composables/trans";

interface TopProductCarouselProps {
    topProducts: Product[]
    locale: string
}

const props = defineProps<TopProductCarouselProps>();

const swiperBreakpoints = {
    0:    { slidesPerView: 2, spaceBetween: 12 },
    768:  { slidesPerView: 3, spaceBetween: 16 },
    1024: { slidesPerView: 4, spaceBetween: 20 },
}
</script>

<template>
    <section id="top-product-carousel-section" class="w-full px-8 md:px-16 lg:px-28 xl:px-40">
        <div id="top-product-carousel-wrapper">
            <hgroup id="top-product-carousel-heading">
                <h2 class="py-10 md:py-14 font-bold text-2xl md:text-3xl">{{ useTrans('Top Products') }}</h2>
            </hgroup>
            <div class="py-2">
                <swiper :navigation="true" :modules="[Navigation]" :breakpoints="swiperBreakpoints" class="mySwiper">
                    <swiper-slide v-for="topProduct in props.topProducts" :key="topProduct.id">
                        <ProductCard classname="" :product="topProduct" :image="topProduct.image" sortBy="name" order="asc" :locale="props.locale"></ProductCard>
                    </swiper-slide>
                </swiper>
            </div>
        </div>
    </section>
</template>