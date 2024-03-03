<script setup>
import Slider from '@vueform/slider'
import {computed, inject, onBeforeUnmount, onMounted, ref, watch} from "vue";
import {usePage} from "@inertiajs/vue3";
import {Link} from '@inertiajs/vue3';

const page = usePage()
const pagesList = page.props.pages[0]

const props = defineProps({
    data: {
        type: Object
    }
});

const modalOptions = inject('modal_options');
const modalPosition = ref('translate-x-0');
const screenWidth = ref(1920);

const handleResize = () => {
    screenWidth.value = window.innerWidth;
    if(screenWidth.value > 2000) {
        modalOptions.value.galleryMaxColumns = 7;
    } else if(screenWidth.value > 1500) {
        modalOptions.value.galleryMaxColumns = 5;
    } else if(screenWidth.value > 992) {
        modalOptions.value.galleryMaxColumns = 3;
    } else {
        modalOptions.value.galleryMaxColumns = 2;
    }

    if(screenWidth.value > 1500) {
        modalOptions.value.galleryMinColumns = 3;
    } else if(screenWidth.value > 992) {
        modalOptions.value.galleryMinColumns = 2;
    } else {
        modalOptions.value.galleryMinColumns = 1;
    }

    if(modalOptions.value.galleryImageSize > modalOptions.value.galleryMaxColumns) modalOptions.value.galleryImageSize = modalOptions.value.galleryMaxColumns;
    if(modalOptions.value.galleryImageSize < modalOptions.value.galleryMinColumns) modalOptions.value.galleryImageSize = modalOptions.value.galleryMinColumns;
};

onMounted(() => {
    handleResize();
    window.addEventListener('resize', handleResize);
});

onBeforeUnmount(() => {
    handleResize();
    window.removeEventListener('resize', handleResize);
});

watch(modalOptions, (newValue) => {
    if (newValue.open === true) {
        setTimeout(() => {
            modalPosition.value = '-translate-x-full';
        }, 200);
    } else {
        modalPosition.value = 'translate-x-0';
    }
}, { deep: true });
</script>
<template>
    <Transition
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        enter-active-class="transition duration-700"
        leave-active-class="transition duration-500"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div class="fixed inset-0 w-full h-full z-50 overflow-hidden" v-show="modalOptions.open">
            <div class="absolute inset-0 w-screen h-screen bg-black/80 dark:bg-gray-900/95" @click="modalOptions.open = !modalOptions.open"></div>
            <div :class="['w-full md:w-3/4 lg:w-[700px] p-10 flex flex-col bg-white dark:bg-gray-800 absolute top-0 left-full h-screen transition-all duration-500', modalPosition]">
                <div class="relative cursor-pointer group text-right" @click="modalOptions.open = !modalOptions.open">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="inline-block transition-all duration-300 fill-gray-300 dark:fill-gray-500 dark:group-hover:fill-gray-300 group-hover:fill-gray-900" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-400 dark:text-gray-500 uppercase my-6">Navigace</h3>
                    <ul class="flex flex-col gap-3 pl-6">
                        <Link
                            :href="route('homepage.gallery')"
                            :class="['text-4xl font-bold transition-all hover:text-black dark:hover:text-gray-300 duration-300',
                                     route().current('homepage.gallery') ? 'dot-before text-black dark:text-gray-300' : 'text-gray-400 dark:text-gray-500']"
                        >Home</Link>
                        <li v-for="item in pagesList">
                            <Link
                                :href="route('page.view', { page: item.slug })"
                                :class="['text-4xl font-bold transition-all hover:text-black dark:hover:text-gray-300 duration-300',
                                     route().current('page.view', { page: item.slug }) ? 'dot-before text-black dark:text-gray-300' : 'text-gray-400 dark:text-gray-500']"
                            >{{ item.name }}</Link>
                        </li>
                    </ul>
                    <template v-if="route().current('homepage.gallery')">
                        <h3 class="text-gray-400 dark:text-gray-500 uppercase mt-12 mb-6">Nastavení galerie</h3>
                        <span class="text-gray-400 dark:text-gray-500 font-bold text-xl pl-6">Počet sloupců v layoutu</span>
                        <div class="flex items-center gap-5 mt-3 pl-6">
                            <div>
                                <span class="flex items-center justify-center font-bold text-xl bg-gray-400 dark:bg-gray-900 dark:text-gray-300 text-white rounded-full w-10 h-10">{{ modalOptions.galleryImageSize }}</span>
                            </div>
                            <div class="w-full">
                            <Slider
                                v-model="modalOptions.galleryImageSize"
                                :min="modalOptions.galleryMinColumns"
                                :max="modalOptions.galleryMaxColumns"
                                :tooltips="false"
                                :lazy="true"
                                :classes="{
                                    target: 'slider-target',
                                    handle: 'absolute w-5 h-5 cursor-grab bg-gray-500 dark:bg-gray-900 -top-2 -right-2 rounded-full',
                                    active: 'slider-active shadow-slider-active cursor-grabbing',
                                    connect: 'slider-connect !bg-black dark:!bg-gray-900'}"
                            />
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style lang="scss">
@import '@vueform/slider/themes/tailwind.scss';
</style>
