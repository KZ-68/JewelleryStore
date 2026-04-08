<script setup lang="ts">
import { ref } from 'vue'

interface LanguageSelectorProps {
    locale: string
}

const props = defineProps<LanguageSelectorProps>();

defineEmits(['selectLang']);
</script>

<template>
    
</template>