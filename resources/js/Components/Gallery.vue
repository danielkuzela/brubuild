<script setup>
import MasonryWall from '@yeger/vue-masonry-wall'
import ImageLoader from "@/Components/ImageLoader.vue";
import {inject} from "vue";

const items = [
    {
        url: 'https://source.unsplash.com/random',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/a',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/b',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/c',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/d',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/g',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/h',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/i',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/j',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/k',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/l',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/m',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/n',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/o',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/p',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/q',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/r',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/s',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/t',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/asd',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/bas',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/sda',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/bsd',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/wqwr',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/bda',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/ca',
        description: '1',
        image_resolution: '1833x1222'
    },
    {
        url: 'https://source.unsplash.com/random/po',
        description: '1',
        image_resolution: '1833x1222'
    },
]

const modalOptions = inject('modal_options');
</script>
<template>
    <div class="p-2">
        <masonry-wall
            :items="items"
            :ssr-columns="5"
            :min-columns="1"
            :max-columns="modalOptions.galleryImageSize"
            :column-width="300"
            :gap="8">
            <template #default="{ item, index }">
                <ImageLoader :data="{ url: item.url, description: item.description, image_resolution: item.image_resolution }" zoomable />
            </template>
        </masonry-wall>
    </div>
</template>
