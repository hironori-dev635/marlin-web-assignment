<template>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">
            ユーザー一覧（ページネーション＋件数切替＋検索機能）
        </h1>
        <div class="flex justify-between">
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
        </div>
        <!-- テーブル -->
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2 ">
                        <div class="flex items-center justify-between">
                            ID
                            <SortIcon
                                column="id"
                                :sortBy="sortBy"
                                :sortOrder="sortOrder"
                                @toggle="sort"
                            />
                        </div>
                    </th>
                    <!-- ↑↑　@toggle="sort"で "toggle" というイベント名を親で受け取りsort()を実行 -->

                    <th class="border p-2">
                        <div class="flex items-center justify-between">
                            名前
                            <SortIcon
                                column="name"
                                :sortBy="sortBy"
                                :sortOrder="sortOrder"
                                @toggle="sort"
                            />
                        </div>
                    </th>
                    <th class="border p-2 ">
                        <div class="flex items-center justify-between">
                            メール
                            <SortIcon
                                column="email"
                                :sortBy="sortBy"
                                :sortOrder="sortOrder"
                                @toggle="sort"
                            />
                        </div>
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
import SortIcon from "@/Components/SortIcon.vue";

const props = defineProps({
    users: Object,
    perPage: Number,
    sortBy: String,
    sortOrder: String,
    filters: Object,
});

const localPerPage = ref(props.perPage);

// ページリンクをクリックしたとき
const go = (url) => {
    if (!url) return;

    const params = {
        sortBy: sortBy.value,
        sortOrder: sortOrder.value,
        perPage: localPerPage.value,
        search: search.value,
    };

    router.get(url, params, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};

// 件数変更したとき
const changePerPage = () => {
    submit();
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

    submit();
};

// 初期値を保持
const search = ref(props.filters.search ?? "");

// 検索ボタン押下時の処理
const submit = () => {
    router.get(
        route("users.index"),
        {
            sortBy: sortBy.value,
            sortOrder: sortOrder.value,
            perPage: localPerPage.value,
            search: search.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

// クリアボタン
const reset = () => {
    search.value = "";
    submit();
};
</script>
