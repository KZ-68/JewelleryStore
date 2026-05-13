<script setup lang="ts">
import { ArcElement, Chart as ChartJS, Legend } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { computed } from 'vue';
import { Doughnut } from 'vue-chartjs';

ChartJS.register(ArcElement, Legend, ChartDataLabels);

interface OrderStat {
    label: string;
    count: number;
}

const COLORS = ['#d0bcd4', '#30c4e4', '#c8ecac', '#f4a261', '#e76f51', '#a8dadc'];

const props = defineProps<{ stats: OrderStat[] }>();

const total = computed(() => props.stats.reduce((sum, s) => sum + s.count, 0));

const chartData = computed(() => ({
    labels: props.stats.map((s) => s.label),
    datasets: [
        {
            data: props.stats.map((s) => s.count),
            backgroundColor: props.stats.map((_, i) => COLORS[i % COLORS.length]),
            borderColor: props.stats.map((_, i) => COLORS[i % COLORS.length]),
            borderWidth: 1,
        },
    ],
}));

const chartOptions = computed(() => ({
    responsive: false,
    layout: {
        padding: { top: 50, left: 85, right: 85, bottom: 50 },
    },
    plugins: {
        legend: { display: false },
        datalabels: {
            color: props.stats.map((_, i) => COLORS[i % COLORS.length]),
            font: { weight: 'bold' as const, size: 16 },
            align: 'end' as const,
            anchor: 'end' as const,
            clip: false,
            formatter: (value: number, context: { dataIndex: number }): string[] => {
                const pct = total.value > 0 ? Math.round((value / total.value) * 100) : 0;
                return [`${pct}%`, props.stats[context.dataIndex].label];
            },
        },
    },
    cutout: '70%',
    width: 500,
    height: 500,
}));

</script>

<template>
    <Doughnut :width="500" :height="500" :data="chartData" :options="chartOptions" />
</template>
