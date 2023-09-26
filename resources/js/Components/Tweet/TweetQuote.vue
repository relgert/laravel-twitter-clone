<script setup>
import { onMounted,onBeforeUnmount,ref } from 'vue';
import { storeToRefs } from 'pinia';
import { router} from '@inertiajs/vue3';
import { toRefs, reactive ,toRef, computed} from 'vue';
import useModal from "../../state/Modal";
import TweetSmall from '../Global/TweetSmall.vue';
import TweetReplyModal from '../Global/TweetReplyModal.vue';
import TweetQuoteModal from '../Global/TweetQuoteModal.vue';
import { useCurrentTweetsStore } from '../../state/CurrentTweetsStore';


let tweetStore = useCurrentTweetsStore();


const emit = defineEmits(['onFavoriteTweet'])
const props = defineProps({tweetId:Number,isRepost:Boolean});


const { tweetId, isRepost } = toRefs(props);


const tweet = computed({
  get() { return tweetStore.currentTweets[tweetId.value] },
  set(val) { tweetStore.currentTweets[tweetId.value] = val }
})

if(tweet.value.parent_id){
    //console.log(tweet.value.parent_id)
    //tweetId = tweet.value.parent_id;
}







//const tweet = reactive(props.tweet);

const modal = useModal();

function handleClickReply() {
    modal.open(TweetReplyModal,tweet.value, {
        close:{
                label: "Close",
                callback: (dataFromView) => {
                    modal.close();
                },
            },
    });
}

function handleClickRetweet(){
    modal.open(TweetQuoteModal,tweet.value, {
        close:{
                label: "Close",
                callback: (dataFromView) => {
                    modal.close();
                },
            },
    });
}

function handleClickQuote(){
    modal.open(TweetQuoteModal,tweet.value, {
        close:{
                label: "Close",
                callback: (dataFromView) => {
                    modal.close();
                },
            },
    });
}


onMounted(() => {
    window.Echo.private('tweet_update.'+ tweet.value.id)
    .listen('.tweet_counters', (e) => {
        tweet.value.count_replies = e.tweet.count_replies;
        tweet.value.count_retweets = e.tweet.count_retweets;
        tweet.value.count_favorites = e.tweet.count_favorites;
    });
});

onBeforeUnmount(() => {
    window.Echo.private('tweet_update.'+ tweet.value.id).stopListening('.tweet_counters')
});

function favoriteTweet() {
    let url = '/favorite_tweet';
    if(tweet.value.liked_by_user){
        url = '/unfavorite_tweet';
    }
    axios.post(url, {
        tweet_id: tweet.value.id,
    })
        .then((response) => {
            tweet.value = response.data;
        })
        .catch((error) => {

        });

}


function showTweet(id){
    router.visit(route('tweet.show',id), {
        method: 'get',
        data: {},
        replace: false,
        preserveState: true,
        preserveScroll: true,
    })
}


</script>

<template>
    <div class="tweet" @click.stop="showTweet(tweet.id)">
        <div class="tweet-thumbnail">
            <img :src="tweet.user.profile_picture" alt="hugenerd" width="30" height="30" class="rounded-circle">
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
            <div class="tweet-body" >
                {{ tweet.text }}
            </div>
            <div class="tweet-body" style="border-radius: 20px;border:1px solid #ccc;margin-bottom:10px;">
                <TweetSmall  :tweetId="tweet.parent_id" :isRepost="false"></TweetSmall>
            </div>

            <div class="tweet-footer" style="font-size:14px;display:flex;justify-content:space-between;width:100%">
                <span @click.stop="handleClickReply" style="cursor:pointer;" class="blue">
                    <i class="fs-7 bi-chat"  ></i>
                    {{ tweet.count_replies }}
                </span>
                <span @click.stop="" style="cursor:pointer;" class="green" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fs-7 bi-repeat"></i>
                    {{ tweet.count_retweets }}
                    <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1">
                        <li v-if="!tweet.retweeted_by_user"><a class="dropdown-item" @click.stop="handleClickRetweet">Retweet</a></li>
                        <li v-if="!tweet.retweeted_by_user"><a class="dropdown-item" @click.stop="handleClickQuote">Quote</a></li>
                        <li v-if="tweet.retweeted_by_user"><a class="dropdown-item" @click.stop="handleClickQuote">Undo Quote</a></li>
                    </ul>
                </span>
                <span @click.stop="favoriteTweet" style="cursor:pointer;" class="red">
                    <i class="fs-9 bi-heart"  v-if="!tweet.liked_by_user"></i>
                    <i class="fs-9 bi-heart-fill" style="color:#F91880;" v-if="tweet.liked_by_user"></i>
                    {{ tweet.count_favorites }}
                </span>
                <span @click.stop=""  style="cursor:pointer;" class="blue">
                    <i class="fs-7 bi-graph-up"></i>
                </span>
                <span @click.stop="" style="cursor:pointer;" class="blue">
                    <i class="bi bi-share"></i>
                </span>

            </div>
        </div>
    </div>
</template>

<style scoped>

.tweet{
    padding:5px;
    padding-bottom:0px;
    display: flex;
    cursor:pointer;
}

.tweet:hover{
    background-color:#F7F9F9;
}

.tweet-container{
    display: flex;
    flex-direction: column;
    padding:0px 10px;
    width:100%;
}

.tweet-header{
    display: flex;
    font-size:0.7rem;
}

.tweet-body{
    font-size:0.8rem;
    padding:5px 0;
    color:rgba(15,20,25,1.00);
    white-space: pre-wrap;
}

.tweet-footer{
    color: rgb(83, 100, 113);
    font-size:0.8rem !important;
}

.tweet-footer span{
    padding:5px;
}
.tweet-footer span i{
    padding:7px 8px;
    border-radius: 25px;
}

.tweet-footer span.red:hover{
    color:rgb(228, 26, 93);
}

.tweet-footer span.red:hover i{
    background-color: rgba(255, 148, 198, 0.2);
}

.tweet-footer span.blue:hover{
    color:rgb(29, 155, 240);
}

.tweet-footer span.blue:hover i{
    background-color: rgba(29, 155, 240, 0.2);
}


.tweet-footer span.green:hover{
    color:rgb(0, 186, 124)
}

.tweet-footer span.green:hover i{
    background-color: rgba(0, 186, 124, 0.2)
}


.tweet-header div{
    padding-right:5px;
}

</style>
