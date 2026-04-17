<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{ password: string }>()

const rules = computed(() => [
    {
        label: 'At least 12 characters',
        met: props.password.length >= 12,
    },
    {
        label: 'At least one uppercase letter (A–Z)',
        met: /[A-Z]/.test(props.password),
    },
    {
        label: 'At least one lowercase letter (a–z)',
        met: /[a-z]/.test(props.password),
    },
    {
        label: 'At least one number (0–9)',
        met: /[0-9]/.test(props.password),
    },
    {
        label: 'At least one special character (!@#$…)',
        met: /[^A-Za-z0-9]/.test(props.password),
    },
])
</script>

<template>
    <ul class="mt-2 space-y-1 text-xs" aria-label="Password requirements">
        <li
            v-for="rule in rules"
            :key="rule.label"
            class="flex items-center gap-1.5"
            :class="rule.met ? 'text-green-600' : 'text-muted-foreground'"
        >
            <svg
                aria-hidden="true"
                class="w-3.5 h-3.5 shrink-0"
                :class="rule.met ? 'text-green-600' : 'text-gray-300'"
                viewBox="0 0 20 20"
                fill="currentColor"
            >
                <path
                    v-if="rule.met"
                    fill-rule="evenodd"
                    d="M16.704 5.296a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-3-3a1 1 0 011.414-1.414L9 11.586l6.296-6.29a1 1 0 011.408.004z"
                    clip-rule="evenodd"
                />
                <circle v-else cx="10" cy="10" r="3" />
            </svg>
            {{ rule.label }}
        </li>
    </ul>
</template>
