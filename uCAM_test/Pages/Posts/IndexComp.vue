<template>
    <CrudComponent
        :items="posts"
        :errors="errors"
        route-base="posts"
        title="投稿管理"
        label="名前"
    />
</template>

<script setup>
import CrudComponent from "@/Components/CrudComponent.vue";

const props = defineProps({
    posts: Array,
    errors: Object,
});
</script>
