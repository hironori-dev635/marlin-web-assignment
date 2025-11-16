<template>
    <div class="p-4">
        <h1 class="text-xl font-bold mb-4">投稿管理</h1>

        <!-- フォーム -->
        <form @submit.prevent="saveItem" class="mb-4 flex gap-2">
            <!-- <input v-model="form.name" placeholder="名前" class="border p-1" /> -->
            <input
                type="text"
                name="name"
                v-model="form.name"
                class="border p-1"
            /><br />
            <div v-if="errors.name">{{ errors.name }}</div>

            <button type="submit" class="bg-blue-500 text-white px-2">
                保存
            </button>
        </form>

        <!-- 投稿一覧 -->
        <ul>
            <li
                v-for="post in posts"
                :key="post.id"
                class="flex justify-between items-center mb-1"
            >
                <span>{{ post.name }}</span>
                <button
                    @click="deleteItem(post.id)"
                    class="bg-red-500 text-white px-2"
                >
                    削除
                </button>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";
import { reactive } from "vue";
const props = defineProps({
    posts: Array,
    errors: Object,
});

const form = reactive({
    name: null,
});
// マウント時にログを出力
// onMounted(() => {
//     console.log(props.posts);
// });
const saveItem = () => {
    router.post(route("posts.store"), form, {
        onSuccess: () => {
            form.name = "";
        },
    });
};

const deleteItem = (id) => {
    router.delete(route("posts.destroy", id), {
        onSuccess: () => {},
    });
};
</script>
