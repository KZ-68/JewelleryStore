<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'
import { Primitive, type PrimitiveProps } from 'reka-ui'
import { type ButtonVariants, buttonVariants } from '.'
import axios from 'axios';
import { route } from '../../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '@/ziggy';

interface Props extends PrimitiveProps {
  variant?: ButtonVariants['variant']
  size?: ButtonVariants['size']
  class?: HTMLAttributes['class']
}

const props = withDefaults(defineProps<Props>(), {
  as: 'button',
})

function submit(guard: string) {
    if (guard === 'web') {
      axios.post('/logout')
        .then((res) => {
        console.log(res.data)
      })
    } else {
      axios.post(route('admin-logout', {}, false, Ziggy))
        .then((res) => {
        console.log(res.data)
      })
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