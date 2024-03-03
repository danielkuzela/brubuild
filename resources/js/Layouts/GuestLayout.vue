<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import {provide, ref} from "vue";
import MenuModal from "@/Components/MenuModal.vue";

const modalOptions = ref({
    open: false,
    galleryImageSize: 5,
    galleryMaxColumns: 7,
    galleryMinColumns: 1
})
const currYear = new Date().getFullYear();

provide('modal_options', modalOptions);

</script>

<template>
    <div class="min-h-screen flex flex-col items-center pt-6 px-8 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="p-2 flex w-full justify-between items-center">
            <Link href="/">
                <ApplicationLogo class="w-16 h-16 fill-current" />
            </Link>
            <button @click="modalOptions.open = !modalOptions.open" class="text-gray-400 dark:text-gray-500 flex items-center gap-2 hover:text-black dark:hover:text-gray-300 transition-all duration-300">
                MENU
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                </svg>
            </button>
        </div>

        <div class="w-full">
            <slot />
        </div>

        <div class="w-full mt-10 mb-4 p-2 text-gray-500">
            &copy; BRUSTYLE 2023 - {{ currYear }}
        </div>
        <MenuModal />
    </div>
</template>
