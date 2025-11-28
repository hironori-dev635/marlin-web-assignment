<template>
    <div class="p-4">
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
        <table class="w-full border-collapse table-fixed">
            <thead>
                <tr>
                    <th
                        v-for="w in ['日', '月', '火', '水', '木', '金', '土']"
                        class="border p-2 w-1/7"
                        :class="{
                            'text-red-500': w === '日', // 日曜
                            'text-blue-500': w === '土', // 土曜
                        }"
                    >
                        {{ w }}
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="week in weeks" :key="week[0]">
                    <td
                        v-for="day in week"
                        :key="day"
                        class="border align-top h-24 p-1 w-1/7"
                        :class="dayClass(day)"
                    >
                        <!-- 日付 -->
                        <div class="text-sm mb-1">
                            {{ day.format("D") }}
                        </div>

                        <!-- 予定一覧 -->
                        <div
                            v-for="ev in eventsOfDay(day)"
                            :key="ev.id"
                            class="text-xs p-1 rounded cursor-pointer"
                            :style="{ background: ev.color }"
                            @click="edit(ev.id)"
                        >
                            {{ ev.title }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { useForm, router } from "@inertiajs/vue3";
import dayjs from "dayjs";
import "dayjs/locale/ja"; // 日本語ロケール読み込み
import Holidays from "date-holidays";

const props = defineProps({
    month: String, // YYYY-MM
    schedules: Array,
    start: String,
    end: String,
});

dayjs.locale("ja");
const hd = new Holidays("JP");
const dayClass = (date) => {
    if (date.format("YYYY-MM") !== props.month)
        return "bg-gray-50 text-gray-400";
    if (hd.isHoliday(date)) return "text-red-500"; // 祝日優先
    const day = dayjs(date).day();
    if (day === 0) return "text-red-500"; // 日曜
    if (day === 6) return "text-blue-500"; // 土曜
    return ""; // 平日はデフォルト
};

const getDayBg = (day) => {
    if (day.format("YYYY-MM") !== props.month) return "bg-gray-100";
    if (day.day() === 0) return "bg-red-100";
    if (day.day() === 6) return "bg-blue-100";
    return "";
};
//カレンダーの全日付を配列にする
const days = [];
let day = dayjs(props.start); //月の開始日を代入
//endがdayより後ろ、またはendがdayと同じならループ実行
while (day.isBefore(props.end) || day.isSame(props.end)) {
    days.push(day); //配列daysにdayを追加
    day = day.add(1, "day"); //dayを一日進める
}

const weeks = [];
for (let i = 0; i < days.length; i += 7) {
    weeks.push(days.slice(i, 7 + i));
}

// console.log(weeks);
const eventsOfDay = (day) => {
    return props.schedules.filter((ev) => dayjs(ev.date).isSame(day, "day"));
};

const edit = (id) => {
    // router.get(`/schedule/${id}/edit`);
};

// ========== 月移動 ==========
const goPrev = () => {
    const m = dayjs(props.month).subtract(1, "month").format("YYYY-MM");
    router.get(route("schedules.index2"), { month: m });
};

const goNext = () => {
    const m = dayjs(props.month).add(1, "month").format("YYYY-MM");
    router.get(route("schedules.index2"), { month: m });
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
