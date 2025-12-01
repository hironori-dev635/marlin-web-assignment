<script setup>
const props = defineProps({
    links: Array,
});

const emit = defineEmits(["go"]);

const convertLabel = (label) => {
    if (label.includes("Previous")) return "前へ";
    if (label.includes("Next")) return "次へ";

    // &laquo; &raquo; を除去
    return label.replace(/&laquo;|&raquo;/g, "");
};
</script>

<template>
    <div class="mt-4 flex flex-wrap gap-2">
        <button
            v-for="link in props.links"
            :key="link.label + link.url"
            @click.prevent="emit('go', link.url)"
            :disabled="!link.url"
            class="px-3 py-1 border rounded"
            :class="{
                'bg-blue-200': link.active,
                'text-gray-400': !link.url,
            }"
        >
            {{ convertLabel(link.label) }}
        </button>
    </div>
</template>
