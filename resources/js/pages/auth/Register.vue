<script setup lang="ts">
import RegisteredCustomerController from '@/actions/App/Http/Controllers/Auth/RegisteredCustomerController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import { Ziggy } from '@/ziggy';
import PasswordRequirements from '@/components/PasswordRequirements.vue';

interface RegisterProps {
    locale: string
}

const props = defineProps<RegisterProps>();
const passwordValue = ref('')
</script>

<template>
    <Head title="Register">
        <meta name="description" content="Créez votre compte JewelleryStore gratuitement pour passer commande, suivre vos livraisons et gérer vos bijoux préférés." head-key="description" />
    </Head>
    <main class="flex flex-row bg-gray-100 rounded-xl border-t-[1px] border-gray-100 min-h-svh dark:bg-gray-950 dark:border-gray-900">
        <section id="register-section" class="lg:ml-10 lg:my-10 lg:px-10 lg:py-10 rounded-l-xl lg:w-50/50 bg-white dark:bg-gray-900">
            <h1 class="text-3xl mb-6 dark:text-gray-100">Create an account</h1>

            <Form
                v-bind="RegisteredCustomerController.store.form({locale: locale})"
                :reset-on-success="['password', 'password_confirmation']"
                v-slot="{ errors, processing }"
                class="flex flex-col gap-6"
            >
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            type="text"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="name"
                            name="name"
                            placeholder="Full name"
                        />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">Email address</Label>
                        <Input
                            id="email"
                            type="email"
                            required
                            :tabindex="2"
                            autocomplete="email"
                            name="email"
                            placeholder="email@example.com"
                        />
                        <InputError :message="errors.email" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password">Password</Label>
                        <Input
                            id="password"
                            type="password"
                            required
                            :tabindex="3"
                            autocomplete="new-password"
                            name="password"
                            placeholder="Password"
                            @input="(e: Event) => passwordValue = (e.target as HTMLInputElement).value"
                        />
                        <PasswordRequirements :password="passwordValue" />
                        <InputError :message="errors.password" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password_confirmation">Confirm password</Label>
                        <Input
                            id="password_confirmation"
                            type="password"
                            required
                            :tabindex="4"
                            autocomplete="new-password"
                            name="password_confirmation"
                            placeholder="Confirm password"
                        />
                        <InputError :message="errors.password_confirmation" />
                    </div>

                    <Button
                        type="submit"
                        class="mt-2 w-full"
                        tabindex="5"
                        :disabled="processing"
                        data-test="register-user-button"
                    >
                        <LoaderCircle
                            v-if="processing"
                            class="h-4 w-4 animate-spin"
                        />
                        Create account
                    </Button>
                </div>

                <div class="text-center text-sm text-muted-foreground">
                    Already have an account?
                    <TextLink
                        :href="route('login', {locale: props.locale}, false, Ziggy)"
                        class="underline underline-offset-4"
                        :tabindex="6"
                        >Log in</TextLink
                    >
                </div>
            </Form>
        </section>
        <aside id="register-form-background" class="lg:mr-10 lg:my-10 lg:w-50/50">
            <figure id="register-form-figure" class="h-full">
                <img src="/storage/img/forms/elegant-tea-party-assortment_original.jpg" alt="Japanese Jewellery Stock Image" class="rounded-r-xl h-full w-full object-cover">
            </figure>
        </aside>
    </main>
</template>
