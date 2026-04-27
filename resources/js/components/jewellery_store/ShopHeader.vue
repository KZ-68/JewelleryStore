<script setup lang="ts">
import { register } from '@/routes';
import { showBO }  from '@/routes/admin/back-office'
import { Link } from '@inertiajs/vue3';
import LogoutButton from '@/components/jewellery_store/button/LogoutButton.vue'
import { Category } from '@/types/category';
import CartNotifier from '@/components/jewellery_store/cart/notifier/CartNotifier.vue';
import CategoryMenu from './nav/CategoryMenu.vue';
import SearchBar from './SearchBar.vue';
import LanguageSwitcher from '@/components/jewellery_store/LanguageSwitcher.vue';
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '@/ziggy';
import { edit } from '@/routes/profile';
import { useTrans } from '@/composables/trans';

interface ShopHeaderProps {
    frontCategories: Category[]
    cartProductsCount: number
    locale: string
}

const props = defineProps<ShopHeaderProps>()

const linkClass = 'rounded-sm border border-[#19140035] px-2.5 md:px-3 lg:px-4 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]'
</script>

<template>
    <header class="sticky top-0 z-40 flex flex-col w-full bg-white shadow-sm text-sm">
        <nav aria-label="Navigation principale" class="flex items-center justify-between gap-2 lg:gap-4 px-4 md:px-6 py-4 max-w-screen-2xl mx-auto w-full">
            <div class="w-28 md:w-40 lg:flex-1 lg:max-w-xs shrink-0">
                <SearchBar />
            </div>

            <a
                :href="route('home', {locale: props.locale}, false, Ziggy)"
                class="flex items-center gap-2 shrink-0 group focus:outline-none focus:ring-2 focus:ring-[#84070F] rounded-sm"
                aria-label="Joaillerie Orient"
            >
                <figure aria-hidden="true" class="shrink-0">
                    <img src="/storage/img/home/logo_128x128.png" alt="" class="h-9 w-9 lg:h-10 lg:w-10 object-contain">
                </figure>
                <span class="hidden lg:block text-xl font-semibold text-gray-900 group-hover:text-[#84070F] transition-colors">
                    Joaillerie Orient
                </span>
            </a>

            <div class="flex items-center gap-1.5 lg:gap-3 shrink-0">
                <Link
                    v-if="$page.props.auth.user"
                    :href="showBO({locale: props.locale})"
                    :class="linkClass"
                    class="hidden md:inline-flex"
                >
                    {{ useTrans('Dashboard') }}
                </Link>
                <Link
                    v-if="$page.props.auth.customer"
                    :href="edit({locale: props.locale})"
                    :class="linkClass"
                    class="hidden md:inline-flex"
                >
                    {{ useTrans('Settings') }}
                </Link>
                <LogoutButton :locale="props.locale" v-if="$page.props.auth.user">{{ useTrans('Logout') }}</LogoutButton>
                <LogoutButton :locale="props.locale" v-else-if="$page.props.auth.customer">{{ useTrans('Logout') }}</LogoutButton>
                <template v-else>
                    <Link
                        :href="route('customer-login', {locale: props.locale}, false, Ziggy)"
                        class="rounded-sm border border-transparent px-2.5 lg:px-4 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] transition-colors focus:outline-none focus:ring-2 focus:ring-[#84070F] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                        {{ useTrans('Log in') }}
                    </Link>
                    <Link
                        :href="register({locale: props.locale})"
                        :class="linkClass"
                        class="hidden sm:inline-flex"
                    >
                        {{ useTrans('Register') }}
                    </Link>
                </template>

                <LanguageSwitcher :locale="props.locale" />
                <CartNotifier :cartProductsCount="props.cartProductsCount" :locale="props.locale" />
            </div>
        </nav>

        <div class="border-t border-gray-100">
            <CategoryMenu :locale="props.locale" :frontCategories="props.frontCategories" />
        </div>
    </header>
</template>
