<script setup>
import { onMounted, ref, toRefs} from 'vue';
import { storeToRefs } from 'pinia';
import emitter from 'tiny-emitter/instance';
import { useNewTweetStore } from '../../../state/NewTweetStore';

const emit = defineEmits(['onSuccess','onUpdate'])

const props = defineProps({ user: Object,url:String,name:{type:String,default:'name'} });
const { user, url } = toRefs(props);

let newTweetStore = useNewTweetStore(props.name)();
const {newTweet} = storeToRefs(newTweetStore);

const input = ref(null);


function emitNewTweet(response){
    emitter.emit('createdTweets', [response]);
}

function postTweet() {
    const config = {
        onUploadProgress: function(progressEvent) {
        var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
        console.log(percentCompleted)
        }
    }

    let data = new FormData()
    data.append('text', newTweet.value.text)
    data.append('file', newTweet.value.file)


    axios.post(url.value, data,{
            headers: {'Content-Type': 'multipart/form-data'}
        })
        .then((response) => {
            emitNewTweet(response.data);
            clearForm();
            emit('onSuccess',response.data);
        })
}

function clearForm() {
    newTweetStore.clear();
    updateHeight();
}

function updateHeight() {
    input.value.style.height = ""
    input.value.style.height = '42px';
    input.value.focus();
}

const formActionMedia = ref(null);
let imageData = ref(null);
function openImage(){
    formActionMedia.value.click();
}

function onSelectFile(){
    const files = formActionMedia.value.files;
    if (files && files[0]) {
        const reader = new FileReader
        reader.onload = e => {
            newTweet.value.media = e.target.result
            newTweet.value.file = files[0]

        }
        reader.readAsDataURL(files[0])
    }
}

function updateTextAreaHeight(){
    input.value.style.height = ""
    if(newTweet.value.text.length > 0){
        input.value.style.height = input.value.scrollHeight + 'px';
    }else{
        input.value.style.height = '42px';
    }

}


onMounted(() => {
    updateTextAreaHeight();
    if(newTweet.value.text.length > 0){
        input.value.focus();
    }
});
</script>

<template>
    <div class="tweet-post" >
        <div class="tweet-post-body">
            <img :src="user.profile_picture" alt="hugenerd" width="30" height="30" class="rounded-circle">
            <div style="width:100%;">
                <textarea ref="input" v-model="newTweet.text" placeholder="What is happening?!"
                    @input="updateTextAreaHeight" maxlength="280">
                </textarea>
                <div v-if="newTweet.media"  style="width:100%;height:100%;" class="media" >
                    <img :src="newTweet.media" />
                </div>
            </div>

        </div>

        <div class="tweet-post-footer">
            <div class="tweet-post-actions">

                <i class="bi bi-image" ref="image-icon" @click="openImage"></i>
                <i class="bi bi-filetype-gif disabled"></i>
                <i class="bi bi-emoji-smile disabled"></i>
                <i class="bi bi-list-task disabled"></i>
                <i class="bi bi-calendar2-plus disabled"></i>
                <i class="bi bi-geo-alt disabled"></i>
                <input type="file" style="display:none;" accept="image/png, image/jpeg" ref="formActionMedia" @input="onSelectFile"/>
            </div>
            <button type="button" class="btn btn-primary" :disabled="newTweet.text.length == 0"
                @click="postTweet">Post</button>
        </div>
    </div>
</template>

<style>

.modal-header{
    padding:15px 10px 0px 15px;
    border: none;
}

.modal-header .btn-close{
    padding:7px !important;
    border-radius: 20px;
    font-size: 0.6rem;
}
.modal-header .btn-close:hover{
    background-color: #ccc;

}

.tweet-post {
    padding: 0px;
}

.tweet-post-body{
    display: flex;
    flex-direction: row;
    padding:10px;
}

.tweet-post textarea {
    resize: none;
    width: 100%;
    height: fit-content;
    max-height: 300px;
    border: none;
    margin-left: 10px;
    margin-top: 5px;
}

.tweet-post textarea:focus {
    outline: none !important;
    border: none;
    box-shadow: none;
}

.tweet-post-footer {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    padding:10px;
}

.tweet-post-footer .tweet-post-actions {
    color:rgb(29, 155, 240);
    cursor:pointer;
}
.tweet-post-footer .tweet-post-actions i{
    padding:7px 8px;
    border-radius: 20px;
}
.tweet-post-footer .tweet-post-actions i:hover{
    background-color: rgba(206, 196, 196, 0.2);
}

.tweet-post-actions .disabled{
    color:rgb(142, 170, 190);
}

.media img{
    border: 1px solid #ccc;
    border-radius: 15px;
    width: 100%;
}

.media{
    width: 100%;
    padding-right:10px;
}
</style>
