<template>
    <div class="p-4">
        <h1 class="text-xl font-bold mb-4">投稿管理</h1>

        <!-- 新規投稿フォーム -->
        <form @submit.prevent="saveItem" class="mb-4 flex h-12">
            <!-- <input v-model="form.name" placeholder="名前" class="border p-1" /> -->
            <input
                type="text"
                name="name"
                v-model="newPostForm.name"
                class="border p-1 mr-2"
            /><br />

            <button type="submit" class="bg-blue-500 text-white px-2">
                保存
            </button>
        </form>
        <div v-if="errors.name">{{ errors.name }}</div>

        <!-- 投稿一覧 -->
        <ul>
            <li
                v-for="post in posts"
                :key="post.id"
                class="flex items-center mb-4"
            >
                <form
                    @submit.prevent="updateItem(post.id, post.name)"
                    class="flex h-12 gap-2"
                >
                    <input
                        type="text"
                        name="name"
                        v-model="post.name"
                        class="border p-1"
                    />
                    <button
                        type="submit"
                        class="bg-blue-500 text-white px-2 mr-2"
                    >
                        更新
                    </button>
                </form>
                <button
                    @click="deleteItem(post.id)"
                    class="bg-red-500 text-white px-2 h-12"
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

const newPostForm = reactive({
    name: null,
});

// マウント時にログを出力
// onMounted(() => {
//     console.log(props.posts);
// });
const saveItem = () => {
    router.post(route("posts.store"), newPostForm, {
        onSuccess: () => {
            newPostForm.name = "";
            alert("新規作成しました！");
        },
    });
};

const updateItem = (id, name) => {
    if (!confirm("本当に変更しますか？")) {
        return; // キャンセルしたら何もしない
    }
    router.put(
        route("posts.update", id),
        { name },
        {
            onSuccess: () => {
                alert("更新しました");
            },
        }
    );
};

const deleteItem = (id) => {
    if (!confirm("本当に削除しますか？")) {
        return; // キャンセルしたら何もしない
    }
    router.delete(route("posts.destroy", id), {
        onSuccess: () => {
            alert("削除しました！");
        },
    });
};
</script>
