<script setup lang="ts">
import axios from 'axios'
import { Product } from '@/types/product';
import { ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';import SearchProductCard from './card/SearchProductCard.vue';
import { usePage } from '@inertiajs/vue3';
import { useTrans } from '@/composables/trans';

let searchText = ref('');
let results = ref<Product[]|null>(null);
let searchBarActive = ref(false);

async function search(text: string) {
    searchBarActive.value = true;
    if(text === '') {
        results.value = null;
        searchBarActive.value = false;
    }

    try {
        await axios.post(
            route('searchProducts', {locale: usePage.props.locale, text: text}, false, Ziggy), {text: text}
        ).then(response => {
            results.value = response.data.results
        })
    } catch (error) {
        console.error('Search Error :', error);
    }
}

</script>

<template>
    <div id="search-bar-wrapper" class="relative w-full">
        <input @input="search(searchText)" id="shop-search-bar" type="text" name="text" v-model="searchText" class="w-full px-2 py-2 lg:py-3 rounded-md border-2 border-gray-200">
        <div id="search-results-wrapper" class="absolute top-9 lg:top-0 px-3 py-4 z-[2]">
            <ul id="search-results-list" class="flex flex-col">
                <li v-if="results !== null" v-for="product in results">
                    <SearchProductCard :locale="usePage.props.locale" :product="product" :image="product.image"></SearchProductCard>
                </li>
                <li v-else-if="searchBarActive === true && results === null" class="flex flex-row">
                    <p>{{ useTrans('No products found') }}</p>
                </li>
            </ul>
        </div>
    </div>
</template>