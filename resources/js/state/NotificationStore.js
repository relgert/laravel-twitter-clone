import { defineStore } from "pinia";

export default defineStore('mainTweets', {
    state: () => {
        return {
            tweets: null,
            pendingTweets: null,
            notifications: null,
        }
    }
});
