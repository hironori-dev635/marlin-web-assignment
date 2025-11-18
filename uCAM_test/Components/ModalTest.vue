<template>
    <div v-if="show" class="modal-backdrop">
        <div class="modal-content">
            <h2>{{ title }}</h2>
            <!-- フォーム -->
            <form @submit.prevent="setInput" class="mb-4 flex h-12">
                <!-- <input v-model="form.name" placeholder="名前" class="border p-1" /> -->
                <input
                    type="text"
                    v-model="localInput"
                    class="border p-1 mr-2"
                /><br />

                <button type="submit" class="bg-blue-500 text-white px-2">
                    入力
                </button>
            </form>
            <button @click="closeModal">閉じる</button>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    show: Boolean, // 親から表示制御
    title: String, // モーダルタイトル
    modalInput: String, // v-model:modelInput で受け取る
});

const localInput = ref("");



const emit = defineEmits(["update:show", "update:modelInput"]);// 双方向バインディング用に定義


const setInput = () => {
    emit("update:modelInput", localInput.value); // 親のmodelInputにlocalInputの値を渡す
    emit("update:show", false); // 親のshowModalにfalseを渡す
    localInput.value = ""; // 入力値をリセット
};


const closeModal = () => {
    emit("update:show", false); //親のshowModalにfalseを渡す
    localInput.value = ""; // 入力値をリセット
};
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}
.modal-content {
    background: white;
    padding: 1rem;
    border-radius: 8px;
}
</style>
