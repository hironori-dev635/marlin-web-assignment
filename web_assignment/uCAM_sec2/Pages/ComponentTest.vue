<script setup>
import { ref } from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const form = ref({
  title: '',
})
</script>
<template>
<GuestLayout>
<InputLabel value="件名">taitle</InputLabel>
<TextInput v-model="form.title" />
</GuestLayout>
</template>