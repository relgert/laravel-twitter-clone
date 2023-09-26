import { defineStore } from "pinia";

export const useNewTweetStore = (name) => defineStore(name, {
    state: () => {
        return {
            newTweet:{
                text:'',
                media:'',
                file:null
            }
        }
    },
    actions: {
        clear(item) {
            this.newTweet = {
                text:'',
                media:'',
                file:null
            }
        }
    },
});
