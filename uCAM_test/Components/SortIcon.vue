<template>
  <span
    class="ml-1 cursor-pointer select-none"
    @click.stop="toggle"
  >
    <!-- 通常時（未ソート） -->
    <template v-if="!active">
      ▽
    </template>

    <!-- 昇順 -->
    <template v-else-if="order === 'asc'">
      ▲
    </template>

    <!-- 降順 -->
    <template v-else>
      ▼
    </template>
  </span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  column: String,
  sortBy: String,
  sortOrder: String,
})

const emit = defineEmits(['toggle'])

// 現在の列がソート対象かどうか
const active = computed(() => props.sortBy === props.column)
const order = computed(() => props.sortOrder)

const toggle = () => {
  emit('toggle', props.column)
}
</script>

<style scoped>
span {
  font-size: 0.75rem; /* 小さめ */
  line-height: 1;
}
</style>
