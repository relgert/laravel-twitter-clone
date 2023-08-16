<script>
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import emitter from 'tiny-emitter/instance';





export default {
    name: "Layout",
    beforeUnmount () {
        window.Echo.private('main')
        .stopListening('.test')
    },
    mounted() {

        window.Echo.private('main')
        .listen('.test', (e) => {
            console.log(e.tweet);
            this.newTweetsBufferMain.push(e.tweet);
        });

        //emitter.emit('some-event', 'arg1 valueee', 'arg2 value', 'arg3 value');
    },
    data() {
        return {
            newTweetsBufferMain: [],
        }
    }
}
</script>
<script setup>

</script>
<template>
    <div class="container-fluid ">
        <div class="row  flex-nowrap" >
            <div class="col-1  col-md-1  col-lg-3 px-0 " style="min-width:50px;">
                <div
                    class="d-flex flex-column align-items-center align-items-md-end align-items-xl-end px-3 pt-2 text-white min-vh-100 sticky-top">
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-auto "
                        id="menu">
                        <li class="nav-item">
                            <a :href="route('home')" class="nav-link align-middle px-0">
                                <i class="fs-6 bi-house"></i><span class="ms-2 fs-8 d-none d-lg-inline" style="font-size:0.8rem;">Home</span>
                            </a>
                        </li>
                        <li>
                            <a :href="route('home')" class="nav-link px-0 align-middle">
                                <i class="fs-6 bi-bell" ></i> <span class="ms-2 fs-8 d-none d-lg-inline" style="font-size:0.8rem;">Notifications</span></a>
                        </li>
                        <li>
                            <a :href="route('home')" class="nav-link px-0 align-middle">
                                <i class="fs-6 bi-envelope" ></i> <span class="ms-2 d-none d-lg-inline" style="font-size:0.8rem;">Messages</span></a>
                        </li>
                        <li>
                            <a :href="route('home')" class="nav-link px-0 align-middle">
                                <i class="fs-6 bi-person" ></i> <span class="ms-2 d-none d-lg-inline" style="font-size:0.8rem;">Profile</span></a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4" style="max-width:200px;">
                        <a href="#" class="text-decoration-none"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30"
                                class="rounded-circle">
                            <span class="mx-2 d-none d-lg-inline">UserName</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" :href="route('logout')">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <main class="col p-0" >
                <slot />
            </main>

        </div>
    </div>
</template>


<style>
body{
    font-size:14px;
}
.page-enter-active,
.page-leave-active {
    transition: all 5s;
}

.page-enter,
.page-leave-active {
    opacity: 0;
}

</style>







