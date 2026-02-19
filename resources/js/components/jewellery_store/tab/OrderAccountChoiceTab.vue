<script setup lang="ts">
import OrderAccountLoginForm from '../form/OrderAccountLoginForm.vue';
import { ref } from 'vue'
import OrderAccountRegisterForm from '../form/OrderAccountRegisterForm.vue';

interface OrderAccountFormProps {
    classname:string
    status?: string;
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
        <div id="order-account-choice" class="my-2 mx-4 w-[700px] max-w-[700px] gap-1">
            <div id="account-choice-tab-button" class="flex flex-col">
                <button @click="selectLogin()" class="bg-white px-3 py-2 mx-4">Login Account</button>
                <button @click="selectRegister()" class="bg-white px-3 py-2 my-2 mx-4">Register Account</button>
            </div>
            <div v-if="isLogin === true"><OrderAccountLoginForm classname="" :status="props.status"></OrderAccountLoginForm></div>
            <div v-if="isRegister === true"><OrderAccountRegisterForm></OrderAccountRegisterForm></div>
        </div>
    </section>
</template>