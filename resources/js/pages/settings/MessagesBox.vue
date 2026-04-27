<script setup lang="ts">
import { computed, provide, ref, watch } from 'vue';
import ShopHeader from '@/components/jewellery_store/ShopHeader.vue';
import BurgerMenu from '@/components/jewellery_store/nav/mobile/BurgerMenu.vue';
import { useWindowSize } from '@vueuse/core';
import ShopFooter from '@/components/jewellery_store/ShopFooter.vue';
import { Category } from '@/types/category';
import MessagesMenu from "@/components/jewellery_store/message/MessagesMenu.vue";
import MessagesReceived from '@/components/jewellery_store/message/MessagesReceived.vue';
import MessagesSended from '@/components/jewellery_store/message/MessagesSended.vue';
import { Message } from '@/types/message';
import SettingsLayout from '@/layouts/settings/Layout.vue';

interface ContactPageProps {
    frontCategories: Category[]
    cartProductsCount: number
    seller_email: string
    messagesReceived: Message[]
    messagesSended: Message[]
    locale: string
}

const props =  defineProps<ContactPageProps>();
const { width } = useWindowSize()
const active = ref<boolean>(false)
provide('active', active)
const openNav = () => {
  active.value = true
}

const choices = [
    MessagesReceived,
    MessagesSended,
]

const currentChoice = ref(0);

const currentComponent = computed(() => choices[currentChoice.value])

const selectChoice = (key: number) => {
  currentChoice.value = key
}

const isReceivedBoxSelected = ref(false)
provide('isReceivedBoxSelected', isReceivedBoxSelected)
const isSendedBoxSelected = ref(false)
provide('isSendedBoxSelected', isSendedBoxSelected)
const isHomeSelected = ref(false)
provide('isHomeSelected', isHomeSelected)

watch(
  () => isReceivedBoxSelected.value, (value) => {
    if (value === true) {
      currentChoice.value = 0;
    }
  }
)

watch(
  () => isSendedBoxSelected.value, (value) => {
    if (value === true) {
      currentChoice.value = 1;
    }
  }
)
</script>

<template>
    <button v-if="width <= 430" id="openBtn" @click="openNav" class="absolute top-0 left-0 flex flex-col gap-1 p-4 bg-white z-[2]">
        <div class="w-[20px] h-0.5 bg-shop-primary"></div>
        <div class="w-[20px] h-0.5 bg-shop-primary"></div>
        <div class="w-[20px] h-0.5 bg-shop-primary"></div>
    </button>
    <ShopHeader v-if="width > 430" :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :locale="props.locale"></ShopHeader>
    <BurgerMenu v-else :frontCategories="props.frontCategories" :cartProductsCount="props.cartProductsCount" :active="active" :locale="props.locale"></BurgerMenu>
    <main class="items-center min-h-screen p-6 text-[#1b1b18] lg:justify-center lg:p-8 bg-neutral-200 dark:bg-[#0a0a0a]">
        <SettingsLayout :locale="props.locale">

        <div id="message-box-wrapper" class="lg:mx-10 flex flex-col gap-2 w-80 lg:w-[64rem]">
            <div id="message-menu-wrapper">
                <MessagesMenu @selectChoice="selectChoice"></MessagesMenu>
            </div>

            <section id="messages-box-section" class="py-6 px-8 h-80 lg:h-[48rem] w-80 lg:w-[64rem] rounded-lg">
                <div id="message-resume" class="my-10 bg-white py-4 px-6">
                    <div id="message-resume-header">
                        <h1 id="message-resume-heading" class="text-2xl mb-8">Message Box</h1>
                    </div>
                    <div id="message-resume-body">
                        <p>Received : </p>
                        <p>Sent :  </p>
                    </div>
                </div>
                <component
                    :is="currentComponent"
                    :messagesReceived="props.messagesReceived"
                    :messagesSended="props.messagesSended"
                    :is-last="currentChoice === choices.length - 1"
                />
            </section>
        </div>
        </SettingsLayout>
    </main>
    <ShopFooter :locale="props.locale"></ShopFooter>
</template>