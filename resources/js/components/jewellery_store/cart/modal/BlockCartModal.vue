<script setup lang="ts">
import { Product } from '@/types/product';
import { ref, watch } from "vue";
import { show } from "@/routes/cart"
import { X } from 'lucide-vue-next';

interface BlockCartModal {
    products: Product[]
    productsQuantity: number
    productsPrice: number
    cartProductsCount: number
    defaultShippingRatePrice: number
    locale: string
    isOpenValue: boolean
}

const props = defineProps<BlockCartModal>()
const emit = defineEmits<{ 'update:isOpenValue': [value: boolean] }>()

const isOpen = ref(props.isOpenValue)

watch(() => props.isOpenValue, (val) => {
    isOpen.value = val
})

const close = () => {
    isOpen.value = false
    emit('update:isOpenValue', false)
}

const baseImagePath = 'storage/img/p/';
</script>

<template>
    <Teleport to="body">
        <Transition name="fade">
            <div
                v-if="isOpen"
                class="fixed inset-0 z-40 bg-black/50"
                aria-hidden="true"
                @click="close"
            />
        </Transition>

        <Transition name="slide-from-right">
            <div
                v-if="isOpen"
                class="fixed top-0 right-0 z-50 h-full w-full max-w-md bg-white shadow-xl flex flex-col"
                role="dialog"
                aria-modal="true"
                aria-label="Cart"
            >
                <!-- En-tête -->
                <div class="flex items-center justify-between p-4 border-b shrink-0">
                    <p class="text-xl font-semibold">
                        Product as been sucessfully added to cart
                    </p>
                    <button
                        class="text-gray-500 hover:text-black transition-colors"
                        aria-label="Closing the cart"
                        @click="close"
                    >
                        <X />
                    </button>
                </div>

                <!-- Corps -->
                <div class="flex-1 overflow-y-auto p-4">
                    <ul class="space-y-4">
                        <li v-for="product in products" :key="product.id" class="flex gap-4">
                            <img
                                class="w-24 h-24 object-cover rounded shrink-0"
                                :src="baseImagePath.concat(product.id.toString(), '/product-1.jpg')"
                                :alt="product.name"
                                width="96"
                            />
                            <div class="flex-1 min-w-0">
                                <p class="font-medium line-clamp-2">{{ product.name }}</p>
                                <p class="text-lg font-semibold mt-1">{{ product.retail_price }} €</p>
                                <p class="text-sm text-gray-500">x 1</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Pied de page -->
                <div class="p-4 border-t space-y-3 shrink-0">
                    <div class="bg-gray-100 p-4 rounded space-y-2 text-sm">
                        <p class="font-medium">
                            There's {{ cartProductsCount }} product(s) in your cart.
                        </p>
                        <p class="flex justify-between">
                            <span>Shipping cost :</span>
                            <span>{{ defaultShippingRatePrice }} €</span>
                        </p>
                    </div>
                    <a
                        :href="show({ locale: props.locale })"
                        class="block w-full text-center bg-shop-primary text-white py-3 rounded-lg font-semibold hover:bg-red-800 transition"
                    >
                        Checkout
                    </a>
                    <button
                        class="w-full border border-gray-300 py-3 rounded-lg hover:bg-gray-100 transition"
                        @click="close"
                    >
                        Continue Shopping
                    </button>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
.slide-from-right-enter-active,
.slide-from-right-leave-active {
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.slide-from-right-enter-from,
.slide-from-right-leave-to {
    transform: translateX(100%);
}
.slide-from-right-enter-to,
.slide-from-right-leave-from {
    transform: translateX(0);
}
</style>
