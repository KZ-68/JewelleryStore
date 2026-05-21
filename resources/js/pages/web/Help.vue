<script setup lang="ts">
import type { Category } from '@/types/category';
import { Head } from '@inertiajs/vue3';
import AppShopLayout from '@/layouts/AppShopLayout.vue';
import { useTrans } from '@/composables/trans';
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';
import { ref } from 'vue';

interface HelpProps {
    frontCategories: Category[]
    cartProductsCount: number
    locale: string
}

const props = defineProps<HelpProps>();

const faqs = [
    {
        id: 'faq-order',
        question: () => useTrans('How do I place an order?'),
        answer:   () => useTrans('Browse our catalogue, select the item you wish to purchase and click "Add to cart". Then proceed to checkout, fill in your delivery and payment details to confirm your order.'),
    },
    {
        id: 'faq-cancel',
        question: () => useTrans('Can I modify or cancel my order?'),
        answer:   () => useTrans('Orders can be modified or cancelled within 24 hours of placement. Please contact our customer service team as soon as possible via the contact form.'),
    },
    {
        id: 'faq-payment',
        question: () => useTrans('What payment methods do you accept?'),
        answer:   () => useTrans('We accept Visa, Mastercard, American Express, PayPal, Apple Pay and Klarna. All transactions are secured with SSL encryption.'),
    },
    {
        id: 'faq-return',
        question: () => useTrans('How do I return an item?'),
        answer:   () => useTrans('You have 30 days from receipt to return an item. The item must be in its original condition and packaging. Please initiate your return from your account\'s order history page.'),
    },
    {
        id: 'faq-tracking',
        question: () => useTrans('How do I track my order?'),
        answer:   () => useTrans('Once your order has been shipped, you will receive a confirmation email with a tracking number. You can also track your order from the "My Orders" section of your account.'),
    },
    {
        id: 'faq-security',
        question: () => useTrans('Is my payment information secure?'),
        answer:   () => useTrans('Yes. We do not store any payment card details. All transactions are processed through our certified and PCI DSS compliant payment provider.'),
    },
]

const openId = ref<string | null>(null)

function toggle(id: string) {
    openId.value = openId.value === id ? null : id
}
</script>

<template>
    <Head :title="useTrans('Help Center')">
        <meta name="description" :content="useTrans('Help Center')" head-key="description" />
    </Head>
    <AppShopLayout :isHome="false" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale">
        <div class="max-w-screen-md mx-auto px-6 py-12 dark:text-gray-300">
            <h1 class="text-3xl font-bold mb-8">{{ useTrans('Help Center') }}</h1>

            <section class="mb-10" aria-labelledby="faq-heading">
                <h2 id="faq-heading" class="text-xl font-semibold mb-4">{{ useTrans('Frequently Asked Questions') }}</h2>

                <dl class="space-y-2">
                    <div
                        v-for="faq in faqs"
                        :key="faq.id"
                        class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden"
                    >
                        <dt>
                            <button
                                :id="faq.id"
                                type="button"
                                :aria-expanded="openId === faq.id"
                                :aria-controls="`${faq.id}-answer`"
                                class="w-full flex justify-between items-center px-5 py-4 text-left font-semibold text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#84070F]"
                                @click="toggle(faq.id)"
                            >
                                <span>{{ faq.question() }}</span>
                                <span
                                    aria-hidden="true"
                                    class="ml-4 shrink-0 text-gray-400 transition-transform duration-200"
                                    :class="openId === faq.id ? 'rotate-180' : ''"
                                >▾</span>
                            </button>
                        </dt>
                        <dd
                            :id="`${faq.id}-answer`"
                            :aria-labelledby="faq.id"
                            role="region"
                            class="overflow-hidden transition-all duration-200"
                            :class="openId === faq.id ? 'max-h-96' : 'max-h-0'"
                        >
                            <p class="px-5 py-4 text-gray-600 dark:text-gray-400 leading-relaxed bg-gray-50 dark:bg-gray-800">
                                {{ faq.answer() }}
                            </p>
                        </dd>
                    </div>
                </dl>
            </section>

            <section class="mb-8" aria-labelledby="contact-heading">
                <h2 id="contact-heading" class="text-xl font-semibold mb-3">{{ useTrans('Still need help?') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('Our customer service team is available Monday to Friday, 9am – 6pm. You can reach us via our contact form and we will get back to you within 24 hours.') }}
                    <a
                        :href="route('contact.create', { locale: props.locale }, false, Ziggy)"
                        class="text-[#84070F] dark:text-red-400 underline underline-offset-2 hover:opacity-80 rounded-sm focus:outline-none focus:ring-2 focus:ring-[#84070F] focus:ring-offset-1"
                    >{{ useTrans('contact form') }}</a>.
                </p>
            </section>

        </div>
    </AppShopLayout>
</template>
