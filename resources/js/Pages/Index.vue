<script setup>
import { watch,onMounted,toRef } from 'vue';
import { storeToRefs } from 'pinia';
import KinstaLayout from "../Layouts/KinstaLayout.vue";
import VirtualList from '../Components/VirtualList.vue';
import TweetList  from '../Components/TweetList.vue'
import TweetCreate from "../Components/Tweet/Form/TweetCreateForm.vue";
import { useCurrentTweetsStore } from '../state/CurrentTweetsStore';
import { usePendingTweetsStore } from '../state/PendingTweetsStore';
import emitter from 'tiny-emitter/instance';

defineOptions({ layout: KinstaLayout });

let tweetStore = useCurrentTweetsStore();

const {currentTweets} = storeToRefs(tweetStore);

let pendingTweetStore = usePendingTweetsStore();

const {pendingTweets} = storeToRefs(pendingTweetStore);


onMounted(() => {

});
</script>

<template>
    <div id="list_detail">
        <div id="list">
            <KeepAlive>
                <VirtualList :paginationUrl="'/timeline'" name="tweets" :vName="'timeline'" :vPendingItems="pendingTweets" :vStore="tweetStore" :vTopItems="[$page.props.auth.user]">
                    <template v-slot:header>
                        <div class="sticky-top index-header">
                            HOME
                        </div>
                    </template>
                    <template #vitemslot="{vitem,vindex, updateItem,updateItemPorperty}" >
                        <TweetCreate v-if="vindex == 0" :url="'/tweets'"  :user="$page.props.auth.user" :name="'tweet-create-index'"></TweetCreate>
                        <TweetList  v-if="vindex > 0" :vitem="vitem" :vindex="vindex" @updateItemEvent="updateItem" @updateItemPropertyEvent="updateItemPorperty"></TweetList>
                    </template>
                </VirtualList>
            </KeepAlive>
        </div>
    </div>
</template>


<style>
@import "../../css/Timeline/timeline.css";

.index-header .modal-footer{
    padding-left:25px;
}

.index-header .modal-content{
    padding:15px;
}
</style>

