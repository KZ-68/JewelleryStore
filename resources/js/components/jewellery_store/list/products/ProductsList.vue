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
    order: 'asc' | 'desc'
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

defineProps<ProductsListProps>()
</script>

<template>
    <section id="products-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-12">
        <table class="flex flex-col gap-4">
            <thead>
                <tr class="flex flex-row gap-[5%] justify-around py-2 px-3">
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Id</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Name</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Reference</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Ean13</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Active</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">Edit</th>
                </tr>
            </thead>
            <tbody v-if="products.length > 0" id="products-list">
                <tr v-for="product in products" v-bind:key="product.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-2 px-3 my-4 rounded-md h-[5rem]">
                    <th scope="row" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ product.id }}</th>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ product.name }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ product.reference }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ product.ean13 }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ product.active }}</td>
                    <td class="flex flex-row justify-center m-[1rem 2rem 1rem 2rem] w-[15%] text-center"><Link :href="route('product-details', {slug: product.slug}, false, Ziggy)"><FileEditIcon/></Link></td>
                </tr>
            </tbody>
            <tbody v-else id="products-list">
                <tr>
                    <th scope="row">No Product registered</th>
                </tr>
            </tbody>
        </table>
    </section>
</template>