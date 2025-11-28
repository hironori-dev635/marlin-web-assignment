<script setup>
import { router } from "@inertiajs/vue3";
import dayjs from "dayjs";

const props = defineProps({
    weekStart: String,
    weekEnd: String,
    schedules: Array,
});

// console.log(props.weekStart);
console.log(props.schedules);
// 前週・翌週
const goPrev = () => {
    const prev = dayjs(props.weekStart).subtract(7, "day").format("YYYY-MM-DD");
    router.get(route("schedules.week"), { week_start: prev });
};

const goNext = () => {
    const next = dayjs(props.weekStart).add(7, "day").format("YYYY-MM-DD");
    router.get(route("schedules.week"), { week_start: next });
};

// 週の日付一覧
const days = [...Array(7)].map((_, i) => dayjs(props.weekStart).add(i, "day"));

// 時間（00〜23）
const hours = [...Array(24)].map((_, i) => i);

const eventStyle = (ev, dayColumnHeight) => {
    // dayColumnHeight = 1日の列の高さ(px)

    const [sh, sm] = ev.start_time.split(":").map(Number);
    const [eh, em] = ev.end_time.split(":").map(Number);

    const startMinutes = sh * 60 + sm;
    const endMinutes = eh * 60 + em;
    const durationMinutes = endMinutes - startMinutes;

    const totalMinutes = 24 * 60; // 1日 = 24h = 1440分

    return {
        position: "absolute",
        top: `${(startMinutes / totalMinutes) * dayColumnHeight}px`,
        height: `${(durationMinutes / totalMinutes) * dayColumnHeight}px`,
        left: "2px",
        right: "2px",
        background: ev.color,
        borderRadius: "4px",
        color: "white",
        fontSize: "0.75rem",
        padding: "1px",
    };
};

const eventsOfDay = (day) => {
    return props.schedules.filter((ev) => ev.date === day.format("YYYY-MM-DD"));
};
</script>

<template>
    <div class="p-4">
        <!-- ナビゲーション -->
        <div class="flex justify-between mb-4">
            <button @click="goPrev" class="px-2 py-1 bg-gray-200 rounded">
                前週
            </button>
            <div>{{ props.weekStart }} 〜 {{ props.weekEnd }}</div>
            <button @click="goNext" class="px-2 py-1 bg-gray-200 rounded">
                翌週
            </button>
        </div>

        <!-- 表本体（横：日付、縦：時間） -->
        <div class="grid grid-cols-8 border">
            <!-- 左の時間帯カラム -->
            <div class="col-span-1 border-r">
                <div class="p-1 text-center border-b text-sm">時間</div>
                <div
                    v-for="h in hours"
                    :key="h"
                    class="h-16 border-b text-xs flex items-start"
                >
                    {{ ("0" + h).slice(-2) }}:00
                </div>
            </div>

            <!-- 右側：日ごとのカラム -->
            <div class="col-span-7 grid grid-cols-7" >
                <!-- 各日 -->
                <div v-for="day in days" :key="day" class="border-r relative" >
                    <!-- 日付ヘッダー -->
                    <div class="p-1 text-center border-b bg-gray-100 text-sm">
                        {{ day.format("MM/DD") }} ({{
                            ["日", "月", "火", "水", "木", "金", "土"][
                                day.day()
                            ]
                        }})
                    </div>

                    <!-- 24時間枠 -->
                    <div
                        v-for="h in hours"
                        :key="h"
                        class="h-16 border-b relative"
                    >
                        <!-- ここに予定の帯を重ねる -->
                        <div
                            v-for="ev in eventsOfDay(day)"
                            :key="ev.id"
                            class="rounded text-white text-xs cursor-pointer overflow-hidden"
                            :style="eventStyle(ev, 960)"
                            @click="edit(ev.id)"
                        >
                            {{ ev.title }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
