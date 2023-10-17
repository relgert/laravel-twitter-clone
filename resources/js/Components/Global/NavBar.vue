<script setup>
import { computed, onMounted, onBeforeUnmount, ref, reactive } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import useModal from "../../state/Modal";
import TweetCreateModal from '../Tweet/Modal/TweetCreateModal.vue';
import ActiveJobs from './ActiveJobs.vue';

const page = usePage();

const user = computed(() => page.props.auth.user)
const jobs = computed(() => page.props.jobs)


const pendingNotificaitons = ref('0');

const modal = useModal();

function handleClickPost() {
    modal.open(TweetCreateModal, page.props.auth.user,
    {
        close:{
                label: "Close",
                callback: (dataFromView) => {
                    modal.close();
                },
            },
    });
}


onMounted(() => {
    pendingNotificaitons.value = user.value.pending_notifications;

    window.Echo.private('user.' + user.value.id)
        .listen('.counter_update', (e) => {
            pendingNotificaitons.value = e.user.pending_notifications;
        });
});

onBeforeUnmount(() => {
    window.Echo.private('user.' + page.props.value.auth.user.id).stopListening('.counter_update')
});
</script>


<template>
    <div class="col-1  col-md-1  col-lg-4 col-xl-4 px-0 nav-bar" style="min-width:50px;">
        <div
            class="d-flex flex-column align-items-center align-items-md-end align-items-xl-end px-3 pt-2 text-white min-vh-100 sticky-top">
            <ul class="nav nav-pills flex-column mb-sm-auto mb-auto " id="menu">
                <li class="nav-item">
                    <a :href="route('home')" :class="{ 'active-link': $page.url === '/' }" class="nav-link align-middle">
                        <i class="fs-5" :class="$page.url === '/' ? 'bi-house-door-fill' : 'bi-house-door'"></i>
                        <span class="ms-2 fs-8 d-none d-lg-inline" style="font-size:1rem;">
                            Home
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a :href="route('notifications')" class="nav-link align-middle">
                        <span class="counter" v-if="pendingNotificaitons > 0">{{ pendingNotificaitons }}</span>
                        <i class="fs-5" :class="$page.url === '/notifications' ? 'bi-bell-fill' : 'bi-bell'"></i>
                        <span class="ms-2 fs-8 d-none d-lg-inline" style="font-size:1rem;">
                            Notifications
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a :href="route('home')" class="nav-link align-middle">
                        <i class="fs-5 bi-envelope"></i> <span class="ms-2 d-none d-lg-inline"
                            style="font-size:1rem;">Messages</span></a>
                </li>
                <li class="nav-item">
                    <Link :href="route('profile',user.handle)" class="nav-link  align-middle">
                        <i class="fs-5 bi-person"></i> <span class="ms-2 d-none d-lg-inline"
                            style="font-size:1rem;">Profile</span></Link>
                </li>
                <li class="nav-item">
                    <button class="d-none d-lg-block btn btn-primary" @click="handleClickPost">
                        <span  style="font-size:1rem;">Post</span>
                    </button>
                    <div class="d-flex d-lg-none btn-small" >
                        <i class="fs-5 bi-pencil-square" @click="handleClickPost"></i>
                    </div>
                </li>
                <li class="nav-item">
                    <ActiveJobs :user="user" :jobs="jobs" :url="'/start_simulation'"></ActiveJobs>
                </li>
            </ul>

            <hr>
            <div class="dropdown pb-4" style="max-width:200px;">
                <a href="#" class="text-decoration-none" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"
                    style="display: flex;">
                    <img :src="user.profile_picture" alt="hugenerd" width="36" height="36" class="rounded-circle">
                    <div style="display:flex;flex-direction: column;font-size:0.7rem;">
                        <span class="mx-2 d-none d-lg-inline" style="font-weight:bold;color:#292929;">{{ user.name }}</span>
                        <span class="mx-2 d-none d-lg-inline"
                            style="font-size:0.7rem;color:#949292;">@{{ user.handle }}</span>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" :href="route('logout')">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>


<style>
.nav-bar a {
    color: black;
}

.nav-bar a.active-link {
    font-weight: bold;
}

.nav-link {
    border-radius: 100px !important;
}

.nav-link:hover {
    background-color: #e9e9e9;
    color: black;
}

#dropdownUser1 {

    padding-right: 0;
    border-radius: 40px;
}

.counter {
    position: absolute;
    background: rgb(29, 155, 240);
    padding: 0px 3px;
    border-radius: 10px;
    border: 2px solid white;
    color: white;
    font-weight: bold;
    margin-left: 8px;
    margin-top: -6px;
    left: auto;
    font-size: 11px;
}


.btn-small{
    display: flex;
    width:100%;
    flex-direction: row;
    justify-content: center;
}

.btn-small i{
    background-color: rgb(26, 140, 216);
    padding:4px 8px;
    border-radius: 20px;
    color:white;
    cursor: pointer;
    margin-top:10px;
}

.btn-small i:hover{
    background-color:#0b5ed7;
}

</style>
