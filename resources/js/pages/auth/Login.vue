<script setup lang="ts">
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { register } from '@/routes';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    status?: string;
    canResetPassword: boolean;
    locale: string;
}>();
</script>

<template>
    <Head title="Log in">
        <meta name="description" content="Connectez-vous à votre compte JewelleryStore pour accéder à vos commandes, adresses et paramètres." head-key="description" />
    </Head>
    <main class="flex flex-row bg-gray-100 rounded-xl border-t-[1px] border-gray-100 min-h-svh dark:bg-gray-950 dark:border-gray-900">
        <aside id="login-form-background" class="lg:ml-10 lg:my-10 lg:w-50/50">
            <figure id="login-form-figure" class="h-full">
                <img src="/storage/img/forms/elegant-tea-party-assortment_original.jpg" alt="Japanese Jewellery Stock Image" class="rounded-l-xl h-full w-full object-cover">
            </figure>
        </aside>
        <section id="login-section" class="lg:mr-10 lg:my-10 lg:px-10 lg:py-10 rounded-r-xl lg:w-50/50 bg-white dark:bg-gray-900">
            <h1 class="text-3xl mb-6 dark:text-gray-100">Log in to your account</h1>

            <div
                v-if="status"
                class="mb-4 text-center text-sm font-medium text-green-600"
            >
                {{ status }}
            </div>

            <Form
                v-bind="AuthenticatedSessionController.store['/{locale?}/login'].form({locale:locale})"
                :reset-on-success="['password']"
                v-slot="{ errors, processing }"
                class="flex flex-col gap-6"
            >
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="email">Email address</Label>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="email"
                            placeholder="email@example.com"
                        />
                        <InputError :message="errors.email" />
                    </div>

                    <div class="grid gap-2">
                        <div class="flex items-center justify-between">
                            <Label for="password">Password</Label>
                            <TextLink
                                v-if="canResetPassword"
                                :href="request({locale:locale})"
                                class="text-sm"
                                :tabindex="5"
                            >
                                Forgot password?
                            </TextLink>
                        </div>
                        <Input
                            id="password"
                            type="password"
                            name="password"
                            required
                            :tabindex="2"
                            autocomplete="current-password"
                            placeholder="Password"
                        />
                        <InputError :message="errors.password" />
                    </div>

                    <div class="flex items-center justify-between">
                        <Label for="remember" class="flex items-center space-x-3">
                            <Checkbox id="remember" name="remember" :tabindex="3" />
                            <span>Remember me</span>
                        </Label>
                    </div>

                    <Button
                        type="submit"
                        class="mt-4 w-full"
                        :tabindex="4"
                        :disabled="processing"
                        data-test="login-button"
                    >
                        <LoaderCircle
                            v-if="processing"
                            class="h-4 w-4 animate-spin"
                        />
                        Log in
                    </Button>
                </div>

                <div class="text-center text-sm text-muted-foreground">
                    Don't have an account?
                    <TextLink :href="register({locale:locale})" :tabindex="5">Sign up</TextLink>
                </div>
            </Form>
        </section>
    </main>
</template>
