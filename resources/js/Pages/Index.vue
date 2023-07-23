<script>
import VirtualList from '../Components/VirtualList.vue';
import TweetList  from '../Components/TweetList.vue'

export default {
    layout: KinstaLayout,
    name: "Timeline",
    methods: {
        loadMorePosts() {
            // this.$inertia.get(this.tweetPagination.next_page_url, {}, {
            //     preserveState: true,
            //     preserveScroll: true,
            //     only: ['tweetPagination'],
            //     onSuccess: () => {
            //         //window.history.replaceState({}, this.$page.title, this.initialUrl);
            //         this.tweets = [...this.tweets, ...this.tweetPagination.data];
            //         this.tweetPagination.data = Object.assign(this.tweetPagination.data,this.tweets);
            //     }
            // })
        }
    }
}



</script>
<script setup>
import KinstaLayout from "../Layouts/KinstaLayout.vue";
</script>

<template>
    <div id="list_detail">
        <div id="list">
            <KeepAlive>
                <VirtualList :paginationUrl="'/timeline?page=2'">
                    <!-- <template v-slot:header>
                        <div class="sticky-top" style="height:50px;background-color: white;border-bottom:1px solid gray;max-width: 40rem;">
                            Tweets Header
                        </div>
                    </template> -->
                    <template #tweet="tweet" v-slot:tweet>
                        <TweetList :tweet="tweet"></TweetList>
                    </template>
                </VirtualList>
            </KeepAlive>
        </div>
    </div>
</template>


<style>
@import "../../css/Timeline/timeline.css";
</style>

