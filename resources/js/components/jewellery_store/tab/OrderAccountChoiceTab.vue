<script setup lang="ts">
import OrderAccountLoginForm from '../form/OrderAccountLoginForm.vue';
import { ref } from 'vue'
import OrderAccountRegisterForm from '../form/OrderAccountRegisterForm.vue';

interface OrderAccountFormProps {
    status?: string;
    isAddressSelected: boolean
    locale: string
}
const isLogin = ref(false);
const isRegister = ref(false);

const selectLogin = () => {
    isRegister.value = false;
    isLogin.value = true;
}

const selectRegister = () => {
    isLogin.value = false;
    isRegister.value = true;
}

const props = defineProps<OrderAccountFormProps>();
</script>

<template>
    <section class="py-8 px-4 lg:px-0">
        <div class="mx-auto w-full max-w-[60rem] lg:max-w-none flex flex-col gap-1">

            <div class="bg-white flex flex-col justify-center px-3 py-6 rounded-md" aria-current="step">
                <h2 class="text-xl mx-3 my-2">1. Connecting an account</h2>
                <div v-if="!$page.props.auth.customer" class="flex flex-col sm:flex-row justify-center my-4 gap-3 px-3">
                    <button
                        @click="selectLogin()"
                        class="bg-shop-primary px-4 py-2 text-white font-bold rounded-md hover:bg-[#a32a32] focus-visible:ring-2 focus-visible:ring-shop-primary focus-visible:ring-offset-2 transition-colors"
                    >Login Account</button>
                    <button
                        @click="selectRegister()"
                        class="bg-shop-primary px-4 py-2 text-white font-bold rounded-md hover:bg-[#a32a32] focus-visible:ring-2 focus-visible:ring-shop-primary focus-visible:ring-offset-2 transition-colors"
                    >Register Account</button>
                </div>
            </div>

            <div v-if="isLogin === true">
                <OrderAccountLoginForm :locale="props.locale" classname="" :status="props.status" />
            </div>
            <div v-if="isRegister === true">
                <OrderAccountRegisterForm :locale="props.locale" />
            </div>

            <button
                @click="$emit('selectStep', 1)"
                :disabled="!$page.props.auth.customer"
                class="bg-white py-6 my-2 w-full rounded-t-md text-left transition-colors"
                :class="$page.props.auth.customer
                    ? 'hover:bg-gray-50 cursor-pointer focus-visible:ring-2 focus-visible:ring-shop-primary focus-visible:ring-offset-2'
                    : 'opacity-50 cursor-not-allowed'"
                aria-label="Step 2: Delivery address"
            >
                <h2 class="text-xl px-3 py-4">2. Delivery address</h2>
            </button>

            <button
                @click="$emit('selectStep', 2)"
                :disabled="!isAddressSelected"
                class="bg-white py-6 my-2 w-full rounded-t-md text-left transition-colors"
                :class="isAddressSelected
                    ? 'hover:bg-gray-50 cursor-pointer focus-visible:ring-2 focus-visible:ring-shop-primary focus-visible:ring-offset-2'
                    : 'opacity-50 cursor-not-allowed'"
                aria-label="Step 3: Select a carrier"
            >
                <h2 class="text-xl px-3 py-4">3. Select a carrier</h2>
            </button>

        </div>
    </section>
</template>
