<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import type { User } from '@/types/user'
import UsersList from '@/components/jewellery_store/list/users/UsersList.vue'
import { router } from '@inertiajs/vue3'
import { ref } from "vue";
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../../ziggy.js';

interface UsersProps {
  users: User[]
  filters: {
    sortBy: string
    order: string
  }
}  

const props = defineProps<UsersProps>()
  
const sortBy = ref<string>(props.filters.sortBy || 'id')
const order = ref<'asc' | 'desc'>((props.filters.order as 'asc' | 'desc') || 'desc')

const url = route('admin.back-office.showTeam', {}, false, Ziggy);

const updateUsersFilters = () => {
  router.get(url, {
    sortBy: sortBy.value,
    order: order.value,
  });
}

const navigate = (url: string) => {
  router.visit(url, { preserveScroll: true, preserveState: true })
}
</script>

<template>
    <Head title="Users" />
    <AppLayout>
      <div id="customers-page-wrapper"  class="items-center min-h-screen p-10 text-[#1b1b18] lg:justify-center lg:p-14 bg-neutral-200 dark:bg-[#0a0a0a]">
        <h2 class="text-3xl my-6">Users</h2>
        <section id="customers-top-wrapper" class="flex lg:flex-row sm:flex-col lg:my-0 sm:my-6 justify-between items-center">
            <div id="customers-filters-wrapper" class="flex flex-row my-6 gap-4">
              <label for="sortBy" class="my-4">Trier par :</label>
              <select id="sortBy" v-model="sortBy" @change="updateUsersFilters" class="rounded-md bg-neutral-100 px-2">
                <option value="id">Id</option>
                <option value="name">Nom</option>
                <option value="email">Email</option>
                <option value="created_at">Date de création</option>
              </select>
              <select id="order" v-model="order" @change="updateUsersFilters" class="rounded-md bg-neutral-100 px-2">
                <option value="asc">Ascendant</option>
                <option value="desc">Descendant</option>
              </select>
            </div>
            <nav id="customers-top-nav" class="flex flex-row">
            </nav>
        </section>

        <UsersList
          classname=""
          :users=props.users
          :sort-by="sortBy"
          :order="order"
        />
      </div>
    </AppLayout>
</template>