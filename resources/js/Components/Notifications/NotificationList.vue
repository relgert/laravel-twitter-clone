<script setup>
import { toRefs, reactive } from 'vue';
//import NotificationComponent from 'NotificationComponent';
import NotificationComponent  from './NotificationComponent.vue'

const emit = defineEmits(['updateItemEvent', 'updateItemPropertyEvent'])
const props = defineProps({ vitem: Object, vindex: Number });
const notification = reactive(props.vitem);

</script>
<template>
    <NotificationComponent v-if="notification.source_type == 'retweet'" :notification="notification"></NotificationComponent>
    <NotificationComponent v-if="notification.source_type == 'favorite'" :notification="notification"></NotificationComponent>
    <NotificationComponent v-if="notification.source_type == 'follow'" :notification="notification"></NotificationComponent>

    <NotificationComponent v-if="notification.source_type == 'reply'" :notification="notification"></NotificationComponent>
</template>
