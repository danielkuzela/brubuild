<script setup>
import {generateSrcset} from "@/Composables/imageProcessor.js";

const props = defineProps(['data']);
</script>

<template>
    <div class="container mx-auto py-20">
        <template v-for="item in data.images">
            <div class="flex justify-center items-center relative z-[1] mb-5">
                <div class="w-full">
                    <img
                        :src="'/storage/' + item.id + '/' + item.file_name"
                        :srcset="generateSrcset(item.responsive_images.media_library_original.urls, 1920, '/storage/' + item.id + '/responsive-images/')"
                        sizes="900px"
                        loading="lazy"
                        class="w-full dark:brightness-75"
                    />
                </div>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    searchable_name: "image"
}
</script>
