<script setup lang="ts">
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';
</script>

<template>
    <footer class="w-full h-[28rem] px-60 flex flex-col items-start justify-around bg-[#84070F] text-[#FEE3A6]">
        <div id="shop-footer-navigations" class="flex flex-row gap-36">
            <nav class="flex flex-col items-start gap-4 py-6">
                <h3 class="text-xl">About Us</h3>
                <a :href="route('contact.create', {}, false, Ziggy)">Contact Us</a>
            </nav>
            <nav class="flex flex-col items-start gap-4 py-6">
                <h3 class="text-xl">Customer Services</h3>
                <a href="#">Shipping</a>
                <a href="#">Help</a>
            </nav>
            <nav class="flex flex-col items-start gap-4 py-6">
                <h3 class="text-xl">Social Media</h3>
                <a href="#"></a>
                <a href="#"></a>
            </nav>
        </div>
        <section id="shop-footer-reassurance" class="flex flex-col">
            <h3 class="text-xl my-2">Available payment methods</h3>
            <div class="flex flex-row gap-4">
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
        <nav class="flex flex-row gap-3">
            <a href="#">Sitemap</a>
            <a href="#">Terms and conditions</a>
            <a :href="route('privacy', {}, false, Ziggy)">Privacy Policy</a>
        </nav>
    </footer>
</template>