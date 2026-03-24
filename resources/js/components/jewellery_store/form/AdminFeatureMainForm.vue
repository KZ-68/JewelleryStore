<script setup lang="ts">
import FeatureFrontController from '@/actions/App/Http/Controllers/Admin/FeatureFrontController'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Form } from '@inertiajs/vue3'
import type { Feature } from '@/types/feature'
import FeatureValuesList from '../list/features/FeatureValuesList.vue'
import { FeatureValue } from '@/types/feature_value'

interface AdminFeatureMainFormProps {
    classname:string;
    feature: Feature;
    feature_values: FeatureValue[]
}   

const props = defineProps<AdminFeatureMainFormProps>();
</script>

<template>
    <section id="admin-feature-form-wrapper" class="my-2 mx-4 max-w-[900px] flex-start p-8 gap-1 rounded-lg bg-white dark:bg-neutral-800">
        <Form
            v-bind="FeatureFrontController.update.form({ slug: props.feature.slug })"
            :reset-on-success="['feature-details']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name" class="text-lg">Feature Name</Label>
                    <Input
                        id="name"
                        type="text"
                        name="name"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        :default-value=props.feature.name
                        class="p-1 file:text-2xl md:text-2xl text-2xl h-8"
                    />
                    <InputError :message="errors.name" />
                </div>

                <section id="admin-feature-details-footer" class="flex flex-row gap-4 py-8">
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

    <section id="feature-values-list" class="my-8">
        <FeatureValuesList :feature_values=props.feature_values></FeatureValuesList>
    </section>
</template>