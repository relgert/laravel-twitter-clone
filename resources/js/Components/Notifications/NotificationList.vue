<script setup>
import { toRefs, reactive } from 'vue';
//import NotificationComponent from 'NotificationComponent';
import NotificationComponent  from './NotificationComponent.vue'

const emit = defineEmits(['updateItemEvent', 'updateItemPropertyEvent'])
const props = defineProps({ vitem: Object, vindex: Number });
const notification = reactive(props.vitem);

</script>
<template>
    <NotificationComponent :notification="notification"></NotificationComponent>
</template>
