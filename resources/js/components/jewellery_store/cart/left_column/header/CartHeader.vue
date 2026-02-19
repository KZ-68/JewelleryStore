<script setup lang="ts">

interface CartProduct {
    product_id: number
    name: string
    quantity: number
    price: number
}

interface CartHeaderProps {
    classname:string;
    title: string;
    products: Array<CartProduct>
}

const props = defineProps<CartHeaderProps>();
</script>

<template>
    <div class="flex flex-row items-center mb-8 space-y-0.5">
        <h2 class="text-xl font-semibold tracking-tight my-3 mx-4">{{ title }}</h2>
        <p v-if="props.products.length > 0" class="text-sm text-muted-foreground">
            ({{props.products.length}})
        </p>
        <p v-else class="text-sm text-muted-foreground">
            (0)
        </p>
    </div>
</template>