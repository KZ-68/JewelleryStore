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
    <section id="order-account-choice-wrapper" class="py-8">
        <div id="order-account-choice" class="my-2 mx-4 w-[60rem] max-w-[60rem] gap-1">
            <div id="account-choice-tab-button" class="bg-white flex flex-col justify-center px-3 py-6 rounded-md">
                <h2 class="text-xl  mx-3 my-2">1. Connecting an account</h2>
                <div v-if="!$page.props.auth.customer" class="flex flex-row justify-center my-4">
                    <button @click="selectLogin()" class="bg-[#84070F] px-3 py-2 mx-4 text-white font-bold rounded-md hover:cursor-pointer hover:bg-[#a32a32]">Login Account</button>
                    <button @click="selectRegister()" class="bg-[#84070F] px-3 py-2 mx-4 text-white font-bold rounded-md hover:cursor-pointer hover:bg-[#a32a32]">Register Account</button>
                </div>
            </div>
            <div v-if="isLogin === true"><OrderAccountLoginForm :locale="props.locale" classname="" :status="props.status"></OrderAccountLoginForm></div>
            <div v-if="isRegister === true"><OrderAccountRegisterForm :locale="props.locale"></OrderAccountRegisterForm></div>
            <button v-if="$page.props.auth.customer" @click="$emit('selectStep', 1)" id="order-address-step-tab" class="bg-white py-6 my-2 w-[60rem] max-w-[60rem] rounded-t-md hover:cursor-pointer hover:bg-gray-50">
                <h2 class="text-left text-xl px-3 py-4">2. Delivery address</h2>
            </button>
            <button v-else id="order-address-step-tab" class="bg-white py-6 my-2 w-[60rem] max-w-[60rem] rounded-t-md">
                <h2 class="text-left text-xl px-3 py-4">2. Delivery address</h2>
            </button>
            <button v-if="isAddressSelected === true" @click="$emit('selectStep', 2)" id="order-address-step-tab" class="bg-white py-6 my-2 w-[60rem] max-w-[60rem] rounded-t-md hover:cursor-pointer :hover:hover:bg-gray-50">
                <h2 class="text-left text-xl px-3 py-4">3. Select a carrier</h2>
            </button>
            <button v-else id="order-address-step-tab" class="bg-white py-6 my-2 w-[60rem] max-w-[60rem] rounded-t-md">
                <h2 class="text-left text-xl px-3 py-4">3. Select a carrier</h2>
            </button>
        </div>
    </section>
</template>