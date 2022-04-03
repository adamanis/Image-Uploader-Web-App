<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    images: Object,
});
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1>
                            You're logged in! <br />Here are the images you have
                            uploaded
                        </h1>
                        <div
                            class="mt-12 flex flex-col justify-center items-center"
                        >
                            <div
                                class=""
                                v-for="image in images.data"
                                :key="image.id"
                            >
                                <img
                                    :src="image.image_file"
                                    :alt="image.filename"
                                />
                                <div class="text-center">
                                    {{ image.created_at_display }}
                                </div>
                            </div>
                        </div>
                        <Pagination class="mt-6" :links="images.links" />
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
