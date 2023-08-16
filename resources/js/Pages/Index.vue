<script>
import VirtualList from '../Components/VirtualList.vue';
import TweetList  from '../Components/TweetList.vue'
import ShowComponent  from '../Components/ShowComponent.vue'
import { router } from '@inertiajs/vue3'


// router.get('/users', {
//             name: 'John Doe',
//             email: 'john.doe@example.com',
//         })

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
    },
    mounted(){
        console.log('mounted');
    },
    unmounted(){

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
                <VirtualList :paginationUrl="'/timeline'">
                    <!-- <template v-slot:header>
                        <div class="sticky-top" style="height:50px;background-color: white;border-bottom:1px solid gray;max-width: 40rem;">
                            Tweets Header
                        </div>
                    </template> -->
                    <template #tweetslot="{tweet, updateItem,updateItemPorperty}" >
                        <TweetList :tweet="tweet" @updateItemEvent="updateItem" @updateItemPropertyEvent="updateItemPorperty"></TweetList>
                    </template>
                </VirtualList>
            </KeepAlive>
        </div>
    </div>
</template>


<style>
@import "../../css/Timeline/timeline.css";
</style>

