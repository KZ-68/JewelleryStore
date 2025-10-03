<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const passwordInput = ref<InstanceType<typeof Input> | null>(null);
</script>

<template>
</template>


<Input
    id="password"
    type="password"
    name="password"
    ref="passwordInput"
    placeholder="Password"
/>