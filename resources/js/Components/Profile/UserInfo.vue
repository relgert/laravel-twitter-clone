<script setup>
import { ref,toRef, toRefs,reactive} from 'vue';

const emit = defineEmits(['onSuccess'])

const props = defineProps({ user: Object });

let user = toRef(props.user);

const followText = ref('Following');

function handleClickFollow() {
    let url = '/users/'+user.value.id+'/follow';
    if(user.value.followed_by_user){
        url = '/users/'+user.value.id+'/unfollow';
    }
    axios.post(url,{id:user.value.id})
        .then((response) => {
            user.value = response.data;
        })
        .catch((error) => {

        });
}




</script>

<template>
    <div class="profile">
        <div class="profile-container">
            <div class="profile-background" v-bind:style="{ 'background-image': 'url(' + user.profile_background + ')' }">

            </div>
            <div class="profile-main">
                <div class="profile-thumbnail">
                    <img :src="user.profile_picture" alt="hugenerd" width="100" height="100" class="rounded-circle">
                </div>
                <div class="profile-actions" v-if="user.id != $page.props.auth.user.id">
                    <div v-if="user.followed_by_user" class="btn-unfollow" @click="handleClickFollow" @mouseleave="followText = 'Following'" @mouseover="followText = 'Unfollow'">{{followText}}</div>
                    <div v-if="!user.followed_by_user" class="btn-follow" @click="handleClickFollow">Follow</div>
                </div>
            </div>
            <div class="profile-name">
                <div class="profile-username">{{ user.name }}</div>
                <div class="profile-handle">@{{ user.handle }}</div>
            </div>
            <div class="profile-bio">
                {{ user.profile_bio }}
            </div>
            <div class="profile-stats" >
                <span class="stat-number">{{ user.following_count }}</span> Following
                <span class="stat-number">{{ user.followers_count }}</span> Followers
            </div>
            <div class="profile-sections">
                <div>Posts</div>
                <div>Replies</div>
                <div>Highlights</div>
                <div>Media</div>
            </div>
        </div>
    </div>
</template>

<style>
.profile{
    width:100%;
}
.profile-container{
    display: flex;
    flex-direction: column;
    width:100%;
}

.profile-background{
    background-size: cover;
    width:100%;
    min-height: 50px;
    max-height: 150px;
    height:150px;
    background-position: center;
}

.profile-main{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.profile-thumbnail{
    margin-top:-50px;
    margin-left:20px;
}
.profile-thumbnail img{
    border:3px solid #ffffff;
}

.profile-actions{
    padding:10px 17px;
}

.profile-actions div{
    font-weight: bold;
    border-radius: 20px;
    border: 1px solid rgb(219, 219, 219);
    padding: 6px 12px;
    cursor: pointer;
}

.profile-name{
    padding-left: 10px;
}

.profile-username{
    font-size: 18px;
    font-weight: bold;
}
.profile-handle{
    color:#a3a3a3;
}

.profile-bio{
    padding:10px;
    font-size: 12px;
}

.profile-stats{
    font-size:14px;
    padding:10px 0 20px 0;
    color:#272727;
}

.profile-stats .stat-number{
    margin-left:10px;
    font-size:14px;
    font-weight: bold;
    color:black;
}

.profile-sections{
    display: flex;
    flex-direction: row;
    justify-content: space-around;
}

.profile-sections div{
    padding:20px 20px 5px 20px;
    cursor: pointer;
    width:100%;
    text-align: center;
    color: rgb(83, 100, 113);
}
.profile-sections div:hover{
    background-color: #e9e9e9;
}

.profile-sections div:first-child{
    font-weight: bold;
    color: rgb(38, 42, 46);
}

.btn-follow{
    background-color: black;
    color:white;
}

.btn-unfollow:hover{
    background-color: rgb(255, 210, 210);
    color: rgb(255, 36, 36);
    border-color: rgb(255, 135, 135);
}
</style>
