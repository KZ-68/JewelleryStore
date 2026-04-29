<script setup lang="ts">
import type { Product } from '@/types/product'
import type { Feature } from '@/types/feature'
import type { FeatureValue } from '@/types/feature_value'
import ProductCard from '@/components/jewellery_store/card/ProductCard.vue';
import { Category } from '@/types/category';
import { useWindowSize } from '@vueuse/core';
import { computed, provide, ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';
import { Head, router } from '@inertiajs/vue3';
import AppShopLayout from '@/layouts/AppShopLayout.vue';
import { useTrans } from '@/composables/trans';

interface FeatureWithValues extends Feature {
    values: FeatureValue[]
}

interface ProductsListProps {
    classname:string
    products: Product[]
    frontCategories: Category[]
    cartProductsCount: number
    filters: {
        sortBy: string
        orderBy: string
        feature_value_ids: number[]
    }
    locale: string
    availableFeatures: FeatureWithValues[]
}

// const emit = defineEmits<{
//   (e: 'navigate', url: string): void
// }>() 

const props = defineProps<ProductsListProps>()

const sortBy = ref<string>(props.filters.sortBy || 'name')
const orderBy = ref<'asc' | 'desc'>((props.filters.orderBy as 'asc' | 'desc') || 'desc')
const filtersOpen = ref(false)
const url = route('products.shopProductsList', {locale: props.locale}, false, Ziggy)

const openNav = () => {
  active.value = true
}

const sizeFeature = computed(() =>
    props.availableFeatures?.find(f => f.name.toLowerCase() === 'size') ?? null
)
const materialFeature = computed(() =>
    props.availableFeatures?.find(f => f.name.toLowerCase() === 'material') ?? null
)

const selectedSizeId = ref<number | ''>(
    props.availableFeatures?.find(f => f.name.toLowerCase() === 'size')
        ?.values.find(v => props.filters.feature_value_ids?.includes(v.id))
        ?.id ?? ''
)
const selectedMaterialId = ref<number | ''>(
    props.availableFeatures?.find(f => f.name.toLowerCase() === 'material')
        ?.values.find(v => props.filters.feature_value_ids?.includes(v.id))
        ?.id ?? ''
)

const hasActiveFeatureFilters = computed(() => (props.filters.feature_value_ids?.length ?? 0) > 0)

const ITEMS_PER_PAGE = 12
const currentPage = ref(1)

const resetFeatureFilters = () => {
    selectedSizeId.value = ''
    selectedMaterialId.value = ''
    updateCustomersFilters()
}

const updateCustomersFilters = () => {
    currentPage.value = 1
    const featureValueIds = ([selectedSizeId.value, selectedMaterialId.value] as Array<number | ''>)
        .filter((id): id is number => id !== '')
    router.get(url, {
        sortBy: sortBy.value,
        orderBy: orderBy.value,
        feature_value_ids: featureValueIds,
    })
}

const setOrderBy = (value: 'asc' | 'desc') => {
    orderBy.value = value
    updateCustomersFilters()
}


const totalPages = computed(() => Math.max(1, Math.ceil(props.products.length / ITEMS_PER_PAGE)))

const paginatedProducts = computed(() => {
    const start = (currentPage.value - 1) * ITEMS_PER_PAGE
    return props.products.slice(start, start + ITEMS_PER_PAGE)
})

const visiblePages = computed(() => {
    const pages: number[] = []
    const range = 2
    const start = Math.max(1, currentPage.value - range)
    const end = Math.min(totalPages.value, currentPage.value + range)
    for (let i = start; i <= end; i++) pages.push(i)
    return pages
})

function goToPage(page: number) {
    if (page < 1 || page > totalPages.value) return
    currentPage.value = page
    window.scrollTo({ top: 0, behavior: 'smooth' })
}

const { width } = useWindowSize()
const active = ref<boolean>(false)
provide('active', active)
</script>

<template>
    <Head title="Nos Bijoux">
        <meta name="description" content="Parcourez toute notre collection de bijoux : colliers, bagues, bracelets, pendentifs. Filtrez par taille, matière et prix pour trouver le bijou parfait." head-key="description" />
    </Head>
    <AppShopLayout :isHome="false" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale">     
        <div class="min-h-screen mx-auto my-auto">
            <div class="flex flex-col lg:flex-row gap-6 items-start">
                <aside
                    id="filters-panel"
                    aria-label="Filtres produits"
                    :class="filtersOpen ? 'block' : 'hidden'"
                    class="lg:block w-full lg:w-84 shrink-0"
                >
                    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">{{ useTrans('Filters') }}</h2>
                        </div>
                        <div class="flex flex-col divide-y divide-gray-100">
                            <fieldset class="px-5 py-4">
                                <legend class="text-xs font-semibold text-gray-400 uppercase tracking-wide py-3">{{ useTrans('Sort by') }}</legend>
                                <select
                                    id="sort-by-field"
                                    v-model="sortBy"
                                    @change="updateCustomersFilters"
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:border-transparent transition-colors"
                                    :aria-label="useTrans('Sort field')"
                                >
                                    <option value="name">{{ useTrans('Name') }}</option>
                                    <option value="created_at">{{ useTrans('Added date') }}</option>
                                </select>
                            </fieldset>

                            <fieldset class="px-5 py-4">
                                <legend class="text-xs font-semibold text-gray-400 uppercase tracking-wide py-3">{{ useTrans('Order') }}</legend>
                                <div class="flex gap-2" role="group" aria-label="Ordre de tri">
                                    <button
                                        @click="setOrderBy('asc')"
                                        :aria-pressed="(orderBy === 'asc').toString()"
                                        :class="orderBy === 'asc'
                                            ? 'bg-[#84070F] text-white border-[#84070F]'
                                            : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'"
                                        class="flex-1 px-3 py-2 text-sm rounded-lg border transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F]"
                                    >
                                        {{ useTrans('Ascendant') }}
                                    </button>
                                    <button
                                        @click="setOrderBy('desc')"
                                        :aria-pressed="(orderBy === 'desc').toString()"
                                        :class="orderBy === 'desc'
                                            ? 'bg-[#84070F] text-white border-[#84070F]'
                                            : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'"
                                        class="flex-1 px-3 py-2 text-sm rounded-lg border transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F]"
                                    >
                                        {{ useTrans('Descendant') }}
                                    </button>
                                </div>
                            </fieldset>

                            <fieldset v-if="sizeFeature" class="px-5 py-4">
                                <legend class="text-xs font-semibold text-gray-400 uppercase tracking-wide py-3">
                                    {{ useTrans('Size') }}
                                </legend>
                                <select
                                    v-model="selectedSizeId"
                                    @change="updateCustomersFilters"
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:border-transparent transition-colors"
                                    :aria-label="useTrans('Filter by size')"
                                >
                                    <option value="">{{ useTrans('All sizes') }}</option>
                                    <option
                                        v-for="val in sizeFeature.values"
                                        :key="val.id"
                                        :value="val.id"
                                    >
                                        {{ val.value }}
                                    </option>
                                </select>
                            </fieldset>

                            <fieldset v-if="materialFeature" class="px-5 py-4">
                                <legend class="text-xs font-semibold text-gray-400 uppercase tracking-wide py-3">
                                    {{ useTrans('Material') }}
                                </legend>
                                <select
                                    v-model="selectedMaterialId"
                                    @change="updateCustomersFilters"
                                    class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:border-transparent transition-colors"
                                    :aria-label="useTrans('Filter by material')"
                                >
                                    <option value="">{{ useTrans('All materials') }}</option>
                                    <option
                                        v-for="val in materialFeature.values"
                                        :key="val.id"
                                        :value="val.id"
                                    >
                                        {{ val.value }}
                                    </option>
                                </select>
                            </fieldset>

                            <div v-if="hasActiveFeatureFilters" class="px-5 py-4">
                                <button
                                    type="button"
                                    @click="resetFeatureFilters"
                                    class="w-full flex items-center justify-center gap-2 px-3 py-2 text-sm rounded-lg border border-[#84070F] text-[#84070F] hover:bg-red-50 transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F]"
                                >
                                    <svg aria-hidden="true" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    {{ useTrans('Reset filters') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </aside>
                <div
                    v-if="props.products.length === 0"
                    class="flex flex-col items-center justify-center py-24 text-gray-400 bg-white rounded-xl border border-gray-100"
                    role="status"
                >
                    <svg aria-hidden="true" class="w-12 h-12 mb-4 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-base font-medium">{{ useTrans('No products in this category') }}</p>
                </div>

                <ul
                    v-else
                    role="list"
                    :aria-label="useTrans('Products list')"
                    class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4 lg:gap-6"
                >
                    <li v-for="product in paginatedProducts" :key="product.id">
                        <ProductCard classname="" :product="product" :image="product.image" :sort-by="sortBy" :orderBy="orderBy" :locale="props.locale" />
                    </li>
                </ul>
            </div>
        </div>
    </AppShopLayout>
</template>