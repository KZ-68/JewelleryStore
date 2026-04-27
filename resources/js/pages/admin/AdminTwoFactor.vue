<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import AdminTwoFactorRecoveryCodes from '@/components/AdminTwoFactorRecoveryCodes.vue';
import AdminTwoFactorSetupModal from '@/components/AdminTwoFactorSetupModal.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { useAdminTwoFactorAuth } from '@/composables/useAdminTwoFactorAuth';
import AppLayout from '@/layouts/AppLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { ShieldBan, ShieldCheck } from 'lucide-vue-next';
import { computed, onUnmounted, ref } from 'vue';

interface Props {
    requiresConfirmation?: boolean;
    twoFactorEnabled?: boolean;
    locale: string;
}

const props = withDefaults(defineProps<Props>(), {
    requiresConfirmation: false,
    twoFactorEnabled: false,
});

const { hasSetupData, clearAdminTwoFactorData } = useAdminTwoFactorAuth();
const showSetupModal = ref<boolean>(false);

const enableForm = computed(() => ({
    action: `/${props.locale}/admin/back-office/two-factor/enable`,
    method: 'post' as const,
}));

const disableForm = computed(() => ({
    action: `/${props.locale}/admin/back-office/two-factor/disable`,
    method: 'post' as const,
}));

onUnmounted(() => {
    clearAdminTwoFactorData();
});
</script>

<template>
    <Head title="Two-Factor Authentication" />
    <AppLayout :locale="locale">
        <div class="px-4 py-24 max-w-2xl mx-auto space-y-6">
            <HeadingSmall
                title="Two-Factor Authentication"
                description="Manage your two-factor authentication settings"
            />

            <div
                v-if="!twoFactorEnabled"
                class="flex flex-col items-start justify-start space-y-4"
            >
                <Badge variant="destructive">Disabled</Badge>

                <p class="text-muted-foreground">
                    When you enable two-factor authentication, you will be
                    prompted for a secure pin during login. This pin can be
                    retrieved from a TOTP-supported application (e.g. Google
                    Authenticator) on your phone.
                </p>

                <div>
                    <Button
                        v-if="hasSetupData"
                        @click="showSetupModal = true"
                    >
                        <ShieldCheck />Continue Setup
                    </Button>
                    <Form
                        v-else
                        v-bind="enableForm"
                        @success="showSetupModal = true"
                        #default="{ processing }"
                    >
                        <Button type="submit" :disabled="processing">
                            <ShieldCheck />Enable 2FA
                        </Button>
                    </Form>
                </div>
            </div>

            <div
                v-else
                class="flex flex-col items-start justify-start space-y-4"
            >
                <Badge variant="default">Enabled</Badge>

                <p class="text-muted-foreground">
                    With two-factor authentication enabled, you will be
                    prompted for a secure, random pin during login, which
                    you can retrieve from the TOTP-supported application on
                    your phone.
                </p>

                <AdminTwoFactorRecoveryCodes :locale="locale" />

                <div class="relative inline">
                    <Form v-bind="disableForm" #default="{ processing }">
                        <Button
                            variant="destructive"
                            type="submit"
                            :disabled="processing"
                        >
                            <ShieldBan />
                            Disable 2FA
                        </Button>
                    </Form>
                </div>
            </div>

            <AdminTwoFactorSetupModal
                v-model:isOpen="showSetupModal"
                :requiresConfirmation="requiresConfirmation"
                :twoFactorEnabled="twoFactorEnabled"
                :locale="locale"
            />
        </div>
    </AppLayout>
</template>
