<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from "vue";
import { Category } from '@/types/category';
import { route } from '../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../ziggy.js';
import { useTrans } from '@/composables/trans';

interface DiscoverCategorySectionProps {
    status?: string
    category_name : string
    description: string
    categories: Category[]
    isCollection: boolean
    locale: string
}

const props = defineProps<DiscoverCategorySectionProps>();

const getCategory = (name:string) => {
    let categoryData = null
    props.categories.forEach(category => {
        if (category.name === name) {
            categoryData = category
            return categoryData
        }
    });

    return categoryData
}

const collectionCategory = ref<null|Category>(getCategory(props.category_name))
</script>

<template>
    <section id="discover-category-section" class="flex flex-col items-center my-12 md:my-24 h-auto w-full">
        <h2 class="text-xl md:text-2xl my-3 mx-4">{{ collectionCategory?.name }} {{isCollection === true ? 'Collection' : 'Category'}}</h2>
        <div id="discover-category-wrapper" class="flex flex-col lg:flex-row w-full max-w-xs md:max-w-3xl lg:max-w-6xl mx-auto my-8 md:my-12 border-2 border-[#84070F] rounded-md overflow-hidden">
            <div id="discover-category-left" class="w-full lg:w-[48rem] shrink-0">
                <figure>
                    <img src="/storage/img/home/pendant-golden-coins-chinese-new-year_23-2148357937.jpg" alt="" class="w-full h-[20rem] md:h-[28rem] lg:h-[32rem] object-cover">
                </figure>
            </div>
            <div id="discover-category-right" class="flex flex-col gap-8 md:gap-16 justify-center items-start px-6 py-8 md:px-12 lg:py-0">
                <h3 id="discover-category-heading" class="text-base md:text-xl">{{ useTrans(props.description) }}</h3>
                <Link
                    id="discover-btn"
                    :href="route('showCategoryProducts', {locale: props.locale, category_slug: 'collections'}, false, Ziggy)"
                    class="inline-flex items-center justify-center min-h-12 min-w-12 bg-shop-primary py-3 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:ring-offset-2"
                >
                    <span class="text-white font-bold text-base md:text-lg">{{ useTrans('Discover') }}</span>
                </Link>
            </div>
        </div>
    </section>
</template>