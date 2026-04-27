<script setup lang="ts">
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { ChevronDown } from 'lucide-vue-next'

interface LocaleConfig {
    label: string
    shortLabel: string
    flag: string
}

const LOCALES: Record<string, LocaleConfig> = {
    en: { label: 'English',  shortLabel: 'EN', flag: '🇬🇧' },
    fr: { label: 'Français', shortLabel: 'FR', flag: '🇫🇷' },
}

const props = defineProps<{ locale: string }>()

const page    = usePage()
const isOpen  = ref(false)

const current      = LOCALES[props.locale] ?? { label: props.locale.toUpperCase(), shortLabel: props.locale.toUpperCase(), flag: '' }
const otherLocales = Object.entries(LOCALES).filter(([key]) => key !== props.locale)

/** Replace the locale prefix in the current Inertia URL. */
const switchedUrl = (targetLocale: string): string =>
    page.url.replace(/^\/[a-z]{2}(\/|$)/, `/${targetLocale}$1`)

const toggle = () => { isOpen.value = !isOpen.value }
const close  = () => { isOpen.value = false }

/** Close when focus leaves the component entirely. */
const onFocusOut = (e: FocusEvent) => {
    const wrapper = e.currentTarget as HTMLElement
    if (!wrapper.contains(e.relatedTarget as Node | null)) {
        close()
    }
}
</script>

<template>
    <div
        class="relative"
        @keydown.escape="close"
        @focusout="onFocusOut"
    >
        <!-- Trigger -->
        <button
            type="button"
            :aria-expanded="isOpen.toString()"
            aria-haspopup="listbox"
            :aria-label="`Langue sélectionnée : ${current.label}. Changer de langue.`"
            @click="toggle"
            class="flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#84070F] transition-colors select-none"
            :class="{ 'bg-gray-100': isOpen }"
        >
            <span aria-hidden="true" class="text-base leading-none">{{ current.flag }}</span>
            <span class="hidden sm:inline">{{ current.shortLabel }}</span>
            <ChevronDown
                aria-hidden="true"
                class="w-3.5 h-3.5 text-gray-400 transition-transform duration-150"
                :class="{ 'rotate-180': isOpen }"
            />
        </button>

        <!-- Dropdown -->
        <Transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <ul
                v-if="isOpen"
                role="listbox"
                :aria-label="`Langues disponibles`"
                :aria-activedescendant="`lang-opt-${locale}`"
                class="absolute right-0 mt-1 w-36 origin-top-right rounded-xl bg-white shadow-lg ring-1 ring-black/5 focus:outline-none z-50 overflow-hidden py-1"
            >
                <!-- Current locale (non-interactive, shown for context) -->
                <li
                    :id="`lang-opt-${locale}`"
                    role="option"
                    aria-selected="true"
                    aria-disabled="true"
                    class="flex items-center gap-2.5 px-3 py-2 text-sm font-medium text-[#84070F] bg-red-50 cursor-default select-none"
                >
                    <span aria-hidden="true" class="text-base leading-none">{{ current.flag }}</span>
                    {{ current.label }}
                    <svg aria-hidden="true" class="ml-auto w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd"/>
                    </svg>
                </li>

                <!-- Switchable locales -->
                <li
                    v-for="[key, config] in otherLocales"
                    :key="key"
                    role="option"
                    aria-selected="false"
                >
                    <a
                        :href="switchedUrl(key)"
                        :lang="key"
                        :hreflang="key"
                        class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#84070F] transition-colors focus:outline-none focus:bg-gray-50 focus:text-[#84070F]"
                        @click="close"
                    >
                        <span aria-hidden="true" class="text-base leading-none">{{ config.flag }}</span>
                        {{ config.label }}
                    </a>
                </li>
            </ul>
        </Transition>
    </div>
</template>
