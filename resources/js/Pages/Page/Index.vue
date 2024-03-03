<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Gallery from "@/Components/Gallery.vue";
import ContentWrapper from "@/Components/ContentWrapper.vue";

const props = defineProps(['page'])
</script>
<template>
    <GuestLayout>
        <div class="container mx-auto mt-16">
            <h1>{{ page.name }}</h1>
            <ContentWrapper :data="page.rendered_content" />
        </div>
    </GuestLayout>
</template>
