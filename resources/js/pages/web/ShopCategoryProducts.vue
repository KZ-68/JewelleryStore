<script setup lang="ts">
import type { Product } from '@/types/product'
import ProductCard from '@/components/jewellery_store/card/ProductCard.vue';
import { Category } from '@/types/category';
import { router } from '@inertiajs/vue3'
import { computed, provide, ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';
import BlockCartModal from '@/components/jewellery_store/cart/modal/BlockCartModal.vue';
import AppShopLayout from '@/layouts/AppShopLayout.vue';
import { useTrans } from '@/composables/trans';

interface ProductsListProps {
    classname: string
    category_slug: string
    category_name: string
    products: Product[]
    frontCategories: Category[]
    filters: {
        sortBy: string
        order: string
    }
    cartProductsCount: number
    defaultShippingRatePrice: number
    locale: string
}

const props = defineProps<ProductsListProps>()

const sortBy = ref<string>(props.filters.sortBy || 'name')
const order = ref<'asc' | 'desc'>((props.filters.order as 'asc' | 'desc') || 'desc')
const filtersOpen = ref(false)
const url = route('showCategoryProducts', {locale: props.locale, category_slug: props.category_slug}, false, Ziggy)

const updateCustomersFilters = () => {
    currentPage.value = 1
    router.get(url, { sortBy: sortBy.value, order: order.value })
}

const setOrder = (value: 'asc' | 'desc') => {
    order.value = value
    updateCustomersFilters()
}

// --- Pagination ---
const ITEMS_PER_PAGE = 12
const currentPage = ref(1)

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

// --- Cart ---
const active = ref<boolean>(false)
provide('active', active)

const openCartModalValue = ref<boolean>(false)
provide('openCartModalValue', openCartModalValue)

const productsAdded = ref<Product[]>([])
const productsQuantity = ref<number>(0)
const productsPrice = ref<number>(0)

const addProduct = (key: Product) => { productsAdded.value.push(key) }
const addProductQuantity = (key: number) => { productsQuantity.value += key }
const addProductPrice = (key: number) => { productsPrice.value += key }
</script>

<template>
    <AppShopLayout
        :isHome="false"
        :frontCategories="props.frontCategories"
        :cartProductsCount="props.cartProductsCount"
        :locale="props.locale"
    >
        <div class="min-h-screen bg-gray-100">
            <div class="max-w-screen-2xl mx-auto px-4 md:px-8 lg:px-12 py-8">
                <div class="mb-6">
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">
                        {{ props.category_name }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ props.products.length }} produit{{ props.products.length !== 1 ? 's' : '' }} disponible{{ props.products.length !== 1 ? 's' : '' }}
                    </p>
                </div>

                <button
                    @click="filtersOpen = !filtersOpen"
                    :aria-expanded="filtersOpen.toString()"
                    aria-controls="filters-panel"
                    class="lg:hidden flex items-center gap-2 mb-4 px-4 py-2 bg-white rounded-lg shadow-sm border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#84070F] transition-colors"
                >
                    <svg aria-hidden="true" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M7 8h10M11 12h2"/>
                    </svg>
                    {{ useTrans('Filters') }}
                    <svg
                        aria-hidden="true"
                        class="w-3 h-3 text-gray-400 transition-transform duration-200 ml-auto"
                        :class="{ 'rotate-180': filtersOpen }"
                        fill="none" viewBox="0 0 20 20"
                    >
                        <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <div class="flex flex-col lg:flex-row gap-6 items-start">
                    <aside
                        id="filters-panel"
                        aria-label="Filtres produits"
                        :class="filtersOpen ? 'block' : 'hidden'"
                        class="lg:block w-full lg:w-60 shrink-0"
                    >
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="px-5 py-4 border-b border-gray-100">
                                <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Filtres</h2>
                            </div>
                            <div class="flex flex-col divide-y divide-gray-100">
                                <fieldset class="px-5 py-4">
                                    <legend class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Trier par</legend>
                                    <select
                                        id="sort-by-field"
                                        v-model="sortBy"
                                        @change="updateCustomersFilters"
                                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:border-transparent transition-colors"
                                        aria-label="Champ de tri"
                                    >
                                        <option value="name">{{ useTrans('Name') }}</option>
                                        <option value="created_at">{{ useTrans('Added date') }}</option>
                                    </select>
                                </fieldset>

                                <fieldset class="px-5 py-4">
                                    <legend class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Critère de prix</legend>
                                    <select
                                        id="sort-by-price"
                                        v-model="sortBy"
                                        @change="updateCustomersFilters"
                                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:border-transparent transition-colors"
                                        aria-label="Type de prix"
                                    >
                                        <option value="price_ht">Prix HT</option>
                                        <option value="retail_price">Prix TTC</option>
                                    </select>
                                </fieldset>

                                <fieldset class="px-5 py-4">
                                    <legend class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Ordre</legend>
                                    <div class="flex gap-2" role="group" aria-label="Ordre de tri">
                                        <button
                                            @click="setOrder('asc')"
                                            :aria-pressed="(order === 'asc').toString()"
                                            :class="order === 'asc'
                                                ? 'bg-[#84070F] text-white border-[#84070F]'
                                                : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'"
                                            class="flex-1 px-3 py-2 text-sm rounded-lg border transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F]"
                                        >
                                            {{ useTrans('Ascendant') }}
                                        </button>
                                        <button
                                            @click="setOrder('desc')"
                                            :aria-pressed="(order === 'desc').toString()"
                                            :class="order === 'desc'
                                                ? 'bg-[#84070F] text-white border-[#84070F]'
                                                : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'"
                                            class="flex-1 px-3 py-2 text-sm rounded-lg border transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F]"
                                        >
                                           {{ useTrans('Descendant') }}
                                        </button>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </aside>

                    <div class="flex-1 flex flex-col gap-6 min-w-0">
                        <p
                            class="text-sm text-gray-500"
                            aria-live="polite"
                            aria-atomic="true"
                        >
                            Affichage de
                            <span class="font-medium text-gray-700">{{ (currentPage - 1) * ITEMS_PER_PAGE + 1 }}–{{ Math.min(currentPage * ITEMS_PER_PAGE, props.products.length) }}</span>
                            sur
                            <span class="font-medium text-gray-700">{{ props.products.length }}</span>
                            produit{{ props.products.length !== 1 ? 's' : '' }}
                        </p>

                        <div
                            v-if="props.products.length === 0"
                            class="flex flex-col items-center justify-center py-24 text-gray-400 bg-white rounded-xl border border-gray-100"
                            role="status"
                        >
                            <svg aria-hidden="true" class="w-12 h-12 mb-4 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-base font-medium">Aucun produit dans cette catégorie</p>
                        </div>

                        <ul
                            v-else
                            role="list"
                            aria-label="Liste des produits"
                            class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4 lg:gap-6"
                        >
                            <li v-for="product in paginatedProducts" :key="product.id">
                                <ProductCard
                                    classname=""
                                    :product="product"
                                    :image="null"
                                    :sort-by="sortBy"
                                    :order="order"
                                    :locale="props.locale"
                                    :openCartModalValue="openCartModalValue"
                                    @addProduct="addProduct"
                                    @addProductQuantity="addProductQuantity"
                                    @addProductPrice="addProductPrice"
                                />
                            </li>
                        </ul>

                        <nav
                            v-if="totalPages > 1"
                            aria-label="Pagination des produits"
                            class="flex items-center justify-center gap-1 mt-2"
                        >
                            <button
                                @click="goToPage(currentPage - 1)"
                                :disabled="currentPage === 1"
                                aria-label="Page précédente"
                                class="flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F]"
                            >
                                <svg aria-hidden="true" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
                                </svg>
                            </button>

                            <template v-if="visiblePages[0] > 1">
                                <button
                                    @click="goToPage(1)"
                                    aria-label="Page 1"
                                    class="w-9 h-9 rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F]"
                                >
                                    1
                                </button>
                                <span v-if="visiblePages[0] > 2" class="px-1 text-gray-400 select-none" aria-hidden="true">…</span>
                            </template>

                            <button
                                v-for="page in visiblePages"
                                :key="page"
                                @click="goToPage(page)"
                                :aria-label="`Page ${page}`"
                                :aria-current="page === currentPage ? 'page' : undefined"
                                :class="page === currentPage
                                    ? 'bg-[#84070F] text-white border-[#84070F]'
                                    : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50'"
                                class="w-9 h-9 rounded-lg border text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F]"
                            >
                                {{ page }}
                            </button>

                            <template v-if="visiblePages[visiblePages.length - 1] < totalPages">
                                <span v-if="visiblePages[visiblePages.length - 1] < totalPages - 1" class="px-1 text-gray-400 select-none" aria-hidden="true">…</span>
                                <button
                                    @click="goToPage(totalPages)"
                                    :aria-label="`Page ${totalPages}`"
                                    class="w-9 h-9 rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F]"
                                >
                                    {{ totalPages }}
                                </button>
                            </template>

                            <button
                                @click="goToPage(currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                aria-label="Page suivante"
                                class="flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F]"
                            >
                                <svg aria-hidden="true" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"/>
                                </svg>
                            </button>
                        </nav>

                    </div>
                </div>
            </div>

            <BlockCartModal
                :is-open-value="openCartModalValue"
                :locale="props.locale"
                :products="productsAdded"
                :productsPrice="productsPrice"
                :productsQuantity="productsQuantity"
                :cartProductsCount="props.cartProductsCount"
                :defaultShippingRatePrice="props.defaultShippingRatePrice"
            />
        </div>
    </AppShopLayout>
</template>
