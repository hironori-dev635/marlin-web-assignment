<template>
    <div>
        <button @click="showModal = true">モーダル開く</button>

        <ModalTest
            v-model:show="showModal"
            v-model:modelInput="modalInput"
            title="サンプルモーダル"
        >
            <!-- <p>ここにモーダル内の内容</p> -->
            <!-- <input v-model="modalInput" placeholder="入力してね"> -->
            <!-- <p>入力値: {{ modalInput }}</p> -->
        </ModalTest>

        <p>親コンポーネントの値: {{ modalInput }}</p>
    </div>
</template>

<script setup>
import { ref } from "vue";
import ModalTest from "@/Components/ModalTest.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

defineOptions({
    layout: AppLayout,
});
const showModal = ref(false);
const modalInput = ref("");
</script>
