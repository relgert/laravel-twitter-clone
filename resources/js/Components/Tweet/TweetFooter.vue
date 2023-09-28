<script setup>
import { onMounted,onBeforeUnmount} from 'vue';
import { toRefs, computed} from 'vue';
import useModal from "../../state/Modal";
import TweetReplyModal from './Modal/TweetReplyModal.vue';
import TweetQuoteModal from './Modal/TweetQuoteModal.vue';
import { useCurrentTweetsStore } from '../../state/CurrentTweetsStore';
import emitter from 'tiny-emitter/instance';

let tweetStore = useCurrentTweetsStore();

const props = defineProps({tweetId:Number});


const { tweetId } = toRefs(props);

const currentTweetId = tweetId.value;

const tweet = computed({
  get() { return tweetStore.currentTweets[currentTweetId] },
  set(val) { tweetStore.currentTweets[currentTweetId] = val }
})


//const tweet = reactive(props.tweet);

const modal = useModal();

function emitNewTweet(response){
    if(response.type == 'reply'){
        return;
    }
    emitter.emit('createdTweets', [response]);
}

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

function handleClickUndoRetweet(){

}

function handleClickUndoQuote(){

}




const retweetUrl = '/tweets/'+tweet.value.id+'/retweet';

function handleClickRetweet() {
    axios
        .post(retweetUrl, { parent_id:tweet.value.id })
        .then((response) => {
            emitNewTweet(response.data);
        })
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




</script>
<template>
    <div  class="tweet-footer" style="font-size:14px;display:flex;justify-content:space-between;width:100%">
        <span @click.stop="handleClickReply" style="cursor:pointer;" class="blue">
            <i class="fs-7 bi-chat"  ></i>
            {{ tweet.count_replies }}
        </span>
        <span @click.stop="" style="cursor:pointer;" class="green" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fs-7 bi-repeat"></i>
            {{ tweet.count_retweets }}
            <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1">
                <li v-if="!tweet.retweeted_by_user"><a class="dropdown-item" @click.stop="handleClickRetweet">Retweet</a></li>
                <!-- <li v-if="tweet.retweeted_by_user"><a class="dropdown-item" @click.stop="handleClickUndoRetweet">Undo Retweet</a></li> -->
                <li><a class="dropdown-item" @click.stop="handleClickQuote">Quote</a></li>

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
</template>
