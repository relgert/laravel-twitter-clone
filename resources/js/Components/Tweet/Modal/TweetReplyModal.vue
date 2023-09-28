<script setup>
import { ref, toRefs, watch, toRef,reactive } from 'vue';
import TweetReply from "../Form/TweetReplyForm.vue";

// no need to import defineEmits
const props = defineProps(['modelValue', 'payload','actions', 'closeModal']);
const emit = defineEmits(["update:modelValue"]);

const tweet = toRef(props, 'payload');
const actions = toRef(props, 'actions');

function handleOnSuccess(data){
    actions.value.close.callback(data);
}
</script>

<template>
    <TweetReply  :tweet="tweet" @onSuccess="handleOnSuccess" :url="'/tweets/'+tweet.id+'/reply'" :name="'tweet-reply-modal'"></TweetReply>
</template>


