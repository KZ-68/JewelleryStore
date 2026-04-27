<script setup lang="ts">
import SellerFrontController from '@/actions/App/Http/Controllers/Web/SellerFrontController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';
import PasswordRequirements from '@/components/PasswordRequirements.vue';

interface SellerRegisterForm {
    locale: string
}

const props = defineProps<SellerRegisterForm>();
const passwordValue = ref('')
</script>

<template>
    <Head title="Seller Account Registration" />
    <h1 class="text-3xl">Seller Account Registration</h1>

    <Form
        v-bind="SellerFrontController.store.form({locale: props.locale})"
        :reset-on-success="['password', 'password_confirmation']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-2"
    >
        <div class="grid gap-6">
            <section id="seller-credentials-section" class="flex flex-col gap-6 my-2">
                <h3 class="text-2xl my-4">Credentials</h3>
                <div class="grid gap-2">
                    <Label class="text-md" for="name">Seller Name</Label>
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
                    <Label class="text-md" for="email">Email address</Label>
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
                    <Label class="text-md" for="password">Password</Label>
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
                    <Label class="text-md" for="password_confirmation">Confirm password</Label>
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
            </section>

            <section id="seller-credentials-section" class="flex flex-col gap-6 my-2">
                <h3 class="text-2xl my-4">Tax Informations</h3>    
                <div class="grid gap-2">
                    <Label class="text-md" for="tax_country">Country Tax</Label>
                    <Input
                        id="tax_country"
                        type="text"
                        required
                        :tabindex="5"
                        autocomplete="tax_country"
                        name="tax_country"
                        placeholder="Country Tax..."
                    />
                    <InputError :message="errors.tax_country" />
                </div>

                <div class="grid gap-2">
                    <Label class="text-md" for="tax_type">Tax Type</Label>
                    <Input
                        id="tax_type"
                        type="text"
                        required
                        :tabindex="6"
                        autocomplete="tax_type"
                        name="tax_type"
                        placeholder="Tax Type..."
                    />
                    <InputError :message="errors.tax_type" />
                </div>

                <div class="grid gap-2">
                    <Label class="text-md" for="tax_number">Tax Number</Label>
                    <Input
                        id="tax_number"
                        type="text"
                        required
                        :tabindex="6"
                        autocomplete="tax_number"
                        name="tax_number"
                        placeholder="Tax Type..."
                    />
                    <InputError :message="errors.tax_number" />
                </div>

                <div class="grid gap-2">
                    <Label class="text-md" for="tax_scheme">Tax Scheme</Label>
                    <Input
                        id="tax_scheme"
                        type="text"
                        required
                        :tabindex="7"
                        autocomplete="tax_scheme"
                        name="tax_scheme"
                        placeholder="Enter a tax scheme..."
                    />
                    <InputError :message="errors.tax_scheme" />
                </div>

                <div class="grid gap-2">
                    <Label class="text-md" for="reduced_tax_rate">Reduced Tax Rate</Label>
                    <Input
                        id="reduced_tax_rate"
                        type="number" 
                        name="reduced_tax_rate"
                        step=".01"
                        required
                        :tabindex="5"
                        class="p-1 rounded-md"
                    />
                    <InputError :message="errors.reduced_tax_rate" />
                </div>

                <div class="grid gap-2">
                    <Label class="text-md" for="tax_registration_status">Tax Registration Status</Label>
                    <Input
                        id="tax_registration_status"
                        type="text"
                        required
                        :tabindex="7"
                        autocomplete="tax_registration_status"
                        name="tax_registration_status"
                        placeholder="Tax registration status..."
                    />
                    <InputError :message="errors.tax_registration_status" />
                </div>

                <div class="grid gap-2">
                    <Label class="text-md" for="invoice_tax_label">Invoice Tax Label</Label>
                    <Input
                        id="invoice_tax_label"
                        type="text"
                        :tabindex="7"
                        autocomplete="invoice_tax_label"
                        name="invoice_tax_label"
                        placeholder="Invoice tax label..."
                    />
                    <InputError :message="errors.invoice_tax_label" />
                </div>

                <div class="grid gap-2">
                    <Label class="text-md" for="qualified_invoice_number">Qualified Invoice Number</Label>
                    <Input
                        id="qualified_invoice_number"
                        type="text"
                        :tabindex="7"
                        autocomplete="qualified_invoice_number"
                        name="qualified_invoice_number"
                        placeholder="Invoice number..."
                    />
                    <InputError :message="errors.qualified_invoice_number" />
                </div>
            </section>

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
                Register seller account
            </Button>
        </div>
    </Form>
</template>