<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridPlugin from "@fullcalendar/timegrid";

const page = usePage();

const events = computed(() =>
  page.props.schedules.map(s => ({
    id: s.id,
    title: s.title,
    start: `${s.date}T${s.start_time}`,
    end: `${s.date}T${s.end_time}`,
    backgroundColor: s.color || "#3b82f6",
  }))
);

const calendarOptions = {
  plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
  initialView: "timeGridWeek",
  events: events.value,
  eventClick: function (info) {
        const id = info.event.id;
        alert(`イベントクリック: ${info.event.title}`);
        // router.get(route("schedules.edit", id));
    },
};
</script>

<template>
  <FullCalendar :options="calendarOptions" />
</template>
