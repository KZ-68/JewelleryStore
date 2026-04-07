<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from "vue";
import { Category } from '@/types/category';
import { route } from '../../../../../vendor/tightenco/ziggy';
import { Ziggy } from '../../../ziggy.js';

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
    <section id="discover-category-section" class="flex flex-col items-center my-24 h-[48rem] max-h-[48rem] lg:h-[32rem] lg:max-h-[32rem] w-full">
        <h2 class="text-2xl my-3 mx-4">{{ collectionCategory?.name }} {{isCollection === true ? 'Collection' : 'Category'}}</h2>
        <div id="discover-category-wrapper" class="flex flex-col lg:flex-row w-72 md:w-[48rem] lg:w-[96rem] my-12 border-2 border-[#84070F] rounded-md">
            <div id="discover-category-left">
                <figure>
                    <img src="/storage/img/home/pendant-golden-coins-chinese-new-year_23-2148357937.jpg" alt="Category Image" class="w-72 lg:w-[48rem] h-[32rem]">
                </figure>
            </div>
            <div id="discover-category-right" class="flex flex-col gap-16 justify-center items-start px-12">
                <h3 id="discover-category-heading" class="text-xl ">{{ props.description }}</h3>
                <button id="discover-btn" class="bg-[#84070F] py-2 px-3">
                    <Link :href="route('showCategoryProducts', {locale: props.locale, category_slug: 'collections'}, false, Ziggy)">
                        <h4 class="text-white font-bold text-lg">Discover</h4>
                    </Link>
                </button>
            </div>
        </div>
    </section>
</template>