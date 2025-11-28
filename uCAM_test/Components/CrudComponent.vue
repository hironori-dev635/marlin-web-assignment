<template>
    <div class="p-4">
        <div class="w-full max-w-7xl m-auto">
            <h1 class="text-xl font-bold mb-4">{{ title }}</h1>
            <div v-if="errors.name" class="text-red-500">
                {{ errors.name }}
            </div>
            <div class="flex items-center bg-gray-300 py-4 rounded-md">
                <div class="w-24 text-center">ID</div>
                <div class="flex-1 ml-4">{{ label }}</div>
            </div>
            <div class="">
                <!-- 新規登録 -->

                <div class="flex items-center py-2 border-b-2 border-gray-300 hover:bg-gray-100">
                    <div class="w-24 text-center"></div>
                    <form
                        @submit.prevent="saveItem"
                        class="gap-2 flex h-12 flex-1"
                    >
                        <input
                            type="text"
                            name="name"
                            v-model="newItemForm.name"
                            class="border p-1 flex-1 rounded-md border-gray-300"
                            :placeholder="label + 'を入力'"
                        />
                        <button
                            type="submit"
                            class="hover:bg-green-500 hover:text-white duration-300 px-2 mr-2 w-24 rounded-md"
                        >
                            保存
                        </button>
                    </form>
                    <div class="w-24 px-2 mr-2"></div>
                </div>
                <!-- 一覧 -->

                <div
                    v-for="item in items"
                    :key="item.id"
                    class="flex items-center py-2 hover:bg-gray-100 border-b-2 border-gray-300"
                >
                    <div class="w-24 text-center">{{ item.id }}</div>
                    <form
                        @submit.prevent="updateItem(item.id, item.name)"
                        class="flex h-12 gap-2 flex-1"
                    >
                        <input
                            type="text"
                            v-model="item.name"
                            class="border p-1 flex-1 rounded-md border-gray-300"
                        />
                        <button
                            type="submit"
                            class="hover:bg-blue-500 hover:text-white duration-300 px-2 mr-2 w-24 rounded-md"
                        >
                            更新
                        </button>
                    </form>
                    <button
                        @click="deleteItem(item.id)"
                        class="hover:bg-red-500 hover:text-white duration-300 px-2 mr-2 h-12 w-24 rounded-md"
                    >
                        削除
                    </button>
                </div>
            </div>
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
