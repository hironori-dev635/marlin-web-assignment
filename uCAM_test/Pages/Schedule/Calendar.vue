<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

const page = usePage();

// Laravel から渡された schedules を FullCalendar 用の形式に変換
const events = computed(() => {
    return page.props.schedules.map((s) => ({
        title: s.title,
        date: s.date,
    }));
});

const calendarOptions = computed(() => ({
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: "dayGridMonth",
    events: events.value,
    height: 800,

    eventClick: function (info) {
        const id = info.event.id;
        alert(`イベントクリック: ${info.event.title}`);
        // router.get(route("schedules.edit", id));
    },
}));
</script>

<template>
    <FullCalendar :options="calendarOptions" />
</template>
