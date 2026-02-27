<script setup lang="ts">
import { login, register } from '@/routes';
import { showBO }  from '@/routes/admin/back-office'
import { Link } from '@inertiajs/vue3';
import LogoutButton from '@/components/jewellery_store/button/LogoutButton.vue'
import { Category } from '@/types/category';
import CartNotifier from '@/components/jewellery_store/cart/notifier/CartNotifier.vue';
import CategoryMenu from '../../nav/CategoryMenu.vue';
import SearchBar from '../../SearchBar.vue';
import { inject, reactive, Ref } from 'vue';

interface BurgerMenuProps {
    frontCategories: Category[]
    cartProductsCount: number
}

const props = defineProps<BurgerMenuProps>();
const active = inject<Ref<boolean>>('active')!

const closingNav = () => {
  active.value = false
}
</script>

<template>
  <nav :data-active="active" class="fixed w-96 pb-10 transition-transform duration-300 ease-in-out data-[active=false]:translate-x-[-380px] data-[active=true]:translate-x-[0px] top-0 z-[2] bg-white">
    <div class="relative flex flex-col items-center justify-around gap-4 ">
      <div id="burger-menu-top" class="flex flex-row items-center">
        <button id="closeBtn" @click="closingNav" href="#" class="absolute top-0 right-0 p-4">
          <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
        </button>
        <h1 class="text-xl py-3 align-middle">MENU</h1>
        <CartNotifier :cartProductsCount="props.cartProductsCount"></CartNotifier>

      </div>

      <CategoryMenu :frontCategories=props.frontCategories></CategoryMenu>

      <Link
          
          :href="showBO()"
          class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
          v-if="$page.props.auth.user"
      >
          Dashboard
      </Link>

      <LogoutButton v-if="$page.props.auth.user">Logout</LogoutButton>
      <LogoutButton v-else-if="$page.props.auth.customer">Logout</LogoutButton>
      <template v-else>
          <div class="flex flex-row gap-3">
            <Link
              :href="login()"
              class="inline-block w-36 rounded-sm border border-[#19140035] px-5 py-1.5 text-sm text-center leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
            >
              Log in
            </Link>
            <Link
                :href="register()"
                class="inline-block w-36 rounded-sm border border-[#19140035] px-5 py-1.5 text-sm text-center leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
            >
              Register
            </Link>
          </div>
      </template>
      <SearchBar />
    </div>
  </nav>
</template>