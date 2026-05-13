<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'
import { Primitive, type PrimitiveProps } from 'reka-ui'
import { type ButtonVariants, buttonVariants } from '.'
import { router } from '@inertiajs/vue3';
import { route } from '../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '@/ziggy';

interface Props extends PrimitiveProps {
  variant?: ButtonVariants['variant']
  size?: ButtonVariants['size']
  class?: HTMLAttributes['class']
  locale: string
}

const props = withDefaults(defineProps<Props>(), {
  as: 'button',
})

function submit(guard: string) {
    if (guard === 'web') {
        router.post(route('customer-logout', {locale: props.locale}, false, Ziggy))
    } else {
        router.post(route('admin-logout', {locale: props.locale}, false, Ziggy))
    }
}
</script>

<template>
  <Primitive
    data-slot="button"
    :as="as"
    :as-child="asChild"
    :class="cn(buttonVariants({ variant, size }), props.class)"
    @click="$page.props.auth.user ? submit('admin') : submit('web')"
  >
    <slot />
  </Primitive>
</template>