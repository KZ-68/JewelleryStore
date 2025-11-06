<script setup lang="ts">
import type { Product } from '@/types/product'

interface ProductsListProps {
    classname:string;
    products: Product[]
    // sortBy: string
    // order: 'asc' | 'desc'
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

defineProps<ProductsListProps>()
</script>

<template>
    <section id="products-list-wrapper" class="bg-gray-100 rounded-lg py-4 px-12">
        <table class="flex flex-col gap-5">
            <thead>
                <tr class="flex flex-row gap-[5%] justify-around">
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[10%] text-center">Id</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[10%] text-center">Name</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[10%] text-center">Reference</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[10%] text-center">ean13</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[10%] text-center">active</th>
                </tr>
            </thead>
            <tbody v-if="products.length > 0" id="products-list">
                <tr v-for="product in products" v-bind:key="product.id" class="flex flex-row gap-[5%] justify-around">
                    <th scope="row" class="m-[1rem 2rem 1rem 2rem] w-[10%] text-center">{{ product.id }}</th>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[10%] text-center">{{ product.name }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[10%] text-center">{{ product.reference }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[10%] text-center">{{ product.ean13 }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[10%] text-center">{{ product.active }}</td>
                </tr>
            </tbody>
            <tbody v-else id="products-list">
                <th scope="row">No Product registere</th>
            </tbody>
        </table>
    </section>
</template>