import { defineStore } from "pinia";

export const useNotificationStore = defineStore('Notifications', {
    state: () => {
        return {
            Notifications:{},
        }
    }
});
