<script setup>
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
    tweet: Object,
});
</script>

<template>
    <div class="card-body">
        <div>{{ tweet.id }} - {{ tweet.value.text }}</div>
        <!-- <video controls autoplay muted style="max-width: 90%;width:90%;display: block;
  margin-left: auto;
  margin-right: auto;">
            <source src="http://thinkingform.com/wp-content/uploads/2017/09/video-sample-mp4.mp4?_=1" type="video/mp4">
        </video> -->
        <img style="border-radius: 10px; max-width: 90%;display: block;
  margin-left: auto;
  margin-right: auto;" src="https://assets.entrepreneur.com/content/3x2/2000/20150312184504-cool-awesome.jpeg" />
    </div>
    <div class="card-footer">
        Like Comment Retweet
        <Link :href="route('tweet.show', tweet.id )"
            class="text-indigo-600 hover:text-indigo-800 w-fit self-end font-semibold" preserve-state preserve-scroll>Read more
        </Link>
    </div>
</template>

<style>

</style>
