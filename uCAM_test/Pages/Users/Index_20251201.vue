<template>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">
            ユーザー一覧（ページネーション＋件数切替＋リアルタイム検索機能）
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
            <input
                type="text"
                v-model="search"
                @input="submit"
                placeholder="名前 or メールを検索..."
                class="border p-2 rounded w-64"
            />
        </div>

        <div class="overflow-x-auto">
            <table
                class="w-full table-fixed border-collapse border border-gray-300"
            >
                <colgroup>
                    <col style="width: 80px" />
                    <!-- ID -->
                    <col style="width: 160px" />
                    <!-- 名前 -->
                    <col style="width: 240px" />
                    <!-- メール -->
                </colgroup>

                <thead>
                    <tr class="bg-gray-100">
                        <th
                            @click="sort('id')"
                            class="border p-2 cursor-pointer"
                        >
                            <div class="relative h-6">
                                <span
                                    class="absolute left-1/2 -translate-x-1/2"
                                >
                                    ID
                                </span>

                                <div
                                    class="absolute right-0 top-1/2 -translate-y-1/2"
                                >
                                    <SortIcon_No_Function
                                        column="id"
                                        :sortBy="sortBy"
                                        :sortOrder="sortOrder"
                                    />
                                </div>
                            </div>
                        </th>
                        <!-- ↑↑　@toggle="sort"で "toggle" というイベント名を親で受け取りsort()を実行 -->

                        <th
                            @click="sort('name')"
                            class="border p-2 cursor-pointer"
                        >
                            <div class="relative h-6">
                                <span
                                    class="absolute left-1/2 -translate-x-1/2"
                                >
                                    名前
                                </span>

                                <div
                                    class="absolute right-0 top-1/2 -translate-y-1/2"
                                >
                                    <SortIcon_No_Function
                                        column="name"
                                        :sortBy="sortBy"
                                        :sortOrder="sortOrder"
                                    />
                                </div>
                            </div>
                        </th>
                        <th
                            @click="sort('email')"
                            class="border p-2 cursor-pointer"
                        >
                            <div class="relative h-6">
                                <span
                                    class="absolute left-1/2 -translate-x-1/2"
                                >
                                    メール
                                </span>

                                <div
                                    class="absolute right-0 top-1/2 -translate-y-1/2"
                                >
                                    <SortIcon_No_Function
                                        column="email"
                                        :sortBy="sortBy"
                                        :sortOrder="sortOrder"
                                    />
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="user in users.data"
                        :key="user.id"
                        class="border-t odd:bg-white even:bg-gray-50"
                    >
                        <td class="border p-2 text-center">{{ user.id }}</td>
                        <td class="border p-2 text-center">{{ user.name }}</td>
                        <td class="border p-2 text-center">{{ user.email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- 件数表示（左側） -->
        <div class="flex justify-between items-center">
            <div class="my-2 text-sm text-gray-600">
                {{ users.total }} 件中 {{ users.from }} 〜
                {{ users.to }} 件を表示
            </div>
            <Pagination :links="users.links" @go="go" />
        </div>
        <!-- ページネーションリンク -->
        <!-- <div class="mt-4 flex flex-wrap gap-2">
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
        </div> -->
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import SortIcon_No_Function from "@/Components/SortIcon_No_Function.vue";
import Pagination from "@/Components/Pagination.vue";
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

// 入力されるたびに検索
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
            replace: true,
        }
    );
};
</script>
