<script setup lang="ts">
interface Props {
    classname:string;
    name: string;
    quantity?: number;
    price: string;
}

defineProps<Props>();
</script>

<template>
    <div class="mb-8 space-y-0.5 flex gap-2">
        <div class="w-[100%] bg-neutral-100 flex flex-row items-center justify-between py-8 px-6 my-3 mx-4 rounded-md">
            <h2 class="text-xl font-semibold tracking-tight">{{ name }}</h2>

            

            <aside class="flex flex-row text-sm text-muted-foreground gap-20">
                <span>
                ({{price}})
                </span>

                <p v-if="quantity">({{quantity}})</p>
                <p v-else>(0)</p>
            </aside>
        </div>
    </div>
</template>