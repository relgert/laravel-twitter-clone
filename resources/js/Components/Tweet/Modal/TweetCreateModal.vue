<script setup>
import { ref, toRefs, watch, toRef,reactive } from 'vue';
import TweetCreateForm from "../Form/TweetCreateForm.vue";



// no need to import defineEmits
const props = defineProps(['modelValue', 'payload','actions', 'closeModal']);
const emit = defineEmits(["update:modelValue"]);
const user = toRef(props, 'payload');
const actions = toRef(props, 'actions');
const closeModal = toRef(props, 'closeModal');

const url = '/tweets';
let test = reactive({});

test.text = 'see';
test.text2 = {1:'see',2:'33'};

function handleOnSuccess(data){
    actions.value.close.callback(data);
}
</script>

<template>
    <TweetCreateForm  :user="$page.props.auth.user" :url="'/tweets'" @onSuccess="handleOnSuccess" :name="'tweet-create-modal'"></TweetCreateForm>
</template>


