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
    <div v-if="notification.source_type == 'favorite'" class="card-body">
        <div class="notification-sm" @click.stop="goTo(route('tweet.show',notification.notified_tweet.id))">
            <div class="notification-header" >
                <div class="notification-icon" >
                    <i class="fs-9 bi-heart-fill"></i>
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
                        Liked your post
                    </div>
                    <div class="notification-body">
                        {{ notification.notified_tweet.text }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="notification.source_type == 'retweet'" class="card-body">
        <div class="notification-sm" @click.stop="goTo(route('tweet.show',notification.notified_tweet.id))">
            <div class="notification-header" >
                <div class="notification-icon" >
                    <i class="fs-9 bi-heart-fill"></i>
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
                        Reposted your post
                    </div>
                    <div class="notification-body">
                        {{ notification.notified_tweet.text }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="notification.source_type == 'follow'" class="card-body">
        <div class="notification-sm" @click.stop="goTo(route('tweet.show',notification.notified_tweet.id))">
            <div class="notification-header" >
                <div class="notification-icon" >
                    <i class="fs-9 bi-heart-fill"></i>
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
                        Followed you
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
