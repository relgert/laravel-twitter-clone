<script setup>
import KinstaLayout from "../Layouts/KinstaLayout.vue";
import { Link } from '@inertiajs/inertia-vue3'
import Navbar from '../Components/NavBar.vue';
defineProps({
    tweets: Object,
});
</script>

<template>
    <KinstaLayout>
        <h2 class="fs-1 pt-3 sticky-top bg-light">Home</h2>
        <section class="space-y-5 border-b-2 pb-10">
            <div class="card" style="max-width: 40rem;border-bottom:0px;" v-for="tweet in tweets" :key="tweet.id">
                <div class="card-body">
                    <h5 class="card-title">{{ tweet.text }}</h5>
                    <p class="card-text">{{ tweet.text }}</p>
                </div>
                <div class="card-footer">Like Comment Retweet
                    <Link :href="route('tweet.show', tweet.id)"
                        class="text-indigo-600 hover:text-indigo-800 w-fit self-end font-semibold" preserve-scroll>Read more</Link>
                </div>
            </div>

            <!-- <article v-for="article in articles" :key="article.id"
                class="flex justify-center items-center shadow-md bg-white rounded-xl p-4 mx-auto max-w-3xl">

                <img src="/images/kinsta-logo.png" class="w-32 h-32 rounded-xl object-cover" alt="" />

                <div class="flex flex-col text-left justify-between pl-3 space-y-5">
                    <h3 class="text-xl font-semibold text-indigo-600 hover:text-indigo-800">
                        <a :href="route('article.show', article.id)">{{ article.title }}</a>
                    </h3>
                    <p>
                        {{ article.excerpt }}
                    </p>
                    <a :href="route('article.show', article.id)"
                        class="text-indigo-600 hover:text-indigo-800 w-fit self-end font-semibold">Read more</a>
                </div>
            </article> -->
        </section>
    </KinstaLayout>
</template>
