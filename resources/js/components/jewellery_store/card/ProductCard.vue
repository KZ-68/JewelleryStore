<script setup lang="ts">
import axios from 'axios'
import type { Product } from '@/types/product'
import { onMounted, ref } from "vue";
import { route } from '../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../ziggy.js';

interface ProductCardProps {
    classname:string
    product: Product
    image: null|string
}

const retailPrice = ref(0);

const props = defineProps<ProductCardProps>()

onMounted(async () => {
    try {
        await axios.post(
            route('products.shopRetailPrice', {slug : props.product.slug}, false, Ziggy)
        ).then(response => {
            retailPrice.value = response.data.price
        })
    } catch (error) {
        console.error('Erreur:', error);
    }
})
</script>

<template>
    <div class="grow max-w-[20%] inline-flex px-2 pb-4 min-w-[20%]">
        <a href="#" class="relative bg-white inline-flex items-stretch w-full h-full p-0 box-border">
            <div class="absolute top-[4px] right-[4px] w-[28px] h-[28px] text-center z-10 rounded-full">
                <div>
                    <span class="absolute top-[4px] right-[4px] w-[24px] h-[24px] text-center z-10 rounded-full bg-gray-200">
                        <div class="absolute top-0 left-0 right-0 bottom-0 m-auto">
                        
                        </div>
                    </span>
                </div>
            </div>

            <div class="relative shadow-md rounded-lg min-w-full flex flex-col">
                <div class="relative">
                    <div class="relative h-0 rounded-t-lg pb-[100%] w-full bg-white text-ellipsis	overflow-hidden"> 
                        <div class="bg-no-repeat bg-cover inline-block my-0 mx-auto text-center w-full h-full absolute">
                            <img v-if="image == null" src="{{ asset('storage/public/img/p/not-found.jpg') }}" alt="Image Not Found text">
                            <img v-else src="{{ asset('storage/public/img/p/'. props.product.id . '/'. props.image) }}" alt="Jewellery Product Image">
                        </div>
                    </div>
                </div>

                <div class="relative p-2 box-border overflow-hidden grow">
                    <span class="text-gray-800 max-h-[38px] text-sm font-semibold leading-5 overflow-hidden whitespace-normal break-words		">
                        {{ props.product.name }}
                    </span>
                    <div>
                        <div class="block w-full text-sm font-bold text-amber-700">
                            {{ retailPrice }}
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</template>