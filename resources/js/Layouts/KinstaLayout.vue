<script setup>
import { computed,onMounted,onBeforeUnmount,ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { usePendingTweetsStore } from '../state/PendingTweetsStore';
import emitter from 'tiny-emitter/instance';
import XModal from '../Components/Global/x-modal.vue'





const page = usePage();
const user = computed(() => page.props.auth.user);

onMounted(() => {
    let pendingTweetsStore = usePendingTweetsStore();
    window.Echo.private('user.'+ user.value.id)
        .listen('.new_tweet', (e) => {
            pendingTweetsStore.pendingTweets.push(e.tweet);
            //emitter.emit('addPendingItems', e.tweet);
        });


});

onBeforeUnmount(() => {
    window.Echo.private('user.'+ user.value.id).stopListening('.counter_update')
});


</script>






<template>
    <div class="container-fluid ">
        <div class="row">

            <NavBar></NavBar>
            <main class="col p-0">
                <slot />
                <x-modal />
            </main>

        </div>
    </div>
</template>


<style>
body {
    font-size: 14px;
}

.page-enter-active,
.page-leave-active {
    transition: all 5s;
}

.page-enter,
.page-leave-active {
    opacity: 0;
}




.modal-body {
    display: flex;
}

.btn-primary {
    border-radius: 35px;
    background-color: rgb(26, 140, 216);
    text-align: center;
    color: white;
    font-weight: bold;
    padding: 5px 15px;
    font-size: 0.8rem;
}

#menu .btn-primary {
    border-radius: 35px;
    margin-top: 10px;
    width: 100%;
}
</style>







