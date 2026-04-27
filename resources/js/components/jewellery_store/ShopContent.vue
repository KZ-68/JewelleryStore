<script setup lang="ts">
import type { BreadcrumbItemType } from '@/types';
import Breadcrumbs from '../Breadcrumbs.vue';

interface ShopContentProps {
    breadcrumbs?: BreadcrumbItemType[];
}

const props = withDefaults(defineProps<ShopContentProps>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <main class="items-center min-h-screen p-6 text-[#1b1b18] lg:justify-center lg:p-8 bg-gray-100 dark:bg-[#0a0a0a]"
    >
        <div
            v-if="props.breadcrumbs.length > 1"
            class="flex w-full border-b border-sidebar-border/70"
        >
            <div
                class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl"
            >
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>
        </div>
        <slot />
    </main>
</template>