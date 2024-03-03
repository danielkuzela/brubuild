<script setup>
import MasonryWall from '@yeger/vue-masonry-wall'
import ImageLoader from "@/Components/ImageLoader.vue";
import {inject} from "vue";

const props = defineProps({
    media: {
        type: Object,
        default: {}
    }
})
const modalOptions = inject('modal_options');
</script>
<template>
    <div class="p-2 text-white">
        <masonry-wall
            :items="media"
            :ssr-columns="1"
            :min-columns="modalOptions.galleryMinColumns"
            :max-columns="modalOptions.galleryImageSize"
            :column-width="200"
            :gap="8">
            <template #default="{ item, index }">
                <ImageLoader :data="item" zoomable />
            </template>
        </masonry-wall>
    </div>
</template>
