<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import Holidays from "date-holidays";
const page = usePage();
const calendarRef = ref(null); // カレンダーの ref

const events = computed(() =>
    page.props.schedules.map((s) => ({
        id: s.id,
        title: s.title,
        start: `${s.date}T${s.start_time}`,
        end: `${s.date}T${s.end_time}`,
        backgroundColor: s.color || "#3b82f6",
    }))
);

const calendarOptions = ref({
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    initialView: "dayGridMonth",
    events: events.value,
    height: 700, //高さ指定
    allDaySlot: false, // ← ここで全日行を非表示に
    dayHeaderDidMount(info) {
        // info.date はヘッダーの日付（週の開始日など）
        const day = info.date.getDay();

        // 日曜は赤、土曜は青
        if (day === 0) info.el.style.color = "red";
        if (day === 6) info.el.style.color = "blue";
    },
    dayCellDidMount(info) {
        const day = info.date.getDay();

        // 日付を表示している span を探す
        const dateEl = info.el.querySelector(".fc-daygrid-day-number");
        if (!dateEl) return;

        // 日曜日は赤文字、土曜日は青文字
        if (day === 0) dateEl.style.color = "red";
        if (day === 6) dateEl.style.color = "blue";

        // 祝日も赤文字
        if (hd.isHoliday(info.date)) dateEl.style.color = "red";
    },
    eventClick: function (info) {
        const id = info.event.id;
        alert(`イベントクリック: ${info.event.title}`);
        // router.get(route("schedules.edit", id));
    },
});

//祝日判定
const hd = new Holidays("JP"); // JP=日本

// 日付文字列を渡して祝日かどうか判定
const isHoliday = (date) => {
    return !!hd.isHoliday(date); // 日付が祝日ならオブジェクト、それ以外は null
};

// ビュー切り替え関数
const switchToMonth = () => {
    calendarRef.value.getApi().changeView("dayGridMonth");
};

const switchToWeek = () => {
    calendarRef.value.getApi().changeView("timeGridWeek");
};
</script>

<template>
    <div class="mb-4">
        <button
            @click="switchToMonth"
            class="px-4 py-2 bg-blue-500 text-white rounded"
        >
            月表示
        </button>
        <button
            @click="switchToWeek"
            class="px-4 py-2 bg-green-500 text-white rounded ml-2"
        >
            週表示
        </button>
    </div>

    <FullCalendar ref="calendarRef" :options="calendarOptions" />
</template>
