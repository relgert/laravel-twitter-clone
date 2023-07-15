<script setup>
import KinstaLayout from "../Layouts/KinstaLayout.vue";
import { Link } from '@inertiajs/inertia-vue3'
import Navbar from '../Components/NavBar.vue';
import { Inertia } from '@inertiajs/inertia';
import { router } from '@inertiajs/inertia-vue3'
</script>
<script>
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';





//Echo.private(`tweets.${tweetId}`)


export default {
    name: "Blog",
    props: ['tweetPagination'],
    mounted() {
        const observer = new IntersectionObserver(entries => entries.forEach(entry => entry.isIntersecting && this.loadMorePosts(), {
            rootMargin: "-150px 0px 0px 0px"
        }));
        observer.observe(this.$refs.loadMoreIntersect)

        window.Pusher = Pusher;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: 'faae05baaecd5f435746',
            cluster: 'eu',
            forceTLS: true
        });

        window.Echo.private('main')
        .listen('.test', (e) => {
            this.allPosts = [e.tweet, ...this.allPosts];
        });

    },
    data() {
        return {
            allPosts: this.tweetPagination.data,
            initialUrl: this.$page.url,
            pagination: this.tweetPagination
        }
    },
    methods: {
        loadTweets(){
            this.allPosts = Inertia.restore('tweets');
        },
        loadMorePosts() {
            if (this.pagination.next_page_url === null) {
                return
            }


            axios
            .get(this.pagination.next_page_url)
            .then((response) => {
                this.allPosts = [...this.allPosts, ...response.data.data];
                this.pagination = response.data;
                //Inertia.remember(this.allPosts,'tweets');
            })




            // this.$inertia.get(this.tweetPagination.next_page_url, {}, {
            //     preserveState: true,
            //     preserveScroll: true,
            //     only: ['tweetPagination'],
            //     onSuccess: () => {
            //         this.allPosts = [...this.allPosts, ...this.tweetPagination.data];
            //         window.history.replaceState({}, this.$page.title, this.initialUrl);
            //         //Inertia.remember(this.allPosts, 'tweetFeed')
            //     }
            // })
        }
    }


}
</script>

<template>
    <KinstaLayout>
        <h2 class="fs-1 pt-3 sticky-top bg-light">Home</h2>
        <section class="space-y-5 border-b-2 pb-10">
            <div class="card" style="max-width: 40rem;border-bottom:0px;" v-for="tweet in allPosts" :key="tweet.id">
                <div class="card-body">
                    <h5 class="card-title">{{ tweet.id }} - {{ tweet.text }}</h5>
                    <p class="card-text">{{ tweet.text }}</p>
                </div>
                <div class="card-footer">
                    <a @click="loadTweets">Load</a>Like Comment Retweet
                    <Link :href="route('tweet.show', tweet.id)"
                        class="text-indigo-600 hover:text-indigo-800 w-fit self-end font-semibold">Read more
                    </Link>
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
            <span ref="loadMoreIntersect"/>
        </section>
    </KinstaLayout>
</template>
