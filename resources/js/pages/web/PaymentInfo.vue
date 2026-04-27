<script setup lang="ts">
import type { Category } from '@/types/category';
import { Head } from '@inertiajs/vue3';
import AppShopLayout from '@/layouts/AppShopLayout.vue';

interface PaymentInfoProps {
    frontCategories: Category[]
    cartProductsCount: number
    locale: string
}

const props = defineProps<PaymentInfoProps>();
</script>

<template>
    <Head title="Informations de Paiement">
        <meta name="description" content="Découvrez les moyens de paiement acceptés sur JewelleryStore. Paiement sécurisé par SSL, cartes bancaires et autres options disponibles." head-key="description" />
    </Head>
    <AppShopLayout :isHome="false" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale">
        <h2>
            Payment Informations
        </h2>
        <p>
            Our website adopts SSL (Secure Socket Layer) to protect your data, ensuring every customer a safe and secure shopping experience.<br>
            You will be diverted to an online payment gateway after submitting the order.<br>
            Fill in the information required to complete the purchase.
        </p>
        <div id="payment-info-list">
            <div id="payment-info-table-wrapper" class="my-0">
                <table class="w-[1250px] border border-gray-300 border-collapse">
                    <tbody>
                        <tr>
                            <td colspan="2" class="border p-1 pl-3 font-semibold">
                                Payment Methods
                            </td>
                        </tr>

                        <tr>
                            <td class="border p-1 pl-3 align-top">
                                Credit card
                            </td>
                            <td class="border p-1 pl-3">
                                Visa<br>
                                UnionPay<br>
                                Mastercard<br>
                                American Express
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-1 pl-3 align-top">
                                Third-party payment platform
                            </td>
                            <td class="border p-1 pl-3">
                                WeChat Pay HK<br>
                                AlipayHK
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppShopLayout>
</template>