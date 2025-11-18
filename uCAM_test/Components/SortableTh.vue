<template>
    <th @click="handleClick" class="cursor-pointer select-none p-2 border">
        <span>{{ label }}</span>

        <!-- ソート中だけアイコン表示 -->
        <span v-if="active">
            {{ order === "asc" ? "▲" : "▼" }}
        </span>
    </th>
</template>

<script setup>
import { computed } from "vue";
const props = defineProps({
    column: String, // 例: "id"
    label: String, // 例: "ID"
    sortBy: String, // 親の状態
    sortOrder: String, // 親の状態
});

const emit = defineEmits(["sort"]);

const handleClick = () => {
    emit("sort", props.column);
};

const active = computed(() => props.sortBy === props.column);
const order = computed(() => props.sortOrder);
</script>

<style scoped>
/* デザイン統一したいならここにまとめて書ける */
</style>
