<!-- <script setup>
import Layout from '@/Layouts/Layout.vue'
</script>

<template>
  <Layout>
    <template #title>
      ホーム画面
    </template>

    <p>本文です</p>
  </Layout>
</template> -->
<script setup>
import Layout from "@/Layouts/Layout.vue";
import InputText from "primevue/inputtext";
import { ref } from "vue";

const value = ref("");
// defineOptions({
//     layout: Layout,
// });
</script>

<template>
    <Layout>
        <template #title> ホーム画面 </template>
        <div class="border p-4 bg-gray-50">
            <InputText type="text" v-model="value" fluid/>
            <p>{{ value }}</p>
            <p>本文です</p>
        </div>
    </Layout>
</template>
