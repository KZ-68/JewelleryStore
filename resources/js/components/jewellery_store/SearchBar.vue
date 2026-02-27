<script setup lang="ts">
import axios from 'axios'
import { Product } from '@/types/product';
import { onMounted, ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';import SearchProductCard from './card/SearchProductCard.vue';
;

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
            route('searchProducts', {text: text}, false, Ziggy), {text: text}
        ).then(response => {
            results.value = response.data.results
        })
    } catch (error) {
        console.error('Search Error :', error);
    }
}

</script>

<template>
    <div id="search-bar-wrapper" class="flex flex-col lg:block relative mx-4 lg:mx-8">
        <input @input="search(searchText)" id="shop-search-bar" type="text" name="text" v-model="searchText" class="w-80 lg:w-3xl px-2 py-3 rounded-md border-2 border-gray-200">
        <div id="search-results-wrapper" class="absolute px-3 py-4 z-[2]">
            <ul id="search-results-list" class="flex flex-col">
                <li v-if="results !== null" v-for="product in results">
                    <SearchProductCard :product="product" :image="product.image"></SearchProductCard>
                </li>
                <li v-else-if="searchBarActive === true && results === null" class="flex flex-row">
                    <p>No products found</p>
                </li>
            </ul>
        </div>
    </div>
</template>