<script setup lang="ts">
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import { Autoplay } from 'swiper/modules';

const slides = [
    {
        webp:       '/storage/img/hero/Hero_Chinese_New_Year_2026.webp',
        webpMobile: '/storage/img/hero/Hero_Chinese_New_Year_2026_mobile.webp',
        fallback:   '/storage/img/hero/Hero_Chinese_New_Year_2026.png',
        alt:        'Chinese New Year Horse — Hero Image',
    },
    {
        webp:       '/storage/img/hero/Hero_Test_Image_1.webp',
        webpMobile: '/storage/img/hero/Hero_Test_Image_1_mobile.webp',
        fallback:   '/storage/img/hero/Hero_Test_Image_1.png',
        alt:        'Hero Image 1',
    },
    {
        webp:       '/storage/img/hero/Hero_Test_Image_2.webp',
        webpMobile: '/storage/img/hero/Hero_Test_Image_2_mobile.webp',
        fallback:   '/storage/img/hero/Hero_Test_Image_2.png',
        alt:        'Hero Image 2',
    },
]
</script>

<template>
    <div class="w-full h-36 sm:h-48 md:h-64 lg:h-[37.5rem] mb-8">
        <swiper
            :modules="[Autoplay]"
            :autoplay="{ delay: 10000, disableOnInteraction: false }"
            :loop="true"
            :slides-per-view="1"
            :space-between="0"
            class="h-full"
        >
            <swiper-slide
                v-for="(slide, index) in slides"
                :key="slide.webp"
                class="h-full"
            >
                <figure class="w-full h-full m-0">
                    <picture>
                        <source
                            media="(max-width: 767px)"
                            type="image/webp"
                            :srcset="slide.webpMobile"
                        />
                        <source
                            type="image/webp"
                            :srcset="slide.webp"
                        />
                        <img
                            :src="slide.fallback"
                            :alt="slide.alt"
                            class="w-full h-full object-cover"
                            :fetchpriority="index === 0 ? 'high' : 'auto'"
                            :loading="index === 0 ? 'eager' : 'lazy'"
                            decoding="async"
                        />
                    </picture>
                </figure>
            </swiper-slide>
        </swiper>
    </div>
</template>
