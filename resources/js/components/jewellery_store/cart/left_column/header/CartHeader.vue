<script setup lang="ts">
interface Props {
    classname:string;
    title: string;
    total?: number;
}

defineProps<Props>();
</script>

<template>
    <div class="flex flex-row items-center mb-8 space-y-0.5">
        <h2 class="text-xl font-semibold tracking-tight my-3 mx-4">{{ title }}</h2>
        <p v-if="total" class="text-sm text-muted-foreground">
            ({{total}})
        </p>
        <p v-else class="text-sm text-muted-foreground">
            (0)
        </p>
    </div>
</template>