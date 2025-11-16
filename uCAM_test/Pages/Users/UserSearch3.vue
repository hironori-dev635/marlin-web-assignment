<template>
    <div class="p-4">
        <h1 class="text-xl font-bold mb-4">
            ユーザー検索（アルファベット・あいうえお表版）
        </h1>
        <div>
            <h2>アルファベット表</h2>

            <div
                v-for="(row, rowIndex) in alphabetRows"
                :key="rowIndex"
                class="alphabet-row"
            >
                <button
                    v-for="letter in row"
                    :key="letter"
                    class="alphabet-btn"
                    @click="selectLetter(letter)"
                >
                    {{ letter }}
                </button>
            </div>

            <div v-if="selectedLetter" class="mt-4">
                <p>クリックしたのは {{ selectedLetter }} です</p>
            </div>
        </div>
        <div>
            <h2>あいうえお表</h2>

            <div
                v-for="(row, rowIndex) in kanaRows"
                :key="rowIndex"
                class="kana-row"
            >
                <button
                    v-for="(kana, index) in row"
                    :key="index"
                    class="kana-btn"
                    :disabled="!kana"
                    @click="selectKana(kana)"
                >
                    {{ kana }}
                </button>
            </div>

            <div v-if="selectedKana" class="mt-4">
                <p>クリックしたのは {{ selectedKana }} です</p>
            </div>
        </div>
        <!-- 検索フォーム -->
        <form @submit.prevent="submit" class="flex items-center gap-2">
            <input
                type="text"
                v-model="search"
                placeholder="名前 or メールを検索..."
                class="border p-2 rounded w-64"
            />
            <button
                type="submit"
                class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600"
            >
                検索
            </button>

            <!-- リセットボタン（検索をクリアする） -->
            <button
                type="button"
                @click="reset"
                class="bg-gray-300 px-3 py-2 rounded hover:bg-gray-400"
            >
                クリア
            </button>
        </form>
        <p>フォームの値は「{{ search }}」です。</p>
        <!-- テーブル -->
        <table v-if="users.length > 0" class="mt-4 border-collapse w-full">
            <thead>
                <tr class="border-b">
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">名前</th>
                    <th class="p-2 text-left">メール</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="u in users" :key="u.id" class="border-b">
                    <td class="p-2">{{ u.id }}</td>
                    <td class="p-2">{{ u.name }}</td>
                    <td class="p-2">{{ u.email }}</td>
                </tr>
            </tbody>
        </table>
        <div v-else>
            <p>検索結果がありません</p>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    users: Array,
    filters: Object,
});

// 初期値を保持
const search = ref(props.filters.search ?? "");

// 検索ボタン押下時の処理
const submit = () => {
    router.get(
        route("users.search3"),
        { search: search.value },
        {
            preserveState: true,
            replace: true,
        }
    );
};

// クリアボタン
const reset = () => {
    search.value = "";
    submit();
};

// A〜Z を行ごとに分ける
const alphabetRows = [
    ["A", "B", "C", "D", "E", "F", "G"],
    ["H", "I", "J", "K", "L", "M", "N"],
    ["O", "P", "Q", "R", "S", "T", "U"],
    ["V", "W", "X", "Y", "Z"],
];

const selectedLetter = ref(null);

const selectLetter = (letter) => {
    selectedLetter.value = letter;
    search.value = letter;
};

// アイウエオ表（空欄は null または ''）
// 中抜きセルは空文字にしてもOK
const kanaRows = [
    ["ワ", "ラ", "ヤ", "マ", "ハ", "ナ", "タ", "サ", "カ", "ア"],
    ["", "リ", "", "ミ", "ヒ", "ニ", "チ", "シ", "キ", "イ"],
    ["ヲ", "ル", "ユ", "ム", "フ", "ヌ", "ツ", "ス", "ク", "ウ"],
    ["", "レ", "", "メ", "ヘ", "ネ", "テ", "セ", "ケ", "エ"],
    ["ン", "ロ", "ヨ", "モ", "ホ", "ノ", "ト", "ソ", "コ", "オ"],
];

const selectedKana = ref(null);

const selectKana = (kana) => {
    if (!kana) return; // 空セルは無視
    selectedKana.value = kana;
    search.value = kana;
};
</script>
<style scoped>
.alphabet-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.alphabet-btn {
    width: 40px;
    height: 40px;
    font-weight: bold;
    text-align: center;
    border: 1px solid #333;
    border-radius: 4px;
    cursor: pointer;
}

.alphabet-btn:hover {
    background-color: #eee;
}

.kana-row {
    display: flex;
    gap: 8px;
    margin-bottom: 8px;
}

.kana-btn {
    width: 40px;
    height: 40px;
    font-weight: bold;
    text-align: center;
    border: 1px solid #333;
    border-radius: 4px;
    cursor: pointer;
}

.kana-btn:disabled {
    background-color: #f5f5f5;
    border-color: #ccc;
    cursor: default;
}

.kana-btn:hover:enabled {
    background-color: #eee;
}
</style>
