<script setup>
import { onMounted } from 'vue';
import { storeToRefs } from 'pinia';
import KinstaLayout from "../Layouts/KinstaLayout.vue";
import VirtualList from '../Components/VirtualList.vue';
import TweetList  from '../Components/TweetList.vue'
import TweetListHeader  from '../Components/TweetListHeader.vue'
import { useCurrentTweetsStore } from '../state/CurrentTweetsStore';
import { usePendingTweetsStore } from '../state/PendingTweetsStore';

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
                    <template #vitemslot="{vitem,vindex, updateItem}" >
                        <TweetListHeader v-if="vindex == 0" :url="'/tweets'" :vindex="vindex"  :name="'tweet-create-index'" :user="$page.props.auth.user"  @updateItemEvent="updateItem"></TweetListHeader>
                        <TweetList  v-if="vindex > 0" :vitem="vitem" :vindex="vindex" @updateItemEvent="updateItem"></TweetList>
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

