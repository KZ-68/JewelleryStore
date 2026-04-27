<script setup lang="ts">
import { TrashIcon } from 'lucide-vue-next';
import axios from 'axios'
import { route } from '../../../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../../../ziggy.js';

interface CartProduct {
    product_id: number
    name: string
    quantity: number
    price : number
}

interface CartBodyProps {
    classname:string;
    products: Array<CartProduct>
    locale: string
}

async function remove(product:CartProduct) {
    try {
        await axios.post(
            route('cart.removeToCart', {locale: props.locale, product : product}, false, Ziggy), {product: product}
        )
    } catch (error) {
        console.error('Erreur:', error);
    }
}

const props = defineProps<CartBodyProps>();
</script>

<template>
    <div class="mb-8 space-y-0.5 flex gap-2">
        <div v-for="product in props.products" :key="product.name" class="w-[100%] bg-neutral-100 flex flex-row items-center justify-between py-8 px-6 my-3 mx-4 rounded-md">
            <h2 class="text-xl font-semibold tracking-tight">{{ product.name }}</h2>
            <aside class="flex flex-row text-sm text-muted-foreground gap-20">
                <span>
                    {{product.price}}
                </span>

                <p>({{product.quantity}})</p>
                <button @click="remove(product)" class="hover:cursor-pointer"><TrashIcon class="text-[#84070F] hover:text-gray-500"/></button>
            </aside>
        </div>
    </div>
</template>