<script setup>
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  users: Array, 
  sortBy: String,
  sortOrder: String,
})

// 並び替え状態を保持
const sortBy = ref(props.sortBy)
const sortOrder = ref(props.sortOrder)

// 切り替え処理
const sort = (column) => {
  // 同じ列クリックなら昇⇄降をトグル
  if (sortBy.value === column) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortBy.value = column
    sortOrder.value = 'asc'
  }

  router.get(
    route('users.sort1'),
    { sortBy: sortBy.value, sortOrder: sortOrder.value },
    { preserveState: true, preserveScroll: true }
  )
}
</script>

<template>
  <div class="p-6">
    <h1 class="text-xl font-bold mb-4">ユーザー一覧（並び替え）</h1>

    <table class="w-full border-collapse border border-gray-300">
      <thead>
        <tr class="bg-gray-100">
          <th @click="sort('id')" class="cursor-pointer border p-2">
            ID
            <span v-if="sortBy === 'id'">
              {{ sortOrder === 'asc' ? '▲' : '▼' }}
            </span>
          </th>
          <th @click="sort('name')" class="cursor-pointer border p-2">
            名前
            <span v-if="sortBy === 'name'">
              {{ sortOrder === 'asc' ? '▲' : '▼' }}
            </span>
          </th>
          <th @click="sort('email')" class="cursor-pointer border p-2">
            メール
            <span v-if="sortBy === 'email'">
              {{ sortOrder === 'asc' ? '▲' : '▼' }}
            </span>
          </th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="user in users" :key="user.id" class="border-t">
          <td class="border p-2">{{ user.id }}</td>
          <td class="border p-2">{{ user.name }}</td>
          <td class="border p-2">{{ user.email }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

