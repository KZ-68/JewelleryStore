<script setup lang="ts">
import type { Product } from '@/types/product'
import { Link } from '@inertiajs/vue3'
import { route } from '../../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../../ziggy.js';
import { FileEditIcon } from 'lucide-vue-next';

interface ProductsListProps {
    classname:string
    products: Product[]
    sortBy: string
    order: "asc" | "desc"
    locale: string
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const props = defineProps<ProductsListProps>()
</script>

<template>
    <section id="products-list-wrapper" class="rounded-lg py-4 px-2 sm:px-6 md:px-12">
        <div class="overflow-x-auto">
            <table class="flex flex-col gap-4 min-w-[520px] w-full">
                <thead>
                    <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                        <th scope="col" class="w-[15%] text-center">Id</th>
                        <th scope="col" class="w-[15%] text-center">Name</th>
                        <th scope="col" class="w-[15%] text-center">Reference</th>
                        <th scope="col" class="w-[15%] text-center">Ean13</th>
                        <th scope="col" class="w-[15%] text-center">Active</th>
                        <th scope="col" class="w-[15%] text-center">Edit</th>
                    </tr>
                </thead>
                <tbody v-if="products.length > 0" id="products-list">
                    <tr v-for="product in products" v-bind:key="product.id" class="flex flex-row gap-[5%] items-center justify-around bg-white border border-gray-200 py-3 px-3 my-4 rounded-md min-h-[4rem] h-auto dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                        <th scope="row" class="w-[15%] text-center">{{ product.id }}</th>
                        <td class="w-[15%] text-center break-words">{{ product.name }}</td>
                        <td class="w-[15%] text-center">{{ product.reference }}</td>
                        <td class="w-[15%] text-center">{{ product.ean13 }}</td>
                        <td class="w-[15%] text-center">{{ product.active }}</td>
                        <td class="flex flex-row justify-center w-[15%] text-center"><Link :href="route('product-details', {locale: props.locale,slug: product.slug}, false, Ziggy)"><FileEditIcon/></Link></td>
                    </tr>
                </tbody>
                <tbody v-else id="products-list">
                    <tr class="flex flex-row items-center justify-center bg-white border border-gray-200 py-3 px-3 my-4 rounded-md min-h-[4rem] dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="text-center font-normal text-gray-500 dark:text-gray-400">No Product registered</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>