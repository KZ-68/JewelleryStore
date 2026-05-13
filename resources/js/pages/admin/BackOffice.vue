<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineAsyncComponent } from 'vue';

const SalesDoughnutChart = defineAsyncComponent(() => import('@/components/SalesDoughnutChart.vue'));

const COLORS = ['#d0bcd4', '#30c4e4', '#c8ecac', '#f4a261', '#e76f51', '#a8dadc'];

defineProps<{
    locale: string;
    totalOrders: number;
    totalCustomers: number;
    totalProducts: number;
    totalRevenue: number;
    ordersByStatus: Array<{ label: string; count: number }>;
}>();
</script>

<template>
    <Head title="BackOffice" />

    <AppLayout :locale="locale">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <Card class="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <CardHeader class="pb-2">
                        <CardTitle class="text-sm font-medium text-muted-foreground">Commandes totales</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-3xl font-bold">{{ totalOrders }}</p>
                    </CardContent>
                </Card>
                <Card class="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <CardHeader class="pb-2">
                        <CardTitle class="text-sm font-medium text-muted-foreground">Clients</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-3xl font-bold">{{ totalCustomers }}</p>
                    </CardContent>
                </Card>
                <Card class="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <CardHeader class="pb-2">
                        <CardTitle class="text-sm font-medium text-muted-foreground">Revenus HT</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-3xl font-bold">
                            {{ totalRevenue.toLocaleString('fr-FR', { style: 'currency', currency: 'EUR' }) }}
                        </p>
                    </CardContent>
                </Card>
            </div>

            <div
                class="relative flex min-h-[500px] flex-1 flex-col items-center justify-center gap-10 rounded-xl border border-sidebar-border/70 p-8 dark:border-sidebar-border md:flex-row md:items-center"
            >
                <div class="flex flex-col items-center gap-2">
                    <h2 class="text-lg font-semibold">Répartition des commandes</h2>
                    <SalesDoughnutChart v-if="ordersByStatus.length > 0" :stats="ordersByStatus" />
                    <p v-else class="text-sm text-muted-foreground">Aucune commande enregistrée.</p>
                </div>

                <div v-if="ordersByStatus.length > 0" class="flex flex-col gap-3">
                    <p class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Légende</p>
                    <div v-for="(stat, index) in ordersByStatus" :key="stat.label" class="flex items-center gap-3">
                        <span class="h-3 w-3 shrink-0 rounded-full" :style="{ backgroundColor: COLORS[index % COLORS.length] }" />
                        <span class="text-sm">{{ stat.label }}</span>
                        <span class="ml-6 text-sm font-semibold">{{ stat.count }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
