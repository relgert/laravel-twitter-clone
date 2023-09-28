<script setup>
import { ref, toRefs, watch, toRef,reactive } from 'vue';
import TweetQuote from "../Form/TweetQuoteForm.vue";

// no need to import defineEmits
const props = defineProps(['modelValue', 'payload','actions', 'closeModal']);
const emit = defineEmits(["update:modelValue"]);

const tweet = toRef(props, 'payload');
const actions = toRef(props, 'actions');
const closeModal = toRef(props, 'closeModal');
const url = '/tweets';

function handleOnSuccess(data){
    actions.value.close.callback(data);
}
</script>

<template>
    <TweetQuote  :tweet="tweet" @onSuccess="handleOnSuccess" :url="'/tweets/'+tweet.id+'/quote'" :name="'tweet-quote-modal'"></TweetQuote>
</template>


