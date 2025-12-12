<script setup lang="ts">
import AddressFrontController from '@/actions/App/Http/Controllers/Web/AddressFrontController';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Country } from '@/types/country';
import { Form } from '@inertiajs/vue3';
import { ref } from "vue";

interface AdminAddressCreateFormProps {
    classname:string;
    countries: Country[]
}   

const countrySelected = ref('')

const props = defineProps<AdminAddressCreateFormProps>();
</script>

<template>
    <section id="new-admin-address-form-wrapper" class="my-2 mx-4 max-w-[900px] flex-start p-8 gap-1 rounded-lg bg-white p-1 dark:bg-neutral-800">
        <Form
            v-bind="AddressFrontController.create.form()"
            :reset-on-success="['addresses.edit']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="address_line_1" class="text-md">Address Line 1</Label>
                    <textarea
                        id="address_line_1"
                        name="address_line_1"
                        rows="5" 
                        cols="100"
                        min="3"
                        max="500"
                        required
                        autofocus
                        :tabindex="2"
                        placeholder="..."
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.address_line_1" />
                </div>

                <div class="grid gap-2">
                    <Label for="address_line_2" class="text-md">Address Line 2</Label>
                    <textarea
                        id="address_line_2"
                        name="address_line_2"
                        rows="5" 
                        cols="100"
                        min="3"
                        max="500"
                        autofocus
                        :tabindex="2"
                        placeholder="..."
                        class="bg-gray-100 p-1 rounded-md"
                    />
                    <InputError :message="errors.address_line_2" />
                </div>

                <div class="grid gap-2">
                    <Label for="city" class="text-md">City</Label>
                    <Input
                        id="city"
                        type="text"
                        name="city"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="city"
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.city" />
                </div>
                
                <div class="grid gap-2">
                    <Label for="postal_code" class="text-md">Postal Code</Label>
                    <Input
                        id="postal_code"
                        type="text"
                        name="postal_code"
                        autofocus
                        :tabindex="1"
                        autocomplete="postal_code"
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.region" />
                </div>

                <div class="grid gap-2">
                    <Label for="country" class="text-md">Country</Label>
                    <select name="countries" v-model="countrySelected" class="border-2 rounded-md">
                        <option value="">--Please choose a country--</option>
                        <option v-for="country in countries" :value="country.local">{{ country.name }}</option>
                    </select>
                   <input id="country" name="country" type="hidden" :value=countrySelected>
                </div>

                <div class="grid gap-2">
                    <Label for="region" class="text-md">State / Region</Label>
                    <Input
                        id="region"
                        type="text"
                        name="region"
                        autofocus
                        :tabindex="1"
                        autocomplete="region"
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.region" />
                </div>

                <div class="grid gap-2">
                    <Label for="district" class="text-md">District</Label>
                    <Input
                        id="district"
                        type="text"
                        name="district"
                        autofocus
                        :tabindex="1"
                        autocomplete="district"
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.district" />
                </div>

                <div class="grid gap-2">
                    <Label for="sub_district" class="text-md">Sub District</Label>
                    <Input
                        id="sub_district"
                        type="text"
                        name="sub_district"
                        autofocus
                        :tabindex="1"
                        autocomplete="sub_district"
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.sub_district" />
                </div>

                <div class="grid gap-2">
                    <Label for="locality" class="text-md">Locality</Label>
                    <Input
                        id="locality"
                        type="text"
                        name="locality"
                        autofocus
                        :tabindex="1"
                        autocomplete="locality"
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.locality" />
                </div>

                <div class="grid gap-2">
                    <Label for="sub_locality" class="text-md">Sub Locality</Label>
                    <Input
                        id="sub_locality"
                        type="text"
                        name="sub_locality"
                        autofocus
                        :tabindex="1"
                        autocomplete="sub_locality"
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.sub_locality" />
                </div>

                <section id="new-admin-address-footer" class="flex flex-row gap-4 py-8">
                    <Button
                    type="submit"
                    class="w-20 bg-black text-white"
                    :tabindex="5"
                    :disabled="processing"
                    >
                        <LoaderCircle
                            v-if="processing"
                            class="h-4 w-4 animate-spin"
                        />
                        Save
                    </Button>
                </section>
            </div>
        </Form>
    </section>
</template>