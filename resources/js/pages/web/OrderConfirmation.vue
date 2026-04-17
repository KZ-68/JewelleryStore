<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useTrans } from '@/composables/trans';
import AppShopLayout from '@/layouts/AppShopLayout.vue';
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';
import { Category } from '@/types/category';
import { Order } from '@/types/order';

interface OrderConfirmationProps {
    order: Order
    frontCategories: Category[]
    cartProductsCount: number
    price: number
    productImages: string[]
    locale: string
}

const props = defineProps<OrderConfirmationProps>()

const formattedDate = computed(() => {
    return new Date(props.order.created_at).toLocaleDateString(
        props.locale === 'fr' ? 'fr-FR' : 'en-GB',
        { day: 'numeric', month: 'long', year: 'numeric' }
    )
})
</script>

<template>
    <Head title="Confirmation de Commande">
        <meta name="description" content="Votre commande a bien été confirmée. Retrouvez le récapitulatif de votre achat et les informations de livraison." head-key="description" />
    </Head>

    <AppShopLayout
        :isHome="false"
        :frontCategories="props.frontCategories"
        :cartProductsCount="props.cartProductsCount"
        :locale="props.locale"
    >
        <main
            class="min-h-[60vh] bg-gray-50 px-4 py-10 sm:px-6 lg:px-12"
            id="order-confirmation"
            aria-labelledby="confirmation-heading"
        >
            <div class="mx-auto max-w-2xl">

                <article
                    class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 overflow-hidden"
                    aria-label="Détail de la commande confirmée"
                >
                    <div class="bg-green-50 border-b border-green-100 px-6 py-6 sm:px-8 sm:py-8 flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                        <span
                            class="flex-shrink-0 flex items-center justify-center w-14 h-14 rounded-full bg-green-100"
                            aria-hidden="true"
                        >
                            <svg class="w-7 h-7 text-green-600" viewBox="0 0 20 20" fill="currentColor" focusable="false">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>

                        <div>
                            <h1
                                id="confirmation-heading"
                                class="text-xl sm:text-2xl font-semibold text-green-800 leading-snug"
                            >
                                {{ useTrans('Your order is confirmed') }}
                            </h1>
                            <p class="mt-1 text-sm text-green-700">
                                {{ useTrans('An email has been sent to') }}
                                <strong class="font-medium text-green-900">{{ $page.props.auth.customer.email }}</strong>
                            </p>
                        </div>
                    </div>

                    <div class="px-6 py-6 sm:px-8 sm:py-8 flex flex-col gap-5">

                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="rounded-lg bg-gray-50 px-4 py-3">
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                    {{ useTrans('Order reference') }}
                                </dt>
                                <dd
                                    class="mt-1 text-base font-semibold text-gray-900 break-all"
                                    aria-label="Référence de commande"
                                >
                                    {{ order.reference }}
                                </dd>
                            </div>
                            <div class="rounded-lg bg-gray-50 px-4 py-3">
                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                    {{ useTrans('Order date') }}
                                </dt>
                                <dd class="mt-1 text-base font-semibold text-gray-900">
                                    <time :datetime="order.created_at">{{ formattedDate }}</time>
                                </dd>
                            </div>
                        </dl>

                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ useTrans('You can find your order resume in your account page') }}
                        </p>

                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <Link
                                :href="route('products', { locale: props.locale }, false, Ziggy)"
                                class="inline-flex items-center justify-center min-h-[48px] rounded-lg bg-shop-primary px-6 py-3 text-sm font-medium text-shop-secondary transition-opacity hover:opacity-80 focus:outline-none focus:ring-2 focus:ring-shop-primary focus:ring-offset-2"
                                :aria-label="useTrans('Continue shopping and discover our products')"
                            >
                                {{ useTrans('Continue shopping') }}
                            </Link>
                        </div>
                    </div>
                </article>

            </div>
        </main>
    </AppShopLayout>
</template>
