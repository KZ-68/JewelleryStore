<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { showManufacturers, showProducts, showSuppliers, showCategories, showTaxes, showCarriers, showCustomers, showTeam } from '@/routes/admin/back-office';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { route } from '../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '../ziggy';

const props = defineProps<{
    locale: string
}>();

const mainNavItems: NavItem[] = [
    {
        title: 'Back Office',
        href: route('admin.back-office.showBO', {locale: props.locale}, false, Ziggy),
        icon: LayoutGrid,
    },
    {
        title: 'Products',
        href: showProducts({locale: props.locale}),
        icon: LayoutGrid,
    },
    {
        title: 'Manufacturers',
        href: showManufacturers({locale: props.locale}),
        icon: LayoutGrid,
    },
    {
        title: 'Suppliers',
        href: showSuppliers({locale: props.locale}),
        icon: LayoutGrid,
    },
    {
        title: 'Categories',
        href: showCategories({locale: props.locale}),
        icon: LayoutGrid,
    },
    {
        title: 'Taxes and Tax Rules',
        href: showTaxes({locale: props.locale}),
        icon: LayoutGrid,
    },
    {
        title: 'Carriers',
        href: showCarriers({locale: props.locale}),
        icon: LayoutGrid,
    },
    {
        title: 'Customers',
        href: showCustomers({locale: props.locale}),
        icon: LayoutGrid,
    },
    {
        title: 'Team',
        href: showTeam({locale: props.locale}),
        icon: LayoutGrid,
    },
];

const footerNavItems: NavItem[] = [];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('admin.back-office.showBO', {locale: props.locale}, false, Ziggy)">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser :locale="props.locale" />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
