<script setup lang="ts">
import type { Product } from '@/types/product'

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
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">ean13</th>
                    <th scope="col" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">active</th>
                </tr>
            </thead>
            <tbody v-if="products.length > 0" id="products-list">
                <tr v-for="product in products" v-bind:key="product.id" class="flex flex-row gap-[5%] items-center justify-around bg-gray-200 py-2 px-3 my-4 rounded-md h-[5rem]">
                    <th scope="row" class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ product.id }}</th>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ product.name }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ product.reference }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ product.ean13 }}</td>
                    <td class="m-[1rem 2rem 1rem 2rem] w-[15%] text-center">{{ product.active }}</td>
                </tr>
            </tbody>
            <tbody v-else id="products-list">
                <th scope="row">No Product registered</th>
            </tbody>
        </table>
    </section>
</template>