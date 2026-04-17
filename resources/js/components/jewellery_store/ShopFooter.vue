<script setup lang="ts">
import * as CookieConsent from 'vanilla-cookieconsent';
import { useTrans } from '@/composables/trans';
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';

interface ShopFooterProps {
    locale: string
}

const props = defineProps<ShopFooterProps>();

const linkClass = 'hover:opacity-80 underline-offset-4 hover:underline transition-opacity focus:outline-none focus:ring-2 focus:ring-white rounded-sm'
</script>

<template>
    <footer class="w-full bg-shop-primary text-shop-secondary">
        <div class="max-w-screen-xl mx-auto px-6 lg:px-12 py-12 lg:py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 lg:gap-16">
                <nav aria-labelledby="footer-about-heading">
                    <h3 id="footer-about-heading" class="text-xl font-semibold mb-5">{{ useTrans('About Us') }}</h3>
                    <ul class="flex flex-col gap-3">
                        <li>
                            <a :href="route('contact.create', {locale: props.locale}, false, Ziggy)" :class="linkClass">
                                {{ useTrans('Contact Us') }}
                            </a>
                        </li>
                    </ul>
                </nav>

                <nav aria-labelledby="footer-services-heading">
                    <h3 id="footer-services-heading" class="text-xl font-semibold mb-5">{{ useTrans('Customer Services') }}</h3>
                    <ul class="flex flex-col gap-3">
                        <li>
                            <a href="#" :class="linkClass">{{ useTrans('Shipping') }}</a>
                        </li>
                        <li>
                            <a href="#" :class="linkClass">{{ useTrans('Help') }}</a>
                        </li>
                    </ul>
                </nav>

                <nav aria-labelledby="footer-social-heading">
                    <h3 id="footer-social-heading" class="text-xl font-semibold mb-5">{{ useTrans('Social Media') }}</h3>
                    <ul class="flex flex-row gap-5">
                        <li>
                            <a href="#" aria-label="Notre page Instagram" :class="linkClass">Instagram</a>
                        </li>
                        <li>
                            <a href="#" aria-label="Notre page Facebook" :class="linkClass">Facebook</a>
                        </li>
                    </ul>
                </nav>

            </div>

            <section aria-labelledby="footer-payment-heading" class="mt-10 pt-8 border-t border-white/20">
                <h3 id="footer-payment-heading" class="text-xl font-semibold mb-4">{{ useTrans('Available payment methods') }}</h3>
                <ul class="flex flex-row flex-wrap gap-3" role="list">
                    <li>
                        <figure>
                            <img src="/storage/img/icons/payments/1_small.png" alt="Visa" class="h-8">
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="/storage/img/icons/payments/2_small.png" alt="Mastercard" class="h-8">
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="/storage/img/icons/payments/3_small.png" alt="American Express" class="h-8">
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="/storage/img/icons/payments/4_small.png" alt="PayPal" class="h-8">
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="/storage/img/icons/payments/5_small.png" alt="Apple Pay" class="h-8">
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="/storage/img/icons/payments/16_small.png" alt="Google Pay" class="h-8">
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="/storage/img/icons/payments/22_small.png" alt="Klarna" class="h-8">
                        </figure>
                    </li>
                </ul>
            </section>

        </div>

        <div class="border-t border-white/20">
            <div class="max-w-screen-xl mx-auto px-6 lg:px-12 py-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                <nav aria-label="Informations légales" class="flex flex-wrap justify-center sm:justify-start gap-x-5 gap-y-2">
                    <a :href="route('sitemap', {locale: props.locale}, false, Ziggy)" :class="linkClass">Sitemap</a>
                    <a href="#" :class="linkClass">{{ useTrans('Terms and conditions') }}</a>
                    <a :href="route('privacy', {locale: props.locale}, false, Ziggy)" :class="linkClass">{{ useTrans('Privacy Policy') }}</a>
                    <button
                        type="button"
                        :class="linkClass"
                        @click="CookieConsent.showPreferences()"
                        :aria-label="useTrans('Cookie preferences')"
                    >
                        {{ useTrans('Cookie preferences') }}
                    </button>
                </nav>
                <small class="opacity-70 text-xs shrink-0">
                    &copy; {{ new Date().getFullYear() }} {{ useTrans('Joaillerie Orient. All rights reserved.') }}
                </small>
            </div>
        </div>

    </footer>
</template>
