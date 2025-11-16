<template>
    <div class="p-6">
        <!-- ○ 前月・翌月ボタン -->
        <div class="flex items-center mb-4 gap-4">
            <button
                @click="goPrev"
                class="px-4 py-2 bg-gray-700 text-white rounded"
            >
                ← 前月
            </button>

            <h1 class="text-2xl font-bold">{{ month }}</h1>

            <button
                @click="goNext"
                class="px-4 py-2 bg-gray-700 text-white rounded"
            >
                翌月 →
            </button>
        </div>

        <h1 class="text-2xl font-bold mb-4">{{ month }} のスケジュール</h1>

        <!-- 月の日ごと -->
        <div v-for="d in days" :key="d.date" class="border-b py-3">
            <strong
                :class="dayClass(d.date)"
                >{{ d.date }}({{ dayjs(d.date).format("ddd") }})</strong
            >

            <div v-for="ev in d.events" :key="ev.id" class="ml-6">
                <span :style="{ color: ev.color }">● {{ ev.title }}</span>
            </div>
        </div>

        <!-- 新規予定 -->
        <div class="mt-6">
            <h2 class="font-bold mb-2">予定追加</h2>
            <input v-model="form.date" type="date" class="border p-1" />

            <input
                v-model="form.title"
                type="text"
                placeholder="タイトル"
                class="border p-1 ml-2"
            />

            <button
                @click="save"
                class="bg-blue-600 text-white px-4 py-2 rounded ml-2"
            >
                保存
            </button>
        </div>
    </div>
</template>

<script setup>
import { useForm, router } from "@inertiajs/vue3";
import dayjs from "dayjs";
import "dayjs/locale/ja"; // 日本語ロケール読み込み
import Holidays from 'date-holidays';



const props = defineProps({
    month: String,
    days: Array,
});

dayjs.locale("ja");
const hd = new Holidays('JP');
const dayClass = (date) => {
  if (hd.isHoliday(date)) return 'text-red-500';       // 祝日優先
  const day = dayjs(date).day();
  if (day === 0) return 'text-red-500';               // 日曜
  if (day === 6) return 'text-blue-500';              // 土曜
  return '';                                          // 平日はデフォルト
};
// ========== 月移動 ==========
const goPrev = () => {
    const m = dayjs(props.month).subtract(1, "month").format("YYYY-MM");
    router.get(route("schedules.index"), { month: m });
};

const goNext = () => {
    const m = dayjs(props.month).add(1, "month").format("YYYY-MM");
    router.get(route("schedules.index"), { month: m });
};

// ========== 新規登録 ==========
const form = useForm({
    date: "",
    title: "",
    memo: "",
    color: "",
});

const save = () => {
    form.post(route("schedules.store"), {
        onSuccess: () => form.reset(),
    });
};
</script>
