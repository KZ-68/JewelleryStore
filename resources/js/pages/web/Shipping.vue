<script setup lang="ts">
import type { Category } from '@/types/category';
import { Head } from '@inertiajs/vue3';
import AppShopLayout from '@/layouts/AppShopLayout.vue';
import { useTrans } from '@/composables/trans';

interface ShippingProps {
    frontCategories: Category[]
    cartProductsCount: number
    locale: string
}

const props = defineProps<ShippingProps>();

const sections = [
    { id: 'delivery-times',      label: () => useTrans('Delivery times') },
    { id: 'shipping-costs',      label: () => useTrans('Shipping costs') },
    { id: 'international',       label: () => useTrans('International shipping') },
    { id: 'order-tracking',      label: () => useTrans('Order tracking') },
    { id: 'packaging',           label: () => useTrans('Packaging') },
]
</script>

<template>
    <Head :title="useTrans('Shipping Information')">
        <meta name="description" :content="useTrans('Shipping Information')" head-key="description" />
    </Head>
    <AppShopLayout :isHome="false" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale">
        <div class="max-w-screen-md mx-auto px-6 py-12 dark:text-gray-300">

            <h1 class="text-3xl font-bold mb-6">{{ useTrans('Shipping Information') }}</h1>

            <!-- Table des matières / navigation rapide -->
            <nav aria-label="Page sections" class="mb-10 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">Contents</p>
                <ol class="space-y-1 list-decimal list-inside">
                    <li v-for="section in sections" :key="section.id">
                        <a
                            :href="`#${section.id}`"
                            class="text-sm text-[#84070F] dark:text-red-400 hover:underline underline-offset-2 rounded-sm focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:ring-offset-1"
                        >{{ section.label() }}</a>
                    </li>
                </ol>
            </nav>

            <section id="delivery-times" class="mb-8 scroll-mt-24" aria-labelledby="heading-delivery-times">
                <h2 id="heading-delivery-times" class="text-xl font-semibold mb-3">{{ useTrans('Delivery times') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('Orders are processed within 1–2 business days. Standard delivery takes 3–5 business days. Express delivery (1–2 business days) is also available at checkout.') }}
                </p>
            </section>

            <section id="shipping-costs" class="mb-8 scroll-mt-24" aria-labelledby="heading-shipping-costs">
                <h2 id="heading-shipping-costs" class="text-xl font-semibold mb-3">{{ useTrans('Shipping costs') }}</h2>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-400 space-y-2">
                    <li>{{ useTrans('Standard shipping: calculated at checkout based on your location.') }}</li>
                    <li>{{ useTrans('Free standard shipping on orders over €100.') }}</li>
                    <li>{{ useTrans('Express shipping: flat rate of €12.90.') }}</li>
                </ul>
            </section>

            <section id="international" class="mb-8 scroll-mt-24" aria-labelledby="heading-international">
                <h2 id="heading-international" class="text-xl font-semibold mb-3">{{ useTrans('International shipping') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('We ship to most countries worldwide. International delivery times vary between 7 and 14 business days depending on your location. Customs duties and taxes may apply and are the responsibility of the recipient.') }}
                </p>
            </section>

            <section id="order-tracking" class="mb-8 scroll-mt-24" aria-labelledby="heading-order-tracking">
                <h2 id="heading-order-tracking" class="text-xl font-semibold mb-3">{{ useTrans('Order tracking') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('Once your order has been dispatched, you will receive an email with your tracking number. You can use this number to track your parcel on our carrier\'s website.') }}
                </p>
            </section>

            <section id="packaging" class="mb-8 scroll-mt-24" aria-labelledby="heading-packaging">
                <h2 id="heading-packaging" class="text-xl font-semibold mb-3">{{ useTrans('Packaging') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('All jewellery is carefully packaged in a branded gift box to ensure it arrives in perfect condition. Our packaging is also suitable for gifting.') }}
                </p>
            </section>

            <a
                href="#"
                class="inline-block mt-4 text-sm text-[#84070F] dark:text-red-400 hover:underline underline-offset-2 rounded-sm focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:ring-offset-1"
            >↑ Back to top</a>

        </div>
    </AppShopLayout>
</template>
