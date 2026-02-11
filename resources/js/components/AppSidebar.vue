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
import { showBO, showManufacturers, showProducts, showSuppliers, showCategories, showTaxes, showCarriers, showCustomers, showTeam } from '@/routes/admin/back-office';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Back Office',
        href: showBO(),
        icon: LayoutGrid,
    },
    {
        title: 'Products',
        href: showProducts(),
        icon: LayoutGrid,
    },
    {
        title: 'Manufacturers',
        href: showManufacturers(),
        icon: LayoutGrid,
    },
    {
        title: 'Suppliers',
        href: showSuppliers(),
        icon: LayoutGrid,
    },
    {
        title: 'Categories',
        href: showCategories(),
        icon: LayoutGrid,
    },
    {
        title: 'Taxes and Tax Rules',
        href: showTaxes(),
        icon: LayoutGrid,
    },
    {
        title: 'Carriers',
        href: showCarriers(),
        icon: LayoutGrid,
    },
    {
        title: 'Customers',
        href: showCustomers(),
        icon: LayoutGrid,
    },
    {
        title: 'Team',
        href: showTeam(),
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
                        <Link :href="showBO()">
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
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
