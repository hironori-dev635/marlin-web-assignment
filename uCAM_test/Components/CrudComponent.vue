<template>
    <div class="p-4">
        <div class="w-full max-w-7xl m-auto">
            <h1 class="text-xl font-bold mb-4">{{ title }}</h1>

            <!-- エラー表示 -->
            <div v-if="errors.name" class="text-red-500 mb-2">
                {{ errors.name }}
            </div>

            <table
                class="w-full table-fixed border-collapse border border-gray-300"
            >
                <colgroup>
                    <col style="width: 80px" />
                    <!-- ID -->
                    <col style="width: 1fr" />
                    <!-- 名前 -->
                    <col style="width: 150px" />
                    <!-- 操作 -->
                    <col style="width: 150px" />
                    <!-- 操作 -->
                </colgroup>
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-center">ID</th>
                        <th class="border p-2 text-center">{{ label }}</th>
                        <th class="border p-2 text-center" colspan="2">操作</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- 新規登録行 -->
                    <tr class="bg-gray-50">
                        <td class="border p-2 text-center"></td>
                        <td class="border p-2">
                            <input
                                type="text"
                                v-model="newItemForm.name"
                                class="border p-1 w-full rounded-md border-gray-300"
                                :placeholder="label + 'を入力'"
                            />
                        </td>
                        <td class="border p-2 text-center" colspan="2">
                            <button
                                @click="saveItem"
                                class="px-3 py-1 w-24 rounded-md bg-green-500 text-white hover:bg-green-600 duration-300"
                            >
                                保存
                            </button>
                        </td>
                    </tr>

                    <!-- 一覧・編集行 -->
                    <tr
                        v-for="item in items"
                        :key="item.id"
                        class="hover:bg-gray-100 border-t"
                    >
                        <td class="border p-2 text-center">{{ item.id }}</td>
                        <td class="border p-2">
                            <input
                                type="text"
                                v-model="item.name"
                                class="border p-1 w-full rounded-md border-gray-300"
                            />
                        </td>
                        <td class="border p-2 text-center">
                            <button
                                @click="updateItem(item.id, item.name)"
                                class="px-3 py-1 w-24 rounded-md bg-blue-500 text-white hover:bg-blue-600 duration-300 mr-2"
                            >
                                更新
                            </button>
                        </td>
                        <td class="border p-2 text-center">
                            <button
                                @click="deleteItem(item.id)"
                                class="px-3 py-1 w-24 rounded-md bg-red-500 text-white hover:bg-red-600 duration-300"
                            >
                                削除
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    title: String,
    items: Array,
    errors: Object,
    routeBase: String, // ex: 'posts' or 'users'
    label: String,
});

const newItemForm = reactive({ name: null });

// 共通化したCRUD関数
const saveItem = () => {
    router.post(route(`${props.routeBase}.store`), newItemForm, {
        onSuccess: () => {
            newItemForm.name = "";
            alert("新規作成しました！");
        },
    });
};

const updateItem = (id, name) => {
    if (!confirm("本当に変更しますか？")) return;
    router.put(
        route(`${props.routeBase}.update`, id),
        { name },
        {
            onSuccess: () => alert("更新しました！"),
        }
    );
};

const deleteItem = (id) => {
    if (!confirm("本当に削除しますか？")) return;
    router.delete(route(`${props.routeBase}.destroy`, id), {
        onSuccess: () => alert("削除しました！"),
    });
};
</script>
