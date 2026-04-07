<script setup lang="ts">
import { register } from '@/routes';
import { showBO }  from '@/routes/admin/back-office'
import { Link } from '@inertiajs/vue3';
import LogoutButton from '@/components/jewellery_store/button/LogoutButton.vue'
import { Category } from '@/types/category';
import CartNotifier from '@/components/jewellery_store/cart/notifier/CartNotifier.vue';
import CategoryMenu from './nav/CategoryMenu.vue';
import SearchBar from './SearchBar.vue';
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '@/ziggy';
import { edit } from '@/routes/profile';

interface ShopHeaderProps {
    frontCategories: Category[]
    cartProductsCount: number
    locale: string
}

const props = defineProps<ShopHeaderProps>()
</script>

<template>
    <header class="flex flex-col w-full text-sm not-has-[nav]:hidden">
        <nav class="flex items-center justify-around gap-4 px-4 py-6">
            <SearchBar />
            <div id="nav-center" class="flex flex-row items-center gap-6">
                <figure>
                    <img src="/storage/img/home/logo_128x128.png" alt="">
                </figure>
                <h1 class="text-2xl">
                    <a :href="route('home', {locale:props.locale}, false, Ziggy)">Joaillerie Orient</a>
                </h1>
            </div>
            <Link
                v-if="$page.props.auth.user"
                :href="showBO({locale: props.locale})"
                class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
            >
                Dashboard
            </Link>
            <Link
                v-if="$page.props.auth.customer"
                :href="edit({locale: props.locale})"
                class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
            >
                Settings
            </Link>

            <LogoutButton :locale="props.locale" v-if="$page.props.auth.user">Logout</LogoutButton>
            <LogoutButton :locale="props.locale" v-else-if="$page.props.auth.customer">Logout</LogoutButton>
            <template v-else>
                <Link
                    :href="route('customer-login', {locale: props.locale}, false, Ziggy)"
                    class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A] min-w-fit"
                >
                    Log in
                </Link>
                <Link
                    :href="register({locale: props.locale})"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Register
                </Link>
            </template>
            <CartNotifier :cartProductsCount="props.cartProductsCount" :locale="props.locale"></CartNotifier>
        </nav>
        <CategoryMenu :locale="props.locale" :frontCategories=props.frontCategories></CategoryMenu>
    </header>
</template>