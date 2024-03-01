<script setup>
import Slider from '@vueform/slider'
import {computed, inject, ref, watch} from "vue";

const props = defineProps({
    data: {
        type: Object
    }
});

const underlayClass = computed(() => {
    return [
        'fixed inset-0 w-full h-full z-50 overflow-hidden'
    ];
});

const modalClass = computed(() => {
    return [
        "w-full md:w-3/4 lg:w-[700px] p-10",
        "flex flex-col",
        "bg-white",
        "absolute top-0 left-full h-screen transition-all duration-500"
    ];
});

const modalOptions = inject('modal_options');
const modalPosition = ref('translate-x-0');

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
        <div :class="[ underlayClass, '' ]" v-show="modalOptions.open">
            <div class="absolute inset-0 w-screen h-screen bg-black/80" @click="modalOptions.open = !modalOptions.open"></div>
            <div :class="[
                modalClass,
                modalPosition
                ]">
                <div class="relative cursor-pointer group text-right" @click="modalOptions.open = !modalOptions.open">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="inline-block fill-gray-300 group-hover:fill-gray-900" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </div>
                <h3 :class="[ 'text-center']"></h3>
                <div :class="[  ]">
                    <span>Velikost obrázků</span>
                    <Slider
                        v-model="modalOptions.galleryImageSize"
                        :min="1"
                        :max="8"
                        :tooltips="false"
                        :lazy="false"
                    />
                </div>
            </div>
        </div>
    </Transition>
</template>

<style lang="scss">
@import '@vueform/slider/themes/tailwind.scss';
</style>
