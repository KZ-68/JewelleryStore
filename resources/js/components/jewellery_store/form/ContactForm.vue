<script setup lang="ts">
import ContactController from '@/actions/App/Http/Controllers/Web/ContactController';
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { privacy }  from '@/routes/index'
import { Form, Link } from '@inertiajs/vue3';
import 'swiper/css';

interface ContactFormProps {
    classname:string;
}
    
defineProps<ContactFormProps>();
</script>

<template>
    <section id="contact-form-wrapper" class="my-10 mx-15 max-w-[900px] flex-start py-6 px-8 gap-1 rounded-lg bg-white p-1 dark:bg-neutral-800">
        <Form
            v-bind="ContactController.store.form()"
            :reset-on-success="['contact']"
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
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="subject">Subject</Label>
                    <Input
                        id="subject"
                        type="text"
                        name="subject"
                        required
                        autofocus
                        :tabindex="2"
                        placeholder="Type your subject here"
                        class="bg-gray-100 p-1"
                    />
                    <InputError :message="errors.subject" />
                </div>

                <div class="grid gap-2">
                    <Label for="text">Message</Label>
                    <textarea
                        id="contact-message"
                        name="message"
                        required
                        rows="5" 
                        cols="100"
                        min="3"
                        max="500"
                        autofocus
                        :tabindex="3"
                        placeholder="Type your message here"
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.subject" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="agreed" class="flex items-center space-x-3">
                        <Checkbox id="agreed" name="agreed" :tabindex="4" />
                        <span>
                            By submitting this form, I declare that I have read the privacy policy and authorize the Controller to respond to me as expressed in point a and b of the
                            <Link
                                :href="privacy()"
                                class="inline-block "
                            >
                                Privacy Policy
                            </Link>
                        </span>

                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-20 bg-black text-white"
                    :tabindex="5"
                    :disabled="processing"
                    data-test="login-button"
                >
                    <LoaderCircle
                        v-if="processing"
                        class="h-4 w-4 animate-spin"
                    />
                    Send
                </Button>
            </div>
        </Form>
    </section>
</template>