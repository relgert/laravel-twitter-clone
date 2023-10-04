<script setup>
import { router} from '@inertiajs/vue3';
import { toRefs } from 'vue';
import KinstaLayout from "../Layouts/KinstaLayout.vue";
import VirtualList from '../Components/VirtualList/VirtualList.vue';
import VirtualListHeaderShow  from '../Components/VirtualList/VirtualListHeaderShow.vue';
import VitualListItemTweet  from '../Components/VirtualList/VitualListItemTweet.vue';
import Tweet from '../Components/Tweet/Tweet.vue';
import { useCurrentTweetsStore } from '../state/CurrentTweetsStore';

defineOptions({ layout: KinstaLayout });

const props = defineProps({tweet: Object});

const { tweet } = toRefs(props);

const pagintation_url = tweet.value.type == 'retweet'?tweet.value.parent_id:tweet.value.id;

let tweetStore = useCurrentTweetsStore();
tweetStore.currentTweets[tweet.value.id] = tweet.value;

let currentTweet = tweetStore.currentTweets[tweet.value.id];

function handleBack(){
    if(history.length > 2){
        history.back();return;
    }else{
        router.visit(route('home'), {
            method: 'get',
            data: {},
            replace: false,
            preserveState: false,
            preserveScroll: false,
        })
    }
}

function vListIncludeConditions(vListItem){
    if(vListItem.type == 'reply' && vListItem.parent_id == tweet.value.id){
        return true;
    }
    return false;
}
</script>

<template>

    <div id="list_detail">
        <div id="list">
            <KeepAlive>
                <VirtualList :paginationUrl="'/tweets/'+pagintation_url+'/replies'" name="tweets" :vAlwaysUpdate="true"  :vStore="tweetStore" :vTopItems="[tweet]"  :vUpdateConditions="vListIncludeConditions">
                    <template v-slot:header>
                        <div class="sticky-top index-header">
                            <a class="header-back-button"  @click.stop="handleBack">
                                <i style="font-weight: bold;color:black;" class="fs-6 bi-arrow-left"></i>
                            </a>
                            <span style="margin-left:10px;">{{ tweet.user.name }}</span>
                        </div>
                    </template>
                    <template #vitemslot="{vitem,vindex, updateItem,updateItemPorperty}" >
                        <VirtualListHeaderShow v-if="vindex == 0" :url="'/tweets/'+tweet.id+'/reply'" :vindex="vindex" :tweet="tweet"  :name="'tweet-create-index'" :user="$page.props.auth.user"  @updateItemEvent="updateItem"></VirtualListHeaderShow>
                        <VitualListItemTweet  v-if="vindex > 0" :vitem="vitem" :vindex="vindex" @updateItemEvent="updateItem"></VitualListItemTweet>
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

