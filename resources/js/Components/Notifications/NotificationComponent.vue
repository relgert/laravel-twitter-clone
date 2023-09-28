<script setup>
import { toRefs } from 'vue';
import { router, Link} from '@inertiajs/vue3';

const props = defineProps({ notification: Object });
const { notification } = toRefs(props);

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
    <div class="card-body">
        <div class="notification-sm" @click.stop="goTo(route('tweet.show',notification.notified_tweet.id))">
            <div class="notification-header" >
                <div class="notification-icon" >
                    <i v-if="notification.source_type == 'favorite'"    class="fs-9 bi-heart-fill"></i>
                    <i v-if="notification.source_type == 'quote'"       class="fs-9 bi-repeat" style="color:rgb(0, 186, 124)"></i>
                    <i v-if="notification.source_type == 'retweet'"     class="fs-9 bi-repeat" style="color:rgb(0, 186, 124)"></i>
                    <i v-if="notification.source_type == 'reply'"     class="fs-9 bi-repeat" style="color:rgb(0, 186, 124)"></i>
                    <i v-if="notification.source_type == 'follow'"      class="fs-9 bi-person-fill" style="color:rgb(29, 155, 240)"></i>
                </div>
                <div class="notification-thumbnail" @click.stop="goTo(route('profile',notification.notifier_user.handle))">
                    <img :src="notification.notifier_user.profile_picture" alt="hugenerd" width="30" height="30" class="rounded-circle">
                </div>
            </div>
            <div>
                <div class="notification-container" style="padding-left:40px">
                    <div class="notification-title">
                        <Link @click.stop="goTo(route('profile',notification.notifier_user.handle))">
                            {{ notification.notifier_user.name }}
                        </Link>
                        <div v-if="notification.source_type == 'favorite'">Liked your post</div>
                        <div v-if="notification.source_type == 'retweet'">Retweeted your post</div>
                        <div v-if="notification.source_type == 'quote'">Quoted your post</div>
                        <div v-if="notification.source_type == 'follow'">Followed you</div>
                        <div v-if="notification.source_type == 'reply'">Replied your post</div>
                    </div>
                    <div class="notification-body" v-if="notification.source_type != 'follow'">
                        {{ notification.notified_tweet.text }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<style>
.notification-sm{
    padding-top:10px;
    cursor: pointer;
}

.notification-header{
    display: flex;
    flex-direction: row;
    padding:5px;
}
.notification-icon{
    width:30px;
    height: 30px;
    align-items: center;
    display: flex;
    justify-content: center;
    align-content: center;
    margin-right:10px;
}

.notification-thumbnail{
    cursor: pointer;
}

.notification-icon i{
    color:#F91880;
    font-size:1.3rem;
    height: 30px;
}


.notification-title{
    font-size: 0.8rem;
    display: flex;
}
.notification-title div{
    margin-left:5px;
}

.notification-title a{
    font-weight: bold;
}

.notification-sm a{
    color:black;
    text-decoration: none;
}

.notification-sm a:hover{
    text-decoration: underline;
}

.notification-body{
    color: #707070;
    padding:5px 0;
    font-size: 0.9rem;
}

</style>
