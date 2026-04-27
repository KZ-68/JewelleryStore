<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { CheckCircle, XCircle, X } from 'lucide-vue-next';

interface FlashMessage {
    type: 'success' | 'error';
    message: string;
}

const notifications = ref<FlashMessage[]>([]);

function addNotification(type: 'success' | 'error', message: string) {
    const notification: FlashMessage = { type, message };
    notifications.value.push(notification);

    setTimeout(() => {
        removeNotification(notification);
    }, 4000);
}

function removeNotification(notification: FlashMessage) {
    const index = notifications.value.indexOf(notification);
    if (index !== -1) {
        notifications.value.splice(index, 1);
    }
}

function handleFlash(props: Record<string, unknown>) {
    const flash = props.flash as { success?: string; error?: string } | undefined;
    if (flash?.success) addNotification('success', flash.success);
    if (flash?.error) addNotification('error', flash.error);
}

const page = usePage();

let removeNavigateListener: (() => void) | null = null;

onMounted(() => {
    // Handle flash present on initial page load (e.g. after a server-side redirect)
    handleFlash(page.props);

    removeNavigateListener = router.on('navigate', (event) => {
        handleFlash(event.detail.page.props);
    });
});

onBeforeUnmount(() => {
    removeNavigateListener?.();
});
</script>

<template>
    <Teleport to="body">
        <div
            class="fixed top-4 left-4 z-50 w-80"
            aria-live="polite"
            aria-atomic="false"
        >
            <TransitionGroup
                tag="div"
                class="flex flex-col gap-2"
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0 -translate-x-4"
                enter-to-class="opacity-100 translate-x-0"
                leave-active-class="transition-all duration-200 ease-in"
                leave-from-class="opacity-100 translate-x-0"
                leave-to-class="opacity-0 -translate-x-4"
            >
                <div
                    v-for="(notification, index) in notifications"
                    :key="index"
                    :class="[
                        'flex items-start gap-3 rounded-lg border px-4 py-3 shadow-lg text-sm',
                        notification.type === 'success'
                            ? 'bg-green-50 border-green-200 text-green-800 dark:bg-green-950 dark:border-green-800 dark:text-green-200'
                            : 'bg-red-50 border-red-200 text-red-800 dark:bg-red-950 dark:border-red-800 dark:text-red-200',
                    ]"
                    role="alert"
                >
                    <CheckCircle
                        v-if="notification.type === 'success'"
                        class="h-4 w-4 mt-0.5 shrink-0 text-green-500 dark:text-green-400"
                    />
                    <XCircle
                        v-else
                        class="h-4 w-4 mt-0.5 shrink-0 text-red-500 dark:text-red-400"
                    />

                    <span class="flex-1 leading-snug">{{ notification.message }}</span>

                    <button
                        type="button"
                        class="shrink-0 opacity-60 hover:opacity-100 transition-opacity"
                        :aria-label="'Close notification'"
                        @click="removeNotification(notification)"
                    >
                        <X class="h-4 w-4" />
                    </button>
                </div>
            </TransitionGroup>
        </div>
    </Teleport>
</template>
