import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const fetchJson = async <T>(url: string): Promise<T> => {
    const response = await fetch(url, {
        headers: { Accept: 'application/json' },
    });

    if (!response.ok) {
        throw new Error(`Failed to fetch: ${response.status}`);
    }

    return response.json();
};

// Module-level reactive state shared between components on the same admin 2FA page
const errors = ref<string[]>([]);
const manualSetupKey = ref<string | null>(null);
const qrCodeSvg = ref<string | null>(null);
const recoveryCodesList = ref<string[]>([]);

const hasSetupData = computed<boolean>(
    () => qrCodeSvg.value !== null && manualSetupKey.value !== null,
);

const locale = (): string => (usePage().props as Record<string, unknown>).locale as string ?? 'fr';

export const useAdminTwoFactorAuth = () => {
    const fetchQrCode = async (): Promise<void> => {
        try {
            const { svg } = await fetchJson<{ svg: string; url: string }>(
                `/${locale()}/admin/back-office/two-factor/qr-code`,
            );
            qrCodeSvg.value = svg;
        } catch {
            errors.value.push('Failed to fetch QR code');
            qrCodeSvg.value = null;
        }
    };

    const fetchSetupKey = async (): Promise<void> => {
        try {
            const { secretKey: key } = await fetchJson<{ secretKey: string }>(
                `/${locale()}/admin/back-office/two-factor/secret-key`,
            );
            manualSetupKey.value = key;
        } catch {
            errors.value.push('Failed to fetch a setup key');
            manualSetupKey.value = null;
        }
    };

    const clearSetupData = (): void => {
        manualSetupKey.value = null;
        qrCodeSvg.value = null;
        clearErrors();
    };

    const clearErrors = (): void => {
        errors.value = [];
    };

    const clearAdminTwoFactorData = (): void => {
        clearSetupData();
        clearErrors();
        recoveryCodesList.value = [];
    };

    const fetchRecoveryCodes = async (): Promise<void> => {
        try {
            clearErrors();
            recoveryCodesList.value = await fetchJson<string[]>(
                `/${locale()}/admin/back-office/two-factor/recovery-codes`,
            );
        } catch {
            errors.value.push('Failed to fetch recovery codes');
            recoveryCodesList.value = [];
        }
    };

    const fetchSetupData = async (): Promise<void> => {
        try {
            clearErrors();
            await Promise.all([fetchQrCode(), fetchSetupKey()]);
        } catch {
            qrCodeSvg.value = null;
            manualSetupKey.value = null;
        }
    };

    return {
        qrCodeSvg,
        manualSetupKey,
        recoveryCodesList,
        errors,
        hasSetupData,
        clearSetupData,
        clearErrors,
        clearAdminTwoFactorData,
        fetchQrCode,
        fetchSetupKey,
        fetchSetupData,
        fetchRecoveryCodes,
    };
};
