<script setup lang="ts">
import { login, register } from '@/routes';
import { showBO }  from '@/routes/admin/back-office'
import { Link } from '@inertiajs/vue3';
import LogoutButton from '@/components/jewellery_store/button/LogoutButton.vue'
import { Category } from '@/types/category';
import CartNotifier from '@/components/jewellery_store/cart/notifier/CartNotifier.vue';
import CategoryMenu from './nav/CategoryMenu.vue';
import SearchBar from './SearchBar.vue';

interface ShopHeaderProps {
    frontCategories: Category[]
    cartProductsCount: number
}

const props = defineProps<ShopHeaderProps>()
</script>

<template>
    <header class="w-full text-sm not-has-[nav]:hidden">
        <nav class="flex items-center justify-around gap-4 px-4 py-6">
            <CategoryMenu :frontCategories=props.frontCategories></CategoryMenu>
            <SearchBar />
            <Link
                v-if="$page.props.auth.user"
                :href="showBO()"
                class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
            >
                Dashboard
            </Link>
            <Link
                v-if="$page.props.auth.customer"
                href="#"
                class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
            >
                Settings
            </Link>

            <LogoutButton v-if="$page.props.auth.user">Logout</LogoutButton>
            <LogoutButton v-else-if="$page.props.auth.customer">Logout</LogoutButton>
            <template v-else>
                <Link
                    :href="login()"
                    class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                >
                    Log in
                </Link>
                <Link
                    :href="register()"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Register
                </Link>
            </template>
            <CartNotifier :cartProductsCount="props.cartProductsCount"></CartNotifier>
        </nav>
    </header>
</template>