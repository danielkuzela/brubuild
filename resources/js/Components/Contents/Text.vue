<script setup>

const props = defineProps(['data']);
</script>

<template>
    <div class="content max-w-5xl mx-auto" v-html="data.source"></div>
</template>

<script>
export default {
    searchable_name: "text"
}
</script>
