<script setup>
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    errors: Object,
});

const form = ref({
    date: "",
    start_time: "",
    end_time: "",
    title: "",
    memo: "",
    color: "#90cdf4", // デフォ：薄い青
});

// 保存処理
const submit = () => {
    router.post(route("schedules.store"), form.value);
};
</script>

<template>
    <div class="max-w-lg mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">予定を新規登録</h1>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-bold mb-1">日付</label>
                <input
                    type="date"
                    v-model="form.date"
                    class="border p-2 w-full rounded"
                />
                <div v-if="errors.date" class="text-red-400">
                    {{ errors.date }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold mb-1">開始時間</label>
                <input
                    type="time"
                    v-model="form.start_time"
                    class="border p-2 w-full rounded"
                />
                <div v-if="errors.start_time" class="text-red-400">
                    {{ errors.start_time }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold mb-1">終了時間</label>
                <input
                    type="time"
                    v-model="form.end_time"
                    class="border p-2 w-full rounded"
                />
                <div v-if="errors.end_time" class="text-red-400">
                    {{ errors.end_time }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold mb-1">タイトル</label>
                <input
                    type="text"
                    v-model="form.title"
                    class="border p-2 w-full rounded"
                />
                <div v-if="errors.title" class="text-red-400">
                    {{ errors.title }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold mb-1">メモ</label>
                <textarea
                    v-model="form.memo"
                    class="border p-2 w-full rounded"
                ></textarea>
                <div v-if="errors.memo" class="text-red-400">
                    {{ errors.memo }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold mb-1">色</label>
                <input
                    type="color"
                    v-model="form.color"
                    class="w-16 h-8 p-0 border rounded"
                />
            </div>

            <button
                @click="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
                保存
            </button>
        </div>
    </div>
</template>
