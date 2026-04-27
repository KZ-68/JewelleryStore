<script setup lang="ts">
interface LanguageSelectorProps {
    locale: string
    sizeValues: Array<string>
}

const props = defineProps<LanguageSelectorProps>();

defineEmits(['selectSize']);
</script>

<template>
    <div id="size-selector-wrapper" class="my-4 mx-8">
        <h3 for="sizeValues" class="mb-4">Select your size</h3>
        <ul id="size-selector" class="flex flex-row gap-2" name="sizeValues">
            <li v-for="value in sizeValues" :value="value">
                <button @click="$emit('selectSize', value)" :name="value" :value="value" type="button" role="button" aria-label="size" class="p-4 border-2 border-gray-600 hover:cursor-pointer">{{value}}</button>
            </li>
        </ul>
    </div>
</template>