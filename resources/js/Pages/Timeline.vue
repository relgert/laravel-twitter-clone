<script setup>
import { shallowRef,watch } from 'vue'
import KinstaLayout from "../Layouts/KinstaLayout.vue";
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import VirtualList from '../Components/VirtualList.vue';
import ShowComponent from '../Components/ShowComponent.vue';
import { createWebHistory, createRouter } from "vue-router";

let activeComponent = shallowRef(VirtualList)



const routes = [
  {
    path: "/timeline",
    name: "Timeline",
    component: VirtualList,
  },
  {
    path: "/tweet/:id",
    name: "Tweet",
    component: ShowComponent,
  },
];
const router = createRouter({
  history: createWebHistory('localhost'),
  routes,
});

function change(){
    if(this.activeComponent == ShowComponent){
        this.activeComponent = VirtualList;
        this.router.push('/timeline');
    }else{
        this.activeComponent = ShowComponent;
        this.router.push('/tweet/1');
    }

}


// watch(router.currentRoute, (data,data2) => {
//     console.log(data);
//     console.log(data2);
//     return true;
//    // Do something with the updated value.
// });
</script>
<script>
    import emitter from 'tiny-emitter/instance';


    emitter.on('some-event', function (arg1, arg2, arg3) {
        console.log(arg1);

    });
</script>




<template>
        <div id="list_detail">
            <div id="list">
                <KeepAlive>
                    <component :is="activeComponent"></component>
                </KeepAlive>
            </div>
        </div>
</template>







