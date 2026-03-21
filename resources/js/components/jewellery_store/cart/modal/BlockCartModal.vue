<script setup lang="ts">
import axios from 'axios'
import { Product } from '@/types/product';
import { ref } from "vue";
import { route } from '../../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../../../ziggy.js';import SearchProductCard from './card/SearchProductCard.vue';
import { Category } from '@/types/category';
import { X } from 'lucide-vue-next';


interface CartProduct {
    product_id: number
    name: string
    quantity: number
    price: number
}

interface BlockCartModal {
    products: Array<CartProduct>
    sub_total_price: number
    cartProductsCount: number
    defaultShippingRatePrice: number
}

const props = defineProps<BlockCartModal>()
const total_price = props.sub_total_price + props.defaultShippingRatePrice
// état ouverture modal
const isOpen = ref(true)
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
    <div class="relative w-full max-w-2xl h-full bg-white shadow-xl overflow-y-auto py">
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
                <ul v-for="product in products" id="col-12 mb-3" :key="product.product_id" class="flex gap-4">
                    <li id="media w-100">
                        <img
                            id="product-image" class="w-24 h-24 object-cover rounded"
                            :src="baseImagePath.concat(product.product_id.toString(), '/product-1.jpg')"
                            :alt="product.name"
                            width="300"
                        />
                        <div id="media-body" class="flex-1">
                            <p id="product-name" class="font-medium line-clamp-2">{{ product.name }}</p>
                            <p id="product-price" class="text-lg font-semibold mt-1">{{ product.price }} €</p>
                            <p>
                                Quantité : <strong>{{ product.quantity }}</strong>
                            </p>
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
                        <span>Sous-total :</span>
                        <span>{{ sub_total_price }} €</span>
                    </p>
                    <p class="flex justify-between">
                        <span>Transport :</span>
                        <span>{{ defaultShippingRatePrice }} €</span>
                    </p>
                    <p class="flex justify-between font-bold text-base pt-2 border-t">
                        <span>Total TTC :</span>
                        <span>{{ total_price }} €</span>
                    </p>
                </div>
                <a href="/cart" class="block w-full text-center bg-[#84070F] text-white py-3 rounded-lg font-semibold hover:bg-red-800 transition">
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