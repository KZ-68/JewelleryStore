<script setup lang="ts">
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';
</script>

<template>
    <footer class="w-full lg:h-[28rem] px-4 lg:px-60 flex flex-col items-center lg:items-start justify-around bg-[#84070F] text-[#FEE3A6]">
        <div id="shop-footer-navigations" class="flex flex-col lg:flex-row items-center lg:items-baseline gap-3 lg:gap-36">
            <nav class="flex flex-col items-start gap-4 py-6">
                <h3 class="text-xl">About Us</h3>
                <a :href="route('contact.create', {}, false, Ziggy)">Contact Us</a>
            </nav>
            <nav class="flex flex-col items-center lg:items-start gap-4 py-6">
                <h3 class="text-xl">Customer Services</h3>
                <a href="#">Shipping</a>
                <a href="#">Help</a>
            </nav>
            <nav class="flex flex-col items-center lg:items-start gap-4 py-6">
                <h3 class="text-xl">Social Media</h3>
                <a href="#"></a>
                <a href="#"></a>
            </nav>
        </div>
        <section id="shop-footer-reassurance" class="flex flex-col items-center lg:items-start">
            <h3 class="text-xl my-2">Available payment methods</h3>
            <div class="flex flex-row flex-wrap gap-4 w-fit lg:w-full mx-6 lg:mx-0">
                <figure>
                    <img src="/storage/img/icons/payments/1_small.png" alt="">
                </figure>
                <figure>
                    <img src="/storage/img/icons/payments/2_small.png" alt="">
                </figure>
                <figure>
                    <img src="/storage/img/icons/payments/3_small.png" alt="">
                </figure>
                <figure>
                    <img src="/storage/img/icons/payments/4_small.png" alt="">
                </figure>
                <figure>
                    <img src="/storage/img/icons/payments/5_small.png" alt="">
                </figure>
                <figure>
                    <img src="/storage/img/icons/payments/16_small.png" alt="">
                </figure>
                <figure>
                    <img src="/storage/img/icons/payments/22_small.png" alt="">
                </figure>
            </div>
        </section>
        <nav class="flex flex-col items-center lg:items-start lg:flex-row my-8 lg:my-0 gap-3">
            <a href="#">Sitemap</a>
            <a href="#">Terms and conditions</a>
            <a :href="route('privacy', {}, false, Ziggy)">Privacy Policy</a>
        </nav>
    </footer>
</template>