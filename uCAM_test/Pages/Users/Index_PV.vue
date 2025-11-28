<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

// PrimeVue
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Paginator from "primevue/paginator";

const props = defineProps({
    users: Object,
    perPage: Number,
    sortBy: String,
    sortOrder: [String, Number],
    filters: Object,
});

// 検索用
const search = ref(props.filters?.search ?? "");

// 現在ソート状態（string 'asc'/'desc'）
const sortField = ref(props.sortBy ?? "id");
const sortOrder = ref(
    props.sortOrder === "desc" || props.sortOrder === -1 ? "desc" : "asc"
);

// ページ用
const currentPage = ref(props.users.current_page || 1);

// API送信（sortOrder は 'asc' or 'desc' を送る）
function updateTable(params = {}) {
    const payload = {
        search: search.value,
        sortBy: sortField.value,
        sortOrder: sortOrder.value, // 'asc' or 'desc'
        page: params.page ?? currentPage.value,
        perPage: props.perPage ?? props.users.per_page,
        ...params,
    };

    console.log("updateTable payload:", payload); // ← デバッグ用: 削除可

    router.get(route("users.indexPV"), payload, {
        preserveScroll: true,
        preserveState: true,
        replace: true,
    });
}

// ソートイベントハンドラ（PrimeVue の e.sortOrder は 1 / -1 / 0）
function onSort(e) {
    console.log("sort event:", e); // ← デバッグ用
    if (e.sortField) sortField.value = e.sortField;

    // e.sortOrder: 1 (asc), -1 (desc), 0 (unsorted)
    if (e.sortOrder === 1) sortOrder.value = "asc";
    else if (e.sortOrder === -1) sortOrder.value = "desc";
    else sortOrder.value = "asc";

    // ソート変わったら1ページ目に戻す
    currentPage.value = 1;
    updateTable({ page: 1 });
}

// ページイベント
function onPage(e) {
    // e.page は 0-indexed（PrimeVue Paginator）, 送るのは 1-indexed
    const page = e.page + 1;
    currentPage.value = page;
    updateTable({ page });
}

// 検索ボタン
function doSearch() {
    currentPage.value = 1;
    updateTable({ page: 1 });
}
</script>

<template>
    <div class="p-4">
        <div class="mb-3 flex gap-2">
            <InputText v-model="search" placeholder="検索..." class="w-64" />
            <Button
                label="検索"
                icon="pi pi-search"
                
                @click="doSearch"
            />
        </div>

        <DataTable
            :value="users.data"
            :lazy="true"
            :sortField="sortField"
            :sortOrder="sortOrder === 'asc' ? 1 : -1"
            @sort="onSort"
            :paginator="false"
            
        >
            <Column field="id" header="ID" sortable style="width: 80px" />
            <Column field="name" header="名前" sortable style="width: 400px" />
            <Column
                field="email"
                header="メール"
                sortable
                style="width: 400px"
            />
        </DataTable>

        <Paginator
            :rows="users.per_page"
            :totalRecords="users.total"
            :first="(users.current_page - 1) * users.per_page"
            @page="onPage"
        />
    </div>
</template>
