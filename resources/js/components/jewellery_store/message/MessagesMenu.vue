<script setup lang="ts">

defineEmits(['selectChoice']);
</script>

<template>
    <div class="message-menu-wrapper">
        <ul class="flex flex-col lg:flex-row gap-4 text-xl">
            <li><button class="cursor-pointer">Home</button></li>
            <li><button class="cursor-pointer" @click="$emit('selectChoice', 0)">Received Box</button></li>
            <li><button class="cursor-pointer" @click="$emit('selectChoice', 1)">Sent Box</button></li>
        </ul>
    </div>
</template>