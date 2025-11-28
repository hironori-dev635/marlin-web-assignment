<template>
    <CrudComponent
        :items="documents"
        :errors="errors"
        route-base="documents"
        title="文書管理"
        label="文書"
    />
</template>

<script setup>
import CrudComponent from "@/Components/CrudComponent.vue";

const props = defineProps({
    documents: Array,
    errors: Object,
});
</script>
