<template>
    <div class="p-4">
        <h1 class="text-xl font-bold mb-4">ユーザー検索（ボタン版）</h1>

        <!-- 検索フォーム -->
        <form @submit.prevent="submit" class="flex items-center gap-2">
            <input
                type="text"
                v-model="search"
                placeholder="名前 or メールを検索..."
                class="border p-2 rounded w-64"
            />

            <button
                type="submit"
                class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600"
            >
                検索
            </button>

            <!-- リセットボタン（検索をクリアする） -->
            <button
                type="button"
                @click="reset"
                class="bg-gray-300 px-3 py-2 rounded hover:bg-gray-400"
            >
                クリア
            </button>
        </form>

        <!-- テーブル -->
        <table class="mt-4 border-collapse w-full">
            <thead>
                <tr class="border-b">
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">名前</th>
                    <th class="p-2 text-left">メール</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="u in users" :key="u.id" class="border-b">
                    <td class="p-2">{{ u.id }}</td>
                    <td class="p-2">{{ u.name }}</td>
                    <td class="p-2">{{ u.email }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    users: Array,
    filters: Object,
});

// 初期値を保持
const search = ref(props.filters.search ?? "");

// 検索ボタン押下時の処理
const submit = () => {
    router.get(
        route("users.search2"),
        { search: search.value },
        {
            preserveState: true,
            replace: true,
        }
    );
};

// クリアボタン
const reset = () => {
    search.value = "";
    submit();
};
</script>
