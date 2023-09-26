import { defineStore } from "pinia";

export const useCurrentTweetsStore = defineStore('currentTweets', {
    state: () => {
        return {
            currentTweets:{}
        }
    },
    actions: {
        add(item) {
            if(item.parent){
                this.add(item.parent);
            }
            this.currentTweets[item.id] = item;
        }
    },
});
