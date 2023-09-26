<template>
    <div class="modal fade show" id="x-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" v-if="true">
                    <button type="button" class="btn-close" @click="modal.close()" style="margin:0;padding:0;"></button>
                </div>

                <component v-if="isOpen" :is="view" v-model="model" :payload="payload" :actions="actions" ></component>

            </div>
        </div>
    </div>
</template>


<script setup>
import { reactive } from "vue";
import { storeToRefs } from "pinia";
import { useModal } from "../../state/Modal";


const modal = useModal();

// reactive container to save the payload returned by the mounted view
const model = reactive({});

// convert all state properties to reactive references to be used on view
const { isOpen, view, actions, payload } = storeToRefs(modal);
</script>

<style>

</style>
