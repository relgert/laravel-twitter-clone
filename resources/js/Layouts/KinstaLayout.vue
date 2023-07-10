<script setup>
import Navbar from '../Components/NavBar.vue';
</script>

<template>
    <Navbar />
    <header
        class="bg-gradient-to-r from-red-500 via-white-700 to-gray-700 w-full text-center py-4"
    >
        <h1 class="text-white font-bold text-lg">Blog</h1>

    </header>

    <main class="container mx-auto text-center">
        <slot />
    </main>

    <footer
        class="bg-gradient-to-b from-transparent to-gray-300 w-full text-center mt-5 py-10 mx-auto"
    >
        <h2 class="font-bold text-xl p-5">Foote</h2>


    </footer>
</template>
