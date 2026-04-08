<script setup lang="ts">
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import { Navigation } from 'swiper/modules';
import { Product } from "@/types/product";
import { useWindowSize } from '@vueuse/core'

const { width } = useWindowSize()
</script>

<template>
    <section id="top-categories-carousel-section" class="w-sm lg:w-2xl xl:w-7xl">
        <div id="top-categories-carousel-wrapper">
            <hgroup id="top-categories-carousel-heading" class="my-14">
                <h2 class="text-2xl my-3 mx-4 text-center">Top Categories</h2>
            </hgroup>
            <div class="py-2 lg:pl-6">
                <swiper class="mySwiper" :navigation="true" :modules="[Navigation]" :slides-per-view="3" :space-between="20">
                    <swiper-slide class="max-w-[413px]" role="group" aria-label="1 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full" src="" alt="">
                                </figure>
                                <h3 class="content_title">Rings</h3>
                                <a class="content_button" href="">Shop Rings</a>
                            </div>
                        </div>
                    </swiper-slide>
                
                    <swiper-slide class="max-w-[413px]" role="group" aria-label="2 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full" src="" alt="">
                                </figure>
                                <h3 class="content_title">Necklaces</h3>
                                <a class="content_button" href="">Shop Necklaces</a>   
                            </div>
                        </div>
                    </swiper-slide>
                
                    <swiper-slide class="max-w-[413px]" role="group" aria-label="3 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full" src="/storage/img/home/carousel/gold_oriental_earrings.png" alt="">
                                </figure>
                                <h3 class="content_title">Earrings</h3>
                                <a class="content_button" href="">Shop earrings</a>
                            </div>
                        </div>
                    </swiper-slide>
                
                    <swiper-slide class="max-w-[413px]" role="group" aria-label="4 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full" src="" alt="">
                                </figure>
                                <h3 class="">Bangles</h3>
                                <a class="content_button" href="">Shop Bangles</a>
                            </div>
                        </div>
                    </swiper-slide>
                    
                    <swiper-slide class="max-w-[413px]" role="group" aria-label="5 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full" src="/storage/img/home/carousel/gold_oriental_pendant.png" alt="">
                                </figure>
                                <h3 class="content_title">Pendants</h3>
                                <a class="content_button" href="#">Shop Pendants</a>
                            </div>
                        </div>
                    </swiper-slide>
                    
                    <swiper-slide class="max-w-[413px]" role="group" aria-label="6 / 7">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full" src="/storage/img/home/carousel/gold_oriental_bracelet.jpg" alt="">
                                </figure>
                                <h3 class="content_title">Bracelets</h3>
                                <a class="content_button" href="">Shop Bracelets</a>
                            </div>
                        </div>
                    </swiper-slide>
                
                    <swiper-slide class="max-w-[413px]" role="group" aria-label="7 / 7max-w-[413px]">
                        <div class="content-list">
                            <div class="content">
                                <figure class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full">
                                    <img class="aspect-square bg-[#d7d4d1] bg-center bg-cover mb-12 max-w-[413px] w-full" src="" alt="">
                                </figure>
                                <h3 class="content_title">Charms</h3>
                                <a class="content_button" href="">Shop Charms</a>
                            </div>
                        </div>
                    </swiper-slide>
                </swiper>
            </div>
        </div>
    </section>
</template>