<script setup lang="ts">
import CustomerFrontController from '@/actions/App/Http/Controllers/Admin/CustomerFrontController';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form } from '@inertiajs/vue3';
import type { Customer } from '@/types/customer'
import type { Group } from '@/types/group'

interface AdminCustomerCreateFormProps {
    classname:string
    customer:Customer
    groups:Group[]
}   

const props = defineProps<AdminCustomerCreateFormProps>();

const checkedGroups = []
</script>

<template>
    <section id="new-admin-customer-form-wrapper" class="my-2 mx-4 max-w-[900px] flex-start p-8 gap-1 rounded-lg bg-white dark:bg-neutral-800">
        <Form
            v-bind="CustomerFrontController.create.form()"
            :options="{
                preserveScroll: true,
            }"
            reset-on-success
            :reset-on-error="[
                'name',
                'email',
                'password',
                'password_confirmation',
                'current_password',
            ]"
            class="space-y-6"
            v-slot="{ errors, processing, recentlySuccessful }"
        >
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input
                    id="name"
                    name="name"
                    type="text"
                    autocomplete="name"
                    class="mt-1 block w-full"
                    placeholder="Add name"
                />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="email">Email</Label>
                <Input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    class="mt-1 block w-full"
                    placeholder="Add email"
                />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="current_password">Current password</Label>
                <Input
                    id="current_password"
                    name="current_password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="Current password"
                />
                <InputError :message="errors.current_password" />
            </div>

            <div class="grid gap-2">
                <Label for="password">New password</Label>
                <Input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="New password"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation"
                    >Confirm password</Label
                >
                <Input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="Confirm password"
                />
                <InputError :message="errors.password_confirmation" />
            </div>

            <div class="grid gap-2">
                <Label for="group">Customer Groups</Label>
                <ul>
                    <li :v-for="group in props.groups">
                        <Input 
                            id="group"
                            name="group"
                            type="checkbox"
                            class="mt-1 block w-full"
                            @check="checkedGroups.push(group)"
                        />
                    </li>
                </ul>
                <InputError :message="errors.group" />
            </div>
            <input id="checked_groups" name="checked_groups" type="hidden" :value=JSON.stringify(checkedGroups)>


            <div class="flex items-center gap-4">
                <Button
                    :disabled="processing"
                    data-test="create-customer-button"
                    >Save</Button
                >

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-show="recentlySuccessful"
                        class="text-sm text-neutral-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </Form>
    </section>
</template>