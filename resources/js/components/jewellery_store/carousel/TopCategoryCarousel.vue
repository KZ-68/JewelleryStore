<script setup lang="ts">
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import { Navigation } from 'swiper/modules';
import { useTrans } from "@/composables/trans";

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
                    <swiper-slide role="group" aria-label="1 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full" src="" alt="">
                                </figure>
                                <h3 class="content_title">{{ useTrans('Rings') }}</h3>
                                <a class="content_button" href="">{{ useTrans('Shop Rings') }}</a>
                            </div>
                        </div>
                    </swiper-slide>
                
                    <swiper-slide role="group" aria-label="2 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full" src="" alt="">
                                </figure>
                                <h3 class="content_title">{{ useTrans('Necklaces') }}</h3>
                                <a class="content_button" href="">{{ useTrans('Shop Necklaces') }}</a>   
                            </div>
                        </div>
                    </swiper-slide>
                
                    <swiper-slide role="group" aria-label="3 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full" src="/storage/img/home/carousel/gold_oriental_earrings.png" alt="">
                                </figure>
                                <h3 class="content_title">{{ useTrans('Earrings') }}</h3>
                                <a class="content_button" href="">{{ useTrans('Shop earrings') }}</a>
                            </div>
                        </div>
                    </swiper-slide>
                
                    <swiper-slide role="group" aria-label="4 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full" src="" alt="">
                                </figure>
                                <h3 class="">{{ useTrans('Bangles') }}</h3>
                                <a class="content_button" href="">{{ useTrans('Shop Bangles') }}</a>
                            </div>
                        </div>
                    </swiper-slide>
                    
                    <swiper-slide role="group" aria-label="5 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full" src="/storage/img/home/carousel/gold_oriental_pendant.png" alt="">
                                </figure>
                                <h3 class="content_title">{{ useTrans('Pendants') }}</h3>
                                <a class="content_button" href="#">{{ useTrans('Shop Pendants') }}</a>
                            </div>
                        </div>
                    </swiper-slide>
                    
                    <swiper-slide role="group" aria-label="6 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full" src="/storage/img/home/carousel/gold_oriental_bracelet.jpg" alt="">
                                </figure>
                                <h3 class="content_title">{{ useTrans('Bracelets') }}</h3>
                                <a class="content_button" href="">{{ useTrans('Shop Bracelets') }}</a>
                            </div>
                        </div>
                    </swiper-slide>
                
                    <swiper-slide role="group" aria-label="7 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-4 md:mb-8 lg:mb-12 w-full" src="" alt="">
                                </figure>
                                <h3 class="content_title">{{ useTrans('Charms') }}</h3>
                                <a class="content_button" href="">{{ useTrans('Shop Charms') }}</a>
                            </div>
                        </div>
                    </swiper-slide>
                </swiper>
            </div>
        </div>
    </section>
</template>