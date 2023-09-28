<script setup>
import { ref, toRefs} from 'vue';
import { storeToRefs } from 'pinia';
import emitter from 'tiny-emitter/instance';
import { useNewTweetStore } from '../../../state/NewTweetStore';

const emit = defineEmits(['onSuccess','onUpdate'])

const props = defineProps({ tweet: Object,url:String,name:{type:String,default:'name'} });
const { tweet, url } = toRefs(props);


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
</script>

<template>
    <div class="tweet-post" >
        <div class="tweet-post-body">
            <img :src="tweet.user.profile_picture" alt="hugenerd" width="30" height="30" class="rounded-circle">

            <div style="width:100%;">
                <textarea ref="input" v-model="newTweet.text" placeholder="What is happening?!"
                    oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="280">
                </textarea>
                <div v-if="newTweet.media"  style="width:100%;height:100%;" class="media" >
                    <img :src="newTweet.media" />
                </div>
            </div>
        </div>
        <div class="tweet-quote-body">
            <div class="tweet-quote-header" style="display: flex;flex-direction: row;">
                <img :src="tweet.user.profile_picture" alt="hugenerd" width="30" height="30" class="rounded-circle">
                <div class="tweet-quote-username">{{ tweet.user.name }}</div>
                <div class="tweet-quote-handle">@{{ tweet.user.handle }}</div>
                <div class="tweet-quote-date"> ·
                    <timeago :datetime="tweet.created_at" :converter-options="{includeSeconds: true,addSuffix: false,useStrict: false,}" auto-update/>
                </div>
            </div>
            <div class="tweet-quote-text">{{ tweet.text }}</div>
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

.tweet-post-text{
    padding:9px;
    padding-bottom: 20px;
    color: rgba(15,20,25,1.00);
    white-space: pre-wrap;
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
.tweet-post-thread{
    display: flex;
    flex-direction: column;
    justify-content: start;
}

.graybar{
    background-color: rgb(199, 199, 199);
    width: 2px;
    height: 100%;
    margin-top:5px;
    margin-left: auto;
    margin-right: auto;
}

.tweet-post textarea:focus {
    outline: none !important;
    border: none;
    box-shadow: none;
}

.tweet-post-footer {
    display: flex;
    flex-direction: row;
    justify-items: space-between;
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
    background-color: rgba(29, 155, 240, 0.2);
}




.tweet-quote-body{
    border-radius: 20px;
    border:1px solid rgb(185, 185, 185);
    margin:25px;
    margin-top:0px;
    padding:10px;
}
.tweet-quote-body img{
    width:20px;
    height: 20px;
}



.tweet-quote-header{
    font-size:12px;
}

.tweet-quote-header div{
    margin-left:3px;
}

.tweet-quote-username{
    font-weight: bold;
}

.tweet-quote-handle{
    color:gray;
}

.tweet-quote-date{
    color:gray;
}

.tweet-quote-text{
    padding-top:10px;
    padding-left:5px;
}
</style>
