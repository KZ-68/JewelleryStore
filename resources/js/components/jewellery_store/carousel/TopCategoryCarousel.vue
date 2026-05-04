<script setup lang="ts">
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import { Navigation } from 'swiper/modules';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { route } from '../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../ziggy.js';
import { useTrans } from "@/composables/trans";

const locale = computed(() => usePage().props.locale as string)

function categoryLink(slug: string): string {
    return route('showCategoryProducts', { locale: locale.value, category_slug: slug }, false, Ziggy)
}

const slides = [
    { slug: 'rings',     title: 'Rings',     button: 'Shop Rings',     img: '/storage/img/home/carousel/gold_oriental_rings.webp' },
    { slug: 'necklaces', title: 'Necklaces', button: 'Shop Necklaces', img: '/storage/img/home/carousel/gold_oriental_necklaces.avif' },
    { slug: 'earrings',  title: 'Earrings',  button: 'Shop earrings',  img: '/storage/img/home/carousel/gold_oriental_earrings.png' },
    { slug: 'bangles',   title: 'Bangles',   button: 'Shop Bangles',   img: '/storage/img/home/carousel/gold_oriental_bangles.webp' },
    { slug: 'pendants',  title: 'Pendants',  button: 'Shop Pendants',  img: '/storage/img/home/carousel/gold_oriental_pendant.png' },
    { slug: 'bracelets', title: 'Bracelets', button: 'Shop Bracelets', img: '/storage/img/home/carousel/gold_oriental_bracelet.jpg' },
    { slug: 'charms',    title: 'Charms',    button: 'Shop Charms',    img: '/storage/img/home/carousel/gold_oriental_charms.webp' },
]

const swiperBreakpoints = {
    0:    { slidesPerView: 1, spaceBetween: 10 },
    640:  { slidesPerView: 2, spaceBetween: 16 },
    1024: { slidesPerView: 3, spaceBetween: 20 },
}
</script>

<template>
    <section id="top-categories-carousel-section" class="w-full px-8 md:px-16 lg:px-28 xl:px-40">
        <div id="top-categories-carousel-wrapper">
            <hgroup id="top-categories-carousel-heading" class="my-8 md:my-14">
                <h2 class="text-xl md:text-2xl my-3 mx-4 text-center">{{ useTrans('Top Categories') }}</h2>
            </hgroup>
            <div class="py-2">
                <swiper class="mySwiper" :navigation="true" :modules="[Navigation]" :breakpoints="swiperBreakpoints">
                    <swiper-slide
                        v-for="(slide, index) in slides"
                        :key="slide.slug"
                        role="group"
                        :aria-label="`${index + 1} / ${slides.length}`"
                    >
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full" :src="slide.img" :alt="useTrans(slide.title)">
                                </figure>
                                <h3 class="content_title">{{ useTrans(slide.title) }}</h3>
                                <a class="content_button" :href="categoryLink(slide.slug)">{{ useTrans(slide.button) }}</a>
                            </div>
                        </div>
                    </swiper-slide>
                </swiper>
            </div>
        </div>
    </section>
</template>
