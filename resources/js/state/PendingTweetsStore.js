import { defineStore } from "pinia";

export const usePendingTweetsStore = defineStore('pendingTweets', {
    state: () => {
        return {
            pendingTweets:[]
        }
    },
    actions: {
        add(item) {
            this.pendingTweets.push(item);
        },
        clear(){
            this.pendingTweets = [];
        }
    },
    getters: {
        items() {
            return this.pendingTweets;
        },
        length(){
            return  this.pendingTweets.length;
        }
    },
});
