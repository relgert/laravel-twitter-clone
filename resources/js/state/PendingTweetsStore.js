import { defineStore } from "pinia";

export const usePendingTweetsStore = defineStore('pendingTweets', {
    state: () => {
        return {
            pendingTweets:[]
        }
    }
});
