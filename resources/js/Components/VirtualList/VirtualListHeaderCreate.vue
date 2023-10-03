<script setup>
    import TweetCreate from '../Tweet/Form/TweetCreateForm.vue';
    import { useCurrentTweetsStore } from '../../state/CurrentTweetsStore';
    import { computed, watch, ref, onMounted, toRef} from 'vue';

    const emit = defineEmits(['updateItemEvent'])
    const props = defineProps({user:Object,vindex:Number,url:String,name:String});

    const vitemref = ref(null);

    let height = ref(0);

    const imageContainerObserver = new ResizeObserver((entries) => {
      entries.forEach((entry) => {
            height.value = entry.contentRect.height;
      });
    });

    onMounted(() =>{
        imageContainerObserver.observe(vitemref.value);
    })

    watch(height, (count) => {
        emit('updateItemEvent',props.vindex);
    })
</script>

<template>
    <div ref="vitemref" >
        <TweetCreate :user="user" :url="url" :name="name"></TweetCreate>
    </div>
</template>
