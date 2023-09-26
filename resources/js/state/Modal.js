import { markRaw } from "vue";
import { defineStore } from "pinia";
import { Modal } from 'bootstrap';


export const useModal = defineStore("modal", {
  state: () => ({
    isOpen: false,
    view: {},
    actions: [],
    baseActions: [],
    payload:{},
    modal:null
  }),
  actions: {
    open(view,payload, actions) {
        this.isOpen = true;
        this.actions = actions;
        this.payload = payload;
      // using markRaw to avoid over performance as reactive is not required
        this.view = markRaw(view);
        this.modal = new Modal('#x-modal', {});
        this.modal.show();

    },
    close() {
        this.isOpen = false;
        this.view = {};
        this.actions = [];
        this.modal.hide();
        this.modal = null;
    },
  },
});

export default useModal;
