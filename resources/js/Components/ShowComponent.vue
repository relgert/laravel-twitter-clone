<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div id="root" ref="root">
        <Link :href="route('home')"
            class="text-indigo-600 hover:text-indigo-800 w-fit self-end font-semibold" preserve-state preserve-scroll>Back
        </Link>
        <h1>test</h1>
    </div>
</template>
