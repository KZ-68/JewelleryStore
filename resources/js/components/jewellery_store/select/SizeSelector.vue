<script setup lang="ts">
import { ref } from 'vue'

interface LanguageSelectorProps {
    locale: string
    sizeValues: Array<string>
}

const props = defineProps<LanguageSelectorProps>();

defineEmits(['selectLang']);
</script>

<template>
    <div id="size-selector-wrapper" class="my-4 mx-8">
        <label for="sizeValues">Select your size</label>
        <select id="size-selector" class="flex flex-row gap-2" name="sizeValues">
            <option v-for="value in sizeValues" class="p-4 border-2 border-gray-600" :value="value">{{value}}</option>
        </select>
    </div>
</template>