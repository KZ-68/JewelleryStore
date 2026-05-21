<script setup lang="ts">
import type { Category } from '@/types/category';
import { Head } from '@inertiajs/vue3';
import AppShopLayout from '@/layouts/AppShopLayout.vue';
import { useTrans } from '@/composables/trans';
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';

interface HelpProps {
    frontCategories: Category[]
    cartProductsCount: number
    locale: string
}

const props = defineProps<HelpProps>();
</script>

<template>
    <Head :title="useTrans('Help Center')">
        <meta name="description" :content="useTrans('Help Center')" head-key="description" />
    </Head>
    <AppShopLayout :isHome="false" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale">
        <div class="max-w-screen-md mx-auto px-6 py-12 dark:text-gray-300">
            <h1 class="text-3xl font-bold mb-8">{{ useTrans('Help Center') }}</h1>

            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-4">{{ useTrans('Frequently Asked Questions') }}</h2>

                <div class="space-y-6">
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ useTrans('How do I place an order?') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ useTrans('Browse our catalogue, select the item you wish to purchase and click "Add to cart". Then proceed to checkout, fill in your delivery and payment details to confirm your order.') }}
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ useTrans('Can I modify or cancel my order?') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ useTrans('Orders can be modified or cancelled within 24 hours of placement. Please contact our customer service team as soon as possible via the contact form.') }}
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ useTrans('What payment methods do you accept?') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ useTrans('We accept Visa, Mastercard, American Express, PayPal, Apple Pay and Klarna. All transactions are secured with SSL encryption.') }}
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ useTrans('How do I return an item?') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ useTrans('You have 30 days from receipt to return an item. The item must be in its original condition and packaging. Please initiate your return from your account\'s order history page.') }}
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ useTrans('How do I track my order?') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ useTrans('Once your order has been shipped, you will receive a confirmation email with a tracking number. You can also track your order from the "My Orders" section of your account.') }}
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ useTrans('Is my payment information secure?') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ useTrans('Yes. We do not store any payment card details. All transactions are processed through our certified and PCI DSS compliant payment provider.') }}
                        </p>
                    </div>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-3">{{ useTrans('Still need help?') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('Our customer service team is available Monday to Friday, 9am – 6pm. You can reach us via our contact form and we will get back to you within 24 hours.') }}
                    <a
                        :href="route('contact.create', { locale: props.locale }, false, Ziggy)"
                        class="underline hover:opacity-80"
                    >{{ useTrans('contact form') }}</a>.
                </p>
            </section>
        </div>
    </AppShopLayout>
</template>
