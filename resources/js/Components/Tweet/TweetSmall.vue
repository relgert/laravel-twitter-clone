<script setup>
import { router} from '@inertiajs/vue3';
import { toRefs, reactive ,toRef, computed} from 'vue';
import { useCurrentTweetsStore } from '../../state/CurrentTweetsStore';


let tweetStore = useCurrentTweetsStore();

const props = defineProps({tweetId:Number});


const { tweetId } = toRefs(props);


const tweet = computed({
  get() { return tweetStore.currentTweets[tweetId.value] },
  set(val) { tweetStore.currentTweets[tweetId.value] = val }
})




function showTweet(id){
    router.visit(route('tweet.show',id), {
        method: 'get',
        data: {},
        replace: false,
        preserveState: false,
        preserveScroll: false,
    })
}


</script>

<template>
    <div class="tweet-sm" @click.stop="showTweet(tweet.id)">
        <div style="display: flex;flex-direction: row;">
            <div class="tweet-thumbnail">
                <img :src="tweet.user.profile_picture" alt="hugenerd" width="20" height="20" class="rounded-circle">
            </div>
            <div class="tweet-container">
                <div class="tweet-header">
                    <div style="font-weight: bold;">{{ tweet.user.name }}</div>
                    <div style="color: rgb(83, 100, 113);">@{{ tweet.user.handle }}</div>
                    <div style="color: rgb(83, 100, 113);">· <timeago :datetime="tweet.created_at" :converter-options="{
        includeSeconds: true,
        addSuffix: false,
        useStrict: false,
        }"
        auto-update/></div>
                </div>
                <div class="tweet-body">
                    {{ tweet.text }}
                </div>
                <div class="tweet-media" v-if="tweet.media">
                    <img :src="tweet.media" />
                </div>
            </div>
        </div>
    </div>
</template>

<style>

.tweet-sm{
    padding:5px;
    padding-bottom:0px;
    display: flex;
    cursor:pointer;
    flex-direction: column;
}

.tweet-sm .tweet-thumbnail{
    padding-left:5px;
}

.tweet-sm .tweet-header{
    padding-top:4px;
}

</style>
