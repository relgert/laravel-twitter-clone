<script setup>
import KinstaLayout from "../Layouts/KinstaLayout.vue";
import VirtualList from '../Components/VirtualList/VirtualList.vue';
import NotificationList  from '../Components/Notifications/NotificationList.vue'

defineOptions({ layout: KinstaLayout });


</script>

<template>
    <div id="list_detail">
        <div id="list">
            <KeepAlive>
                <VirtualList :paginationUrl="'/notifications_list'">
                    <template v-slot:header>
                        <div class="sticky-top" >
                            <h6>Notifications</h6>
                        </div>
                    </template>
                    <template #vitemslot="{vitem,vindex, updateItem,updateItemPorperty}" >
                        <NotificationList :vitem="vitem" :vindex="vindex"></NotificationList>
                    </template>
                </VirtualList>
            </KeepAlive>
        </div>
    </div>
</template>
<TweetList  v-if="vindex > 0" :vitem="vitem" :vindex="vindex" @updateItemEvent="updateItem" @updateItemPropertyEvent="updateItemPorperty"></TweetList>

<style>
@import "../../css/Timeline/timeline.css";
</style>

