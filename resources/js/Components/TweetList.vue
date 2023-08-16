<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { toRefs } from 'vue';

const emit = defineEmits(['updateItemEvent','updateItemPropertyEvent'])
const props = defineProps({tweet:Object});
const { tweet } = toRefs(props);


function favoriteTweet() {
    let url = '/favorite_tweet';
    if(tweet.value.data.liked_by_user){
        url = '/unfavorite_tweet';
    }
    axios.post(url, {
        tweet_id: tweet.value.id,
    })
        .then((response) => {
            emit('updateItemEvent',tweet.value.index,response.data)
            //emit('updateItemPropertyEvent',tweet.value.index,'count_favorites',response.data.count_favorites)
        })
        .catch((error) => {
            console.log(error);
        });

}


</script>

<template>

    <div class="card-body">
        <div>{{ tweet.id }} - {{ tweet.data.text }}</div>
        <!-- <video controls autoplay muted style="max-width: 90%;width:90%;display: block;
  margin-left: auto;
  margin-right: auto;">
            <source src="http://thinkingform.com/wp-content/uploads/2017/09/video-sample-mp4.mp4?_=1" type="video/mp4">
        </video> -->
        <!-- <img style="border-radius: 10px; max-width: 90%;display: block;
  margin-left: auto;
  margin-right: auto;" src="https://assets.entrepreneur.com/content/3x2/2000/20150312184504-cool-awesome.jpeg" /> -->
    </div>
    <div class="card-footer" style="font-size:14px;display:flex;justify-content:space-around;width:100%">


        <span  style="cursor:pointer;">
            <i class="fs-7 bi-chat"  ></i>
            {{ tweet.data.count_replies }}
        </span>
        <span  style="cursor:pointer;">
            <i class="fs-7 bi-repeat"></i>
            {{ tweet.data.count_retweets }}
        </span>
        <span @click="favoriteTweet" style="cursor:pointer;">
            <i class="fs-9 bi-heart"  v-if="!tweet.data.liked_by_user"></i>
            <i class="fs-9 bi-heart-fill" style="color:#F91880;" v-if="tweet.data.liked_by_user"></i>
            {{ tweet.data.count_favorites }}
        </span>
        <span  style="cursor:pointer;">
            <i class="fs-7 bi-graph-up"></i>
            {{ tweet.data.count_retweets }}
        </span>

    </div>
</template>

<style></style>
