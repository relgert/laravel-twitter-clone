<script setup>
import KinstaLayout from "../Layouts/KinstaLayout.vue";
import { Link, $router } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

</script>
<script>



export default {
    layout: KinstaLayout,
    name: "Blog",
    props: ['tweetPagination'],
    beforeUnmount() {


    },
    mounted() {
        const observer = new IntersectionObserver(entries => entries.forEach(entry => entry.isIntersecting && this.loadMorePosts(), {
            rootMargin: "-150px 0px 0px 0px"
        }));
        observer.observe(this.$refs.loadMoreIntersect)
    },
    data() {
        let lpagination = [];
        let ltweets = [];
        let lnewTweetsBuffer = [];
        let savedData = this.$inertia.restore('tweetFeed');
        //this.$inertia.remember(null,'tweetFeed');
        if(savedData){
            console.log('saved');
            savedData = JSON.parse(savedData);
            lpagination = savedData.p;
            ltweets = savedData.t;
            lnewTweetsBuffer = savedData.n;
        }else{
            console.log('new');
            lpagination = Object.assign(lpagination,this.tweetPagination);;
            ltweets = Object.assign(ltweets,this.tweetPagination.data);
        }

        return {
            initialUrl: this.$page.url,
            pagination: lpagination,
            tweets: ltweets,
            //newTweetsBuffer:lnewTweetsBuffer,
        }
    },
    methods: {
        getParent(name) {
            let p = this.$parent;
            while(typeof p !== 'undefined') {
                if (p.$options.name == name) {
                    return p;
                } else {
                    p = p.$parent;
                }
            }
            return false;
        },
        loadTweets(){
            // this.tweets = [...this.newTweetsBuffer, ...this.tweets];
            // this.newTweetsBuffer = [];
            // window.scrollTo(0,0);
        },
        loadMorePosts() {
            if (this.pagination.next_page_url === null) {
                return
            }


            // axios
            // .get(this.pagination.next_page_url)
            // .then((response) => {

            //     let newTweets = response.data.data;
            //     this.pagination = response.data;
            //     this.tweets = [...this.tweets, ...newTweets];
            //     this.$inertia.remember(JSON.stringify({t:this.tweets,p:this.pagination}),'tweetFeed');

            // })




            this.$inertia.get(this.tweetPagination.next_page_url, {}, {
                preserveState: true,
                preserveScroll: true,
                only: ['tweetPagination'],
                onSuccess: () => {
                    //window.history.replaceState({}, this.$page.title, this.initialUrl);
                    this.tweets = [...this.tweets, ...this.tweetPagination.data];
                    this.tweetPagination.data = Object.assign(this.tweetPagination.data,this.tweets);
                }
            })
        }
    }
}



</script>

<template>
        <h2 class="fs-1 pt-3 sticky-top bg-light">Home</h2>

        <section class="space-y-5 border-b-2 pb-10">
            <div id="list_detail">
                <div id="list">
                    <VirtualList></VirtualList>
                </div>
            </div>
            <div class="card" style="max-width: 40rem;border-bottom:0px;" v-for="tweet in tweets" :key="tweet.id">
                <div class="card-body">
                    <h5 class="card-title">{{ tweet.id }} - {{ tweet.text }}</h5>
                    <p class="card-text">{{ tweet.text }}</p>
                </div>
                <div class="card-footer">
                    <a  > 0" @click="loadTweets2">Load</a>Like Comment Retweet
                    <Link :href="route('tweet.show', tweet.id)"
                        class="text-indigo-600 hover:text-indigo-800 w-fit self-end font-semibold">Read more
                    </Link>
                </div>
            </div>
            <span ref="loadMoreIntersect"/>
        </section>
</template>
