<script setup lang="ts">
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import { Autoplay } from 'swiper/modules';

const onSwiper = (swiper: any) => {
console.log(swiper);
};
const onSlideChange = () => {
console.log('slide change');
};
</script>

<template>
    <div class="w-full h-[37.5rem] mb-8 space-y-0.5 flex gap-2">
        <swiper
            :modules="[Autoplay]"
            :autoplay="{
                delay: 10000,
                disableOnInteraction: false
            }"
            :loop="true"
            :slides-per-view="1"
            :space-between="50"
            @swiper="onSwiper"
            @slideChange="onSlideChange"
        >
            <swiper-slide>
                <figure class="h-[37.5rem]">
                    <img src="/storage/img/hero/Hero_Chinese_New_Year_2026.png" alt="Chinese New Year Horse Hero Image" class="h-[37.5rem]" fetchPriority="high">
                </figure>
            </swiper-slide>
            <swiper-slide>
                <figure class="h-[37.5rem]">
                    <img src="/storage/img/hero/Hero_Test_Image_1.png" alt="Hero Test Image" class="h-[37.5rem]" fetchPriority="high">
                </figure>
            </swiper-slide>
            <swiper-slide>
                <figure class="h-[37.5rem]">
                    <img src="/storage/img/hero/Hero_Test_Image_2.png" alt="Hero Test Image" class="h-[37.5rem]" fetchPriority="high">
                </figure>
            </swiper-slide>
        </swiper>
    </div>
</template>