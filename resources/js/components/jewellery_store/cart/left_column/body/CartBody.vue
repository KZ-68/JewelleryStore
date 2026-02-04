<script setup lang="ts">
interface CartProduct {
    name: string
    quantity: number
    price : number
}

interface CartBodyProps {
    classname:string;
    products: Array<CartProduct>
}

const props = defineProps<CartBodyProps>();
</script>

<template>
    <div class="mb-8 space-y-0.5 flex gap-2">
        <div v-for="product in props.products" class="w-[100%] bg-neutral-100 flex flex-row items-center justify-between py-8 px-6 my-3 mx-4 rounded-md">
            <h2 class="text-xl font-semibold tracking-tight">{{ product.name }}</h2>
            <aside class="flex flex-row text-sm text-muted-foreground gap-20">
                <span>
                ({{product.price}})
                </span>

                <p>({{product.quantity}})</p>
            </aside>
        </div>
    </div>
</template>