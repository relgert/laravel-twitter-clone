<script setup>
import { watch,onMounted,toRefs } from 'vue';
import { storeToRefs } from 'pinia';
import KinstaLayout from "../Layouts/KinstaLayout.vue";
import VirtualList from '../Components/VirtualList.vue';
import TweetList  from '../Components/TweetList.vue';
import UserInfo from "../Components/Profile/UserInfo.vue";
import { useCurrentTweetsStore } from '../state/CurrentTweetsStore';


defineOptions({ layout: KinstaLayout });

let tweetStore = useCurrentTweetsStore();

const {currentTweets} = storeToRefs(tweetStore);

const props = defineProps({ profileUser: Object });

const { profileUser } = toRefs(props);


onMounted(() => {

});
</script>

<template>
    <div id="list_detail">
        <div id="list">
            <KeepAlive>
                <VirtualList :paginationUrl="'/user/'+profileUser.id+'/tweets'" name="tweets"  :vStore="tweetStore" :vTopItems="[profileUser]">
                    <template v-slot:header>
                        <div class="sticky-top index-header">
                            <a class="header-back-button" href="#" onclick="history.back();return false;">
                                <i style="font-weight: bold;color:black;" class="fs-6 bi-arrow-left"></i>
                            </a>
                            <span style="margin-left:10px;">{{ profileUser.name }}</span>

                        </div>
                    </template>
                    <template #vitemslot="{vitem,vindex, updateItem,updateItemPorperty}" >
                        <UserInfo v-if="vindex == 0" :user="vitem" :vindex="vindex"></UserInfo>
                        <TweetList v-if="vindex > 0" :vitem="vitem" :vindex="vindex" @updateItemEvent="updateItem" @updateItemPropertyEvent="updateItemPorperty"></TweetList>
                    </template>
                </VirtualList>
            </KeepAlive>
        </div>
    </div>
</template>


<style>
@import "../../css/Timeline/timeline.css";

.index-header .modal-footer{
    padding-left:25px;
}

.index-header .modal-content{
    padding:15px;
}
</style>

