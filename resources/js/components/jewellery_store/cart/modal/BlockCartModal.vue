<script setup lang="ts">
import { Product } from '@/types/product';
import { ref } from "vue";
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
// état ouverture modal
const isOpen = ref(props.isOpenValue ? props.isOpenValue : false)
const close = () => {
  isOpen.value = false
}
const baseImagePath = 'storage/img/p/';
</script>

<template>
  <div
    v-if="isOpen"
    class="absolute inset-0 z-10 flex items-center justify-end"
    tabindex="-1"
    role="dialog"
    style="display: block;"
  >
    <div class="relative w-full max-w-2xl h-full bg-white shadow-xl overflow-y-auto">
        <div id="modal-content" class="flex flex-col justify-between h-full">
            <div id="modal-header" class="flex items-center justify-between p-4 border-b">
                <p class="text-xl font-semibold">
                    Produit ajouté au panier avec succès
                </p>
                <button id="close" class="text-gray-500 hover:text-black" @click="close">
                    <X/>
                </button>
            </div>

            <div id="modal-body" class="p-4 space-y-6">
                <ul v-for="product in products" id="col-12 mb-3" :key="product.id" class="flex gap-4">
                    <li id="media w-100">
                        <img
                            id="product-image" class="w-24 h-24 object-cover rounded"
                            :src="baseImagePath.concat(product.id.toString(), '/product-1.jpg')"
                            :alt="product.name"
                            width="300"
                        />
                        <div id="media-body" class="flex-1">
                            <p id="product-name" class="font-medium line-clamp-2">{{ product.name }}</p>
                            <p id="product-price" class="text-lg font-semibold mt-1">{{ product.retail_price }} €</p>
                            <p>x 1</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div id="modal-footer" class="p-4 border-t space-y-2">
                <div id="cart-content" class="bg-gray-100 p-4 rounded space-y-2 text-sm">
                    <p id="font-weight-bold">
                        Il y a {{ cartProductsCount }} article(s) dans votre panier.
                    </p>

                    <p class="flex justify-between">
                        <span>Transport :</span>
                        <span>{{ defaultShippingRatePrice }} €</span>
                    </p>
                </div>
                <a :href="show({locale: props.locale})" class="block w-full text-center bg-shop-primary text-white py-3 rounded-lg font-semibold hover:bg-red-800 transition">
                    Commander
                </a>
                <button class="w-full border border-gray-300 py-3 rounded-lg hover:bg-gray-100 transition" @click="close">
                    Continuer mes achats
                </button>
            </div>
        </div>
    </div>
  </div>

  <!-- backdrop -->
  <div v-if="isOpen" class="modal-backdrop fade show"></div>
</template>