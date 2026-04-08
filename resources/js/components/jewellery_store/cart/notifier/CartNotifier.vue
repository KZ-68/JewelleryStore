<script setup lang="ts">
import { show } from '@/routes/cart'
import { HandbagIcon } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { toRefs, computed } from 'vue';

interface CartNotifierProps {
    cartProductsCount: number
    locale: string
}

const props = defineProps<CartNotifierProps>();

const shopHeader = toRefs(props);
const cartNumber = computed(() => shopHeader.cartProductsCount)
</script>

<template>
    <div id="cart-notifier-wrapper">
        <Link id="cart-notifier-anchor" class="relative flex flex-row items-center gap-2" :href="show({locale: props.locale})">
            <div id="cart-notifier-body">
                <HandbagIcon width="100px"/>
            </div>
            <div id="cart-notifier-header">
                <span class="flex flex-row justify-center items-center w-[20px] h-[20px] py-0.5 px-2.5 z-10 left-4 rounded-full bg-gray-200">
                    <div>
                        {{ cartNumber }}
                    </div>
                </span>
            </div>
        </Link>
    </div>
</template>