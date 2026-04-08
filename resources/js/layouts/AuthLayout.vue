<script setup lang="ts">
import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';

defineProps<{
    title?: string;
    description?: string;
    locale: string
}>();
</script>

<template>
    <AuthLayout :locale="locale" :title="title" :description="description">
        <slot />
    </AuthLayout>
</template>
