<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { route } from '../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '@/ziggy';
import { useTrans } from '@/composables/trans';

interface SellerRegistrationInvitationBanner {
    locale: string
}

const props = defineProps<SellerRegistrationInvitationBanner>();
</script>

<template>
    <section id="seller-invitation-section" class="bg-[url(storage/img/home/day_still_life_design.webp)] bg-fixed bg-center bg-no-repeat bg-cover w-full my-12 md:my-24 text-white h-auto md:h-[36rem] lg:h-[42rem]">
        <div id="seller-invitation-wrapper" class="bg-black/60 overflow-hidden py-16 md:py-[180px] lg:py-[240px] flex flex-col items-center gap-6 md:gap-10 h-full">
            <hgroup class="text-center px-4 md:px-8">
                <h2 class="text-white text-xl md:text-2xl lg:text-3xl my-3 mx-4">{{ useTrans('Boost your business by becoming a seller on our store !') }}</h2>
                <p class="text-white text-sm md:text-base">{{ useTrans('We verify each professional to offer an attractive and safe choice for your customers.') }}</p>
            </hgroup>
            <button id="seller-btn" class="bg-shop-primary py-2 px-3 rounded-md">
                <Link :href="route('register-seller', {locale: props.locale,}, false, Ziggy)">
                    <h4 class="text-white font-bold text-base md:text-lg">{{ useTrans('Register Now !') }}</h4>
                </Link>
            </button>
        </div>
    </section>
</template>