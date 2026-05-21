<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { toUrl, urlIsActive } from '@/lib/utils';
import { edit as editAppearance } from '@/routes/appearance';
import { edit as editPassword } from '@/routes/password';
import { edit as editProfile } from '@/routes/profile';
import { showAddresses } from '@/routes/addresses';
import { show } from '@/routes/two-factor';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { showInvoices } from '@/routes/invoices';
import { sellerPage } from '@/routes/seller';
import { computed } from 'vue';

const props = defineProps<{
    locale: string
    wide?: boolean
}>();

const page = usePage()

const isSeller = computed(() => (page.props.auth.roles as string[]).includes('seller'));

const sidebarNavItems = computed<NavItem[]>(() => {
    const items: NavItem[] = [
        { title: 'Profile',        href: editProfile({locale: props.locale}) },
        { title: 'Password',       href: editPassword({locale: props.locale}) },
        { title: 'Two-Factor Auth', href: show({locale: props.locale}) },
        { title: 'Appearance',     href: editAppearance({locale: props.locale}) },
        { title: 'Addresses',      href: showAddresses({locale: props.locale}) },
        { title: 'Invoices',       href: showInvoices({locale: props.locale}) },
    ];

    if (isSeller.value) {
        items.push({ title: 'Seller Page', href: sellerPage({locale: props.locale}) });
    }

    return items;
});

const currentPath = typeof window !== undefined ? window.location.pathname : '';
</script>

<template>
    <div class="px-4 py-24">
        <Heading
            title="Settings"
            description="Manage your profile and account settings"
        />

        <div class="flex flex-col lg:flex-row lg:space-x-12">

            <!-- Mobile : barre horizontale scrollable -->
            <aside class="lg:hidden w-full">
                <nav class="flex flex-row overflow-x-auto gap-1 pb-1 scrollbar-none">
                    <Link
                        v-for="item in sidebarNavItems"
                        :key="toUrl(item.href)"
                        :href="item.href"
                        :class="[
                            'flex items-center gap-1.5 whitespace-nowrap shrink-0 rounded-md px-3 py-2 text-sm font-medium transition-colors',
                            urlIsActive(item.href, currentPath)
                                ? 'bg-muted text-foreground'
                                : 'text-muted-foreground hover:bg-muted hover:text-foreground',
                        ]"
                    >
                        <component :is="item.icon" class="h-4 w-4 shrink-0" />
                        {{ item.title }}
                    </Link>
                </nav>
                <Separator class="mt-3" />
            </aside>

            <!-- Desktop : sidebar verticale -->
            <aside class="hidden lg:block lg:w-48 shrink-0">
                <nav class="flex flex-col space-y-1">
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="toUrl(item.href)"
                        variant="ghost"
                        :class="[
                            'w-full justify-start',
                            { 'bg-muted': urlIsActive(item.href, currentPath) },
                        ]"
                        as-child
                    >
                        <Link :href="item.href">
                            <component :is="item.icon" class="h-4 w-4" />
                            {{ item.title }}
                        </Link>
                    </Button>
                </nav>
            </aside>

            <div :class="['flex-1 min-w-0 mt-6 lg:mt-0', !wide && 'md:max-w-2xl']">
                <section :class="[wide ? 'w-full' : 'max-w-xl', 'space-y-12']">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
