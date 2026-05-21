<script setup lang="ts">
import type { Category } from '@/types/category';
import { Head } from '@inertiajs/vue3';
import AppShopLayout from '@/layouts/AppShopLayout.vue';
import { useTrans } from '@/composables/trans';

interface TermsProps {
    frontCategories: Category[]
    cartProductsCount: number
    locale: string
}

const props = defineProps<TermsProps>();
</script>

<template>
    <Head :title="useTrans('Terms and Conditions')">
        <meta name="description" :content="useTrans('Terms and Conditions')" head-key="description" />
    </Head>
    <AppShopLayout :isHome="false" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale">
        <div class="max-w-screen-md mx-auto px-6 py-12 dark:text-gray-300">
            <h1 class="text-3xl font-bold mb-2">{{ useTrans('Terms and Conditions') }}</h1>
            <p class="text-sm text-gray-400 mb-8">{{ useTrans('Last updated:') }} {{ new Date().getFullYear() }}</p>

            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-3">{{ useTrans('1. General provisions') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('These general terms and conditions of sale govern the contractual relationship between Joaillerie Orient SAS (hereafter "the Seller") and any natural or legal person wishing to make a purchase via the website (hereafter "the Customer"). Any order placed implies full and unreserved acceptance of these terms by the Customer.') }}
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-3">{{ useTrans('2. Products') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('The products offered for sale are those featured on the website on the date of consultation by the Customer. Photographs and descriptions are provided for illustrative purposes only. The Seller reserves the right to modify the product range at any time without notice.') }}
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-3">{{ useTrans('3. Prices') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('Prices are stated in euros, inclusive of all taxes (VAT included), unless otherwise indicated. Shipping costs are shown separately at checkout. The Seller reserves the right to modify prices at any time; however, products will be invoiced at the price in force at the time the order is placed.') }}
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-3">{{ useTrans('4. Orders') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('Any order placed on the website constitutes a firm and final offer to purchase the selected products. The Seller reserves the right to cancel or refuse an order in the event of a dispute relating to a previous order or a suspicion of fraudulent activity.') }}
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-3">{{ useTrans('5. Payment') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('Payment is due in full at the time of ordering. Accepted payment methods are indicated at checkout. All transactions are secured by SSL encryption. In the event of payment default, the order will be automatically cancelled.') }}
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-3">{{ useTrans('6. Delivery') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('Products are delivered to the address indicated by the Customer at the time of ordering. Delivery times are given as an indication only and any delay shall not entitle the Customer to claim damages or to cancel the order.') }}
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-3">{{ useTrans('7. Right of withdrawal') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('In accordance with applicable consumer protection legislation, the Customer has a period of 14 days from receipt of the goods to exercise their right of withdrawal, without having to provide a reason. The Customer must return the item in its original condition and packaging at their own expense.') }}
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-3">{{ useTrans('8. Warranty') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('All products benefit from the legal warranty of conformity and the warranty against hidden defects, as provided by the applicable law. In the event of a defect, the Customer must contact customer service within a reasonable time from discovery of the defect.') }}
                </p>
            </section>

            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-3">{{ useTrans('9. Applicable law') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ useTrans('These terms and conditions are governed by French law. In the event of a dispute, the parties shall seek an amicable settlement before referring the matter to the competent courts.') }}
                </p>
            </section>
        </div>
    </AppShopLayout>
</template>
