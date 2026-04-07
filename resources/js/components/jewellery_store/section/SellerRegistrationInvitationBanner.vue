<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { route } from '../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '@/ziggy';

interface SellerRegistrationInvitationBanner {
    locale: string
}

const props = defineProps<SellerRegistrationInvitationBanner>();
</script>

<template>
    <section id="seller-invitation-section" class="bg-[url(storage/img/home/day_still_life_design.jpg)] bg-fixed bg-center bg-no-repeat bg-cover h-[42rem] w-full my-24 text-white">
        <div id="seller-invitation-wrapper" class="bg-black/60 overflow-hidden py-[240px] flex flex-col items-center gap-10 h-[42rem]">
            <hgroup>
                <h2 class="text-white text-2xl my-3 mx-4">Boost your business by becoming a seller on our store !</h2>
                <p class="text-white">We verify each professional to offer an attractive and safe choice for your customers.</p>
            </hgroup>
            <button id="seller-btn" class="bg-[#84070F] py-2 px-3 rounded-md">
                <Link :href="route('register-seller', {locale: props.locale,}, false, Ziggy)">
                    <h4 class="text-white font-bold text-lg">Register Now !</h4>
                </Link>
            </button>
        </div>
    </section>
</template>