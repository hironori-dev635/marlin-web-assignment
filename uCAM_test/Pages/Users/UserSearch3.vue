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
            <h2>アルファベット表(AHOV)</h2>

            <div class="alphabet-row">
                <button
                    v-for="(char, index) in headChars"
                    :key="char"
                    class="alphabet-btn"
                    @click="selectChar(char, index)"
                >
                    {{ char }}
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

        <div>
            <h2>あかさたな表</h2>

            <div class="kana-row">
                <button
                    v-for="kanaHead in headKana"
                    :key="kanaHead"
                    class="kana-btn"
                    @click="selectKanaHead(kanaHead)"
                >
                    {{ kanaHead }}
                </button>
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
        <table v-if="users.length > 0" class="mt-4 border-collapse w-[500px]">
            <thead>
                <tr class="border-b">
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">名前</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="u in users" :key="u.id" class="border-b">
                    <td class="p-2">{{ u.id }}</td>
                    <td class="p-2">{{ u.name }}</td>
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
const headChars = ["A", "H", "O", "V"];

const selectedLetter = ref(null);

const selectLetter = (letter) => {
    selectedLetter.value = letter;
    search.value = letter;
    submit();
};
const selectChar = (char, index) => {
    //console.log(index);
    const row = alphabetRows[index]; // index は v-for の第2引数で取得可能
    //selectedLetter.value = row;
    search.value = row;
    submit();
};

// 表示用アイウエオ配列（空欄は null または ''）
const kanaRows = [
    ["ワ", "ラ", "ヤ", "マ", "ハ", "ナ", "タ", "サ", "カ", "ア"],
    ["", "リ", "", "ミ", "ヒ", "ニ", "チ", "シ", "キ", "イ"],
    ["ヲ", "ル", "ユ", "ム", "フ", "ヌ", "ツ", "ス", "ク", "ウ"],
    ["", "レ", "", "メ", "ヘ", "ネ", "テ", "セ", "ケ", "エ"],
    ["ン", "ロ", "ヨ", "モ", "ホ", "ノ", "ト", "ソ", "コ", "オ"],
];
const headKana = ["ア", "カ", "サ", "タ", "ナ", "ハ", "マ", "ヤ", "ラ", "ワ"];
// 検索用の列配列
// 検索用の列配列
const searchCols = {
    ア: ["ア", "イ", "ウ", "エ", "オ"],
    カ: ["カ", "キ", "ク", "ケ", "コ"],
    サ: ["サ", "シ", "ス", "セ", "ソ"],
    タ: ["タ", "チ", "ツ", "テ", "ト"],
    ナ: ["ナ", "ニ", "ヌ", "ネ", "ノ"],
    ハ: ["ハ", "ヒ", "フ", "ヘ", "ホ"],
    マ: ["マ", "ミ", "ム", "メ", "モ"],
    ヤ: ["ヤ", "ユ", "ヨ"],
    ラ: ["ラ", "リ", "ル", "レ", "ロ"],
    ワ: ["ワ", "ヲ", "ン"],
};
const selectedKana = ref(null);

const selectKana = (kana) => {
    if (!kana) return; // 空セルは無視
    selectedKana.value = kana;
    search.value = kana;
    submit();
};

const selectKanaHead = (kanaHead) => {
    console.log(searchCols[kanaHead]);
    selectedKana.value = searchCols[kanaHead];
    search.value = searchCols[kanaHead];
    submit();
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
