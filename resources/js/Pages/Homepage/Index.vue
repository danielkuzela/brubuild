<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Gallery from "@/Components/Gallery.vue";

const props = defineProps(['media'])
</script>
<template>
    <GuestLayout>
        <Gallery :media="media" />
    </GuestLayout>
</template>
