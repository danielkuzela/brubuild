<script setup>
import { shallowRef } from "vue";
import Image from "@/Components/Contents/Image.vue";
import Text from "@/Components/Contents/Text.vue";

const components = shallowRef([
    Image,
    Text
])

const props = defineProps({
    data: {
        type: Object
    }
});

function getContentComponent(type){
    const searchedComponentName = type;
    const foundComponent = components.value.find(comp => comp.searchable_name === searchedComponentName);

    if (foundComponent) {
        return foundComponent;
    } else {
        console.warn(`Component '${searchedComponentName}' not found.`);
    }
}

</script>

<template>
    <template v-for="(item, index) in data">
        <component :is="getContentComponent(item.type)" :data="item.data" :index="index"></component>
    </template>
</template>
