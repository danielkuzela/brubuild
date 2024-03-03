<script setup>
import {inject, onBeforeUnmount, onMounted, ref} from "vue";
import {extractSizeFromFileName, generateSrcset} from "@/Composables/imageProcessor.js";
import {isDefined} from "@vueuse/core";

const props = defineProps({
    data: {
        type: Object
    },
    classes: {
        type: String,
        default: ''
    },
    rounded: {
        type: Boolean,
        default: false
    },
    zoomable: {
        type: Boolean,
        default: false
    },
    transparent: {
        type: Boolean,
        default: false
    },
    aos: {
        type: Boolean,
        default: false
    },
})

const modalOptions = inject('modal_options')

const zoomed = ref(false);
const size = extractSizeFromFileName(props.data.responsive_images.media_library_original.urls[0])
const aspect = (size.width / size.height).toFixed(2);

const cursorX = ref(0);
const cursorY = ref(0);
const cursor = ref(null);

onMounted(() => {
    onMouseMove();
    cursor.value = document.querySelector('.cursor');
    document.addEventListener('mousemove', onMouseMove);
});

const onMouseMove = (e) => {
    if(isDefined(e)) {
        cursorX.value = e.clientX - cursor.value.offsetWidth / 2;
        cursorY.value = e.clientY - cursor.value.offsetHeight / 2;
    }
};

onBeforeUnmount(() => {
    document.removeEventListener('mousemove', onMouseMove);
});
</script>

<template>
    <div>
        <div :class="[
            'aspect-[2/' + aspect + ']',
            'block relative overflow-hidden group',
            rounded ? 'rounded-xl' : ''
            ]"
             :data-aos="aos ? 'zoom-in-up' : ''">
            <div class="bg-gray-200 absolute w-full h-full animate-pulse" v-if="!transparent"></div>
            <div class="grid place-items-center h-full w-full absolute" v-if="!transparent">
                <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-50" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <div v-if="zoomable" class="absolute z-20 right-4 top-4" @click="zoomable ? zoomed = !zoomed : ''">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="fill-gray-200 max-w-0 transition-all	duration-200 group-hover:max-w-full" viewBox="0 0 16 16" @click="zoomable ? zoomed = !zoomed : ''">
                    <path fill-rule="evenodd" d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707zm4.344 0a.5.5 0 0 1 .707 0l4.096 4.096V11.5a.5.5 0 1 1 1 0v3.975a.5.5 0 0 1-.5.5H11.5a.5.5 0 0 1 0-1h2.768l-4.096-4.096a.5.5 0 0 1 0-.707zm0-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707zm-4.344 0a.5.5 0 0 1-.707 0L1.025 1.732V4.5a.5.5 0 0 1-1 0V.525a.5.5 0 0 1 .5-.5H4.5a.5.5 0 0 1 0 1H1.732l4.096 4.096a.5.5 0 0 1 0 .707z"/>
                </svg>
            </div>
            <img :src="'/storage/' + data.id + '/' + data.file_name"
                    :srcset="generateSrcset(data.responsive_images.media_library_original.urls, 1920, '/storage/' + data.id + '/responsive-images/')"
                    :sizes="'calc(100VW / ' + modalOptions.galleryImageSize + ')'"
                    :alt="data.model.name + (data.model.description ? ' / ' + data.model.description : '') + ' / Obrázek z galerie #' + data.id"
                    loading="lazy"
                    :width="size.width"
                    :height="size.height"
                    :class="[
                        classes,
                        'w-full z-10 relative dark:brightness-90',
                        rounded ? 'rounded-xl' : '',
                        zoomable ? 'cursor-pointer' : '']"
                    @click="zoomable ? zoomed = !zoomed : ''"
            />
        </div>
        <Transition
            enter-from-class="opacity-0 transition-all duration-500"
            enter-to-class="opacity-100 transition-all duration-500"
            leave-from-class="opacity-100 transition-all duration-500"
            leave-to-class="opacity-0 transition-all duration-500"
        >
            <div
                v-show="zoomable && zoomed"
                class="fixed overflow-y-scroll overflow-x-hidden w-full h-full inset-0 bg-white dark:bg-gray-900 flex justify-center items-center z-50"
                @click="zoomable ? zoomed = false : ''"
            >
                <div class="relative w-[95%] h-[95%] max-h-screen max-w-screen flex flex-col items-center">
                    <div class="grid place-items-center max-h-[90%] w-full absolute">
                        <svg class="animate-spin -ml-1 mr-3 h-12 w-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <img :src="'/storage/' + data.id + '/' + data.file_name"
                              loading="lazy"
                              sizes="100vw"
                              :class="[
                                  'sabsolute sleft-1/2 tsranslate-x-[-50%] z-20 max-h-[90%] w-auto dark:brightness-90',
                                  'aspect-[2/' + aspect + ']',
                                  rounded ? 'rounded-xl' : '']"
                              @click="zoomable ? zoomed = false : ''"
                    />
                    <div class="p-10 flex items-center flex-col max-w-screen-xl px-10 gap-5 text-black dark:text-gray-300">
                        <h2 class="font-semibold text-3xl">{{ data.model.name }}</h2>
                        <p class="text-center">{{ data.model.description }}</p>
                    </div>
                    <div class="absolute w-full h-full z-50 cursor-none	" @click="zoomable ? zoomed = false : ''">
                        <div
                            :class="['cursor w-10 h-10 transition-opacity bg-black dark:bg-gray-600 flex text-white dark:text-gray-300 items-center justify-center rounded-full absolute z-10']"
                            :style="{ left: `${cursorX}px`, top: `${cursorY}px` }">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>
        </Transition>
    </div>
</template>
