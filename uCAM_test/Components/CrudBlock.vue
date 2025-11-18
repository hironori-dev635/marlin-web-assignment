<template>
  <div class="crud-block">
    <h2>{{ title }}</h2>

    <form @submit.prevent="saveItem">
      <input v-model="formData.name" placeholder="名前" />
      <input v-model="formData.description" placeholder="説明" />
      <button type="submit">保存</button>
    </form>

    <ul>
      <li v-for="item in items" :key="item.id">
        {{ item.name }}
        <button @click="deleteItem(item.id)">削除</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia'

// propsでタイトルや接続先を受け取る
const props = defineProps({
  title: { type: String, required: true },
  endpoint: { type: String, required: true }, // 保存先コントローラーのURL
})

const formData = reactive({
  name: '',
  description: '',
})

const items = ref([])

// 初回ロードでデータ取得
const fetchItems = async () => {
  const response = await fetch(props.endpoint)
  const data = await response.json()
  items.value = data
}

onMounted(() => {
  fetchItems()
})

// 保存処理
const saveItem = () => {
  Inertia.post(props.endpoint, formData, {
    onSuccess: () => {
      formData.name = ''
      formData.description = ''
      fetchItems()
    },
  })
}

// 削除処理
const deleteItem = (id) => {
  Inertia.delete(`${props.endpoint}/${id}`, {
    onSuccess: () => {
      fetchItems()
    },
  })
}
</script>

<style scoped>
.crud-block {
  border: 1px solid #ccc;
  padding: 1rem;
  margin-bottom: 1rem;
}
</style>
