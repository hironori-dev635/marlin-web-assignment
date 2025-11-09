<script setup>
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3'
const page = usePage()
defineProps({
    blogs: Array
})

</script>
<template>
  <div v-if="page.props.flash?.success" class="bg-blue-200">
    {{ page.props.flash.success }}
  </div>
  <ul>
    <li v-for="blog in blogs" :key="blog.id">
        件名：<Link class="text-blue-400" :href="route('inertia.show',{ id: blog.id })">{{ blog.title }}</Link>,本文：{{ blog.content }}
    </li>

    
  </ul>

</template>