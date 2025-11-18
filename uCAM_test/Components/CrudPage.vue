<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">{{ title }}</h1>

        <form @submit.prevent="saveItem">
            <input
                v-model="form.name"
                placeholder="名前"
                class="border p-2 mb-2 w-full"
            />
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">
                保存
            </button>
        </form>

        <table class="w-full mt-4 border">
            <thead>
                <tr>
                    <th class="border px-2 py-1">ID</th>
                    <th class="border px-2 py-1">名前</th>
                    <th class="border px-2 py-1">操作</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items" :key="item.id">
                    <td class="border px-2 py-1">{{ item.id }}</td>
                    <td class="border px-2 py-1">{{ item.name }}</td>
                    <td class="border px-2 py-1">
                        <button
                            @click="deleteItem(item.id)"
                            class="bg-red-500 text-white px-2 py-1"
                        >
                            削除
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
const props = defineProps({
    title: String,
    items: {
        type: Array,
        default: () => [], // ← 配列のデフォルトを指定
    },
});

const items = ref([...props.items]); // props をコピーしてローカル操作用

const form = ref({
    name: "",
});

const saveItem = () => {
    // Inertia POST で送信
    router.post(route("posts.store"), form.value, {
        onSuccess: () => {
            form.value.name = "";
            // Inertia が返す props で items は自動更新される
        },
    });
};

const deleteItem = (id) => {
    router.delete(route("posts.destroy", id), {
        onSuccess: () => {
            // Inertia が返す props で items は自動更新される
        },
    });
};
</script>
