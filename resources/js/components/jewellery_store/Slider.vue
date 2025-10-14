<script setup lang="ts">
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import { Autoplay } from 'swiper/modules';

interface SliderProps {
    classname:string;
    title: string;
    total?: number;
}
    
const onSwiper = (swiper: any) => {
console.log(swiper);
};
const onSlideChange = () => {
console.log('slide change');
};

defineProps<SliderProps>();
</script>

<template>
    <div class="mb-8 space-y-0.5 flex gap-2">
        <swiper
            :modules="[Autoplay]"
            :autoplay="{
            delay: 3000,
            disableOnInteraction: false
            }"
            :loop="true"
            :slides-per-view="3"
            :space-between="50"
            @swiper="onSwiper"
            @slideChange="onSlideChange"
        >
        <swiper-slide>Slide 1</swiper-slide>
        <swiper-slide>Slide 2</swiper-slide>
        <swiper-slide>Slide 3</swiper-slide>
    
        </swiper>
    </div>
</template>