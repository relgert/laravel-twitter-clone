<script setup>
import { onMounted, onBeforeUnmount, toRefs, ref } from 'vue';

const props = defineProps({ url: String,user: Object,jobs:{type:Object,default:{}} });
let {jobs , url, user } = toRefs(props);


function handleClickStartJob() {
    axios.get(url.value)
    .then((response) => {
        jobs.value.activeJob = response.data;
    })
}

onMounted(() => {
    window.Echo.private('jobs.' + user.value.id)
        .listen('.job_updates', (e) => {
            jobs.value.activeJob = e.job;
        });
});

onBeforeUnmount(() => {
    window.Echo.private('jobs.' + user.value.id).stopListening('.job_updates')
});
</script>


<template>
    <div v-if="jobs.activeJob" v-show="jobs.activeJob.status == 'Running'" class="job" style="margin-top:20px;">

        <div class="job-title">

            Simulating Activity
        </div>
        <div class="progress" style="height: 10px;" v-if="jobs.activeJob">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style="'width: ' + jobs.activeJob.percent+'%;'" :aria-valuenow="jobs.activeJob.percent" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <div class="job-subtitle">
            <div v-show="jobs.activeJob.status == 'Running'" class="spinner-border text-primary" style="width:13px;height: 13px;margin-right: 3px;" role="status"></div>
            {{ jobs.activeJob.subtitle }}
        </div>

    </div>
    <div v-show="jobs.activeJob.status == 'Done'" class="job-buttons">
        <button class="d-none d-lg-block btn btn-primary" @click="handleClickStartJob">
            <span  style="font-size:0.8rem;">Start Simulation</span>
        </button>
        <div class="d-flex d-lg-none btn-small" >
            <i class="fs-6 bi-play-circle-fill" @click="handleClickStartJob"></i>
        </div>
    </div>
</template>


<style>
.job{
    border-radius: 10px;
    background-color: rgb(240, 240, 240);
    border:1px solid #e6e6e6;
    color:#1b1b1b;
    font-size:11px;
    font-weight: bold;
    padding:3px 10px;
}

.job-title{
    margin:5px 0;
}

.job-subtitle{
    padding:5px 0;
}

.progress{
    margin:5px 0;
}

.job-buttons{

}

.job-buttons .btn-small i {
    background-color: rgb(37, 158, 0);
}

.job-buttons .btn-small i:hover {
    background-color: rgb(37, 158, 0);
    background-color: rgb(27, 114, 0);
    border-color: rgb(104, 206, 73); ;
}

.job-buttons button{
    background-color: rgb(37, 158, 0);
    border-color: rgb(34, 145, 0); ;
}

.job-buttons button:hover{
    background-color: rgb(27, 114, 0);
    border-color: rgb(104, 206, 73); ;
}

</style>
