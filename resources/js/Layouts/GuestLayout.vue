<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import {provide, ref} from "vue";
import MenuModal from "@/Components/MenuModal.vue";

const modalOptions = ref({
    open: false,
    galleryImageSize: 5
})
provide('modal_options', modalOptions);

</script>

<template>
    <div class="min-h-screen flex flex-col items-center pt-6 px-8 sm:pt-0 bg-gray-100">
        <div class="bg-gray-100 p-2 flex w-full justify-between items-center">
            <Link href="/">
                <ApplicationLogo class="w-16 h-16 fill-current text-gray-500" />
            </Link>
            <button @click="modalOptions.open = !modalOptions.open">MENU</button>
        </div>

        <div class="w-full">
            <slot />
        </div>

        <MenuModal />
    </div>
</template>
