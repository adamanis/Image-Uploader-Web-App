<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import BreezeButton from "@/Components/Button.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { useToast } from "vue-toastification";

defineProps({
    status: String,
});

const form = useForm({
    image_uri: "",
});

const toast = useToast();

const submit = () => {
    testImage(form.image_uri).then(
        function fulfilled(img) {
            form.post(route("APP.newimage.store"), {
                onSuccess: () => form.reset("image_uri"),
                onFinish: () => {
                    form.reset("image_uri");
                    toast.info("Adding image to server", {
                        timeout: 8000,
                    });
                },
            });
        },

        function rejected() {
            toast.error("Invalid image to upload", {
                timeout: 8000,
            });
        }
    );
};

const testImage = (url) => {
    const imgPromise = new Promise(function imgPromise(resolve, reject) {
        // Create the image
        const imgElement = new Image();

        // When image is loaded, resolve the promise
        imgElement.addEventListener("load", function imgOnLoad() {
            resolve(this);
        });

        // When there's an error during load, reject the promise
        imgElement.addEventListener("error", function imgOnError() {
            reject();
        });

        // Assign URL
        imgElement.src = url;
    });

    return imgPromise;
};

let testBool = true;
</script>

<template>
    <Head title="Add Image" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Image
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <BreezeValidationErrors class="mb-4" />
                        <div
                            v-if="status"
                            class="mb-4 font-medium text-sm text-green-600"
                        >
                            {{ status }}
                        </div>
                        <form @submit.prevent="submit">
                            <div>
                                <BreezeLabel
                                    for="image_uri"
                                    value="Image URI"
                                />
                                <BreezeInput
                                    id="image_uri"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.image_uri"
                                    required
                                    autofocus
                                    autocomplete="image uri"
                                    placeholder="Please input the image uri"
                                />
                            </div>
                            <div class="pt-4" v-if="testBool">
                                <img
                                    :src="form.image_uri"
                                    alt="Invalid image"
                                />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <BreezeButton
                                    class="ml-4"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Save
                                </BreezeButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
