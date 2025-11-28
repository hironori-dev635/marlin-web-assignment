<template>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">
            ユーザー一覧（ページネーション＋件数切替）
        </h1>

        <!-- 件数セレクト -->
        <div class="mb-3">
            <label for="perPage" class="mr-2">表示件数:</label>
            <select
                id="perPage"
                v-model="localPerPage"
                @change="changePerPage"
                class="border rounded p-1 pr-8 appearance-none bg-white"
            >
                <option :value="10">10件</option>
                <option :value="25">25件</option>
                <option :value="50">50件</option>
            </select>
        </div>

        <!-- テーブル -->
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th @click="sort('id')" class="cursor-pointer border p-2">
                        ID
                        <span v-if="sortBy === 'id'">
                            {{ sortOrder === "asc" ? "▲" : "▼" }}
                        </span>
                    </th>
                    <th @click="sort('name')" class="cursor-pointer border p-2">
                        名前
                        <span v-if="sortBy === 'name'">
                            {{ sortOrder === "asc" ? "▲" : "▼" }}
                        </span>
                    </th>
                    <th
                        @click="sort('email')"
                        class="cursor-pointer border p-2"
                    >
                        メール
                        <span v-if="sortBy === 'email'">
                            {{ sortOrder === "asc" ? "▲" : "▼" }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users.data" :key="user.id" class="border-t">
                    <td class="border p-2">{{ user.id }}</td>
                    <td class="border p-2">{{ user.name }}</td>
                    <td class="border p-2">{{ user.email }}</td>
                </tr>
            </tbody>
        </table>

        <!-- ページネーションリンク -->
        <div class="mt-4 flex flex-wrap gap-2">
            <button
                v-for="link in users.links"
                :key="link.label"
                @click.prevent="go(link.url)"
                v-html="link.label"
                :disabled="!link.url"
                class="px-3 py-1 border rounded"
                :class="{
                    'bg-blue-200': link.active,
                    'text-gray-400': !link.url,
                }"
            />
        </div>
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    users: Object,
    perPage: Number,
    sortBy: String,
    sortOrder: String,
});

const localPerPage = ref(props.perPage);

// ページリンクをクリックしたとき
const go = (url) => {
    if (!url) return;
    router.visit(url, {
        preserveScroll: true,
    });
};

// 件数変更したとき
const changePerPage = () => {
    router.get(
        route("users.index"),
        { perPage: localPerPage.value },
        { preserveScroll: true }
    );
};

// 並び替え状態を保持
const sortBy = ref(props.sortBy);
const sortOrder = ref(props.sortOrder);

// 切り替え処理
const sort = (column) => {
    // 同じ列クリックなら昇⇄降をトグル
    if (sortBy.value === column) {
        sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
    } else {
        sortBy.value = column;
        sortOrder.value = "asc";
    }

    router.get(
        route("users.index"),
        { sortBy: sortBy.value, sortOrder: sortOrder.value },
        { preserveState: true, preserveScroll: true }
    );
};
</script>
