<template>
    <div>
        <CrudPage title="ユーザー管理" :items="posts" />
    </div>
</template>

<script setup>
import CrudPage from "@/Components/CrudPage.vue";
import { defineProps } from "vue";

const props = defineProps({
    posts: Array
})
</script>


