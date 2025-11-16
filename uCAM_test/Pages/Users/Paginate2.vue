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
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">ID</th>
                    <th class="border p-2">名前</th>
                    <th class="border p-2">メール</th>
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
        route("users.paginate2"),
        { perPage: localPerPage.value },
        { preserveScroll: true }
    );
};
</script>
