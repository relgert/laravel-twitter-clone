<script setup>
import { router, Link} from '@inertiajs/vue3';
import { toRefs,  computed} from 'vue';
import TweetSmall from './TweetSmall.vue';
import TweetFooter from './TweetFooter.vue';
import { useCurrentTweetsStore } from '../../state/CurrentTweetsStore';


let tweetStore = useCurrentTweetsStore();


const emit = defineEmits(['onFavoriteTweet'])
const props = defineProps({tweetId:Number,tweetParentId:Number,tweetInfo:Object});


const { tweetInfo } = toRefs(props);

const currentTweetId = tweetInfo.value.type == 'retweet'? tweetInfo.value.parent_id:tweetInfo.value.id;


const tweet = computed({
  get() { return tweetStore.currentTweets[currentTweetId] },
  set(val) { tweetStore.currentTweets[currentTweetId] = val }
})





function goTo(url){
    router.visit(url, {
        method: 'get',
        data: {},
        replace: false,
        preserveState: false,
        preserveScroll: false,
    })
}


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
    <div class="tweet" @click.stop="showTweet(tweetInfo.id)">
        <div v-if="tweetInfo.type == 'retweet'" class="tweet-retweeted-by"><i class="fs-7 bi-repeat"></i> {{ tweetInfo.user.name }} reposted</div>
        <div class="tweet-main" style="display: flex;flex-direction: row;">
            <a class="tweet-thumbnail" @click.stop="goTo(route('profile',tweet.user.handle))">
                <img :src="tweet.user.profile_picture" alt="hugenerd" width="30" height="30" class="rounded-circle">
            </a>
            <div class="tweet-container">
                <div class="tweet-header" >
                    <a @click.stop="goTo(route('profile',tweet.user.handle))" style="font-weight: bold;">{{ tweet.user.name }}</a>
                    <a @click.stop="goTo(route('profile',tweet.user.handle))" style="color: rgb(83, 100, 113);">@{{ tweet.user.handle }}</a>
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
                <div v-if="tweet.type == 'quote'" class="tweet-quote-container">
                    <TweetSmall v-if="tweet.type == 'quote'"  :tweetId="tweet.parent_id" ></TweetSmall>
                </div>
                <TweetFooter :tweetId="tweet.id"></TweetFooter>
            </div>
        </div>
    </div>
</template>

<style>

.tweet{
    padding:10px;
    padding-bottom:0px;
    display: flex;
    cursor:pointer;
    flex-direction: column;
}


.tweet:hover{
    background-color:#F7F9F9;
}

.tweet-main{
    display: flex;
    flex-direction: row;
}

.tweet-retweeted-by{
    font-size: 11px;
    height: 10px;
    margin: 0;
    line-height: 0px;
    margin-top: -1px;
    margin-bottom:10px;
    margin-left:8px;
    font-weight: bold;
    color:gray;
}

.tweet-thumbnail{
    height: 30px;
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

.tweet-quote-container{
    font-size:0.8rem;
    padding:5px 0;
    color:rgba(15,20,25,1.00);
    white-space: pre-wrap;
    border-radius: 20px;
    border:1px solid #ccc;
    margin-bottom:10px;
    margin-top:5px;
}

.tweet-quote-container:hover{
    background-color: #ececec;
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

.tweet-header a{
    padding-right:5px;
}


.tweet a{
    text-decoration: none;
    color:inherit;
}
.tweet a:hover{
    text-decoration: underline;
}

.tweet-media{
    width: 100%;
    padding-right: 5px;
    margin-bottom: 10px;
    margin-top: 10px;
}

.tweet-media img{
    width:100%;
    border-radius: 10px;
    max-height: 900px;
}

</style>
