<script setup>
    import Tweet from '../Tweet/Tweet.vue';
    import { useCurrentTweetsStore } from '../../state/CurrentTweetsStore';
    import { computed, watch, ref, onMounted, toRef} from 'vue';

    const emit = defineEmits(['updateItemEvent'])
    const props = defineProps({vitem:Object,vindex:Number});

    const tweetStore = useCurrentTweetsStore();

    const tweetId = computed({
        get() { return props.vitem.id },
        set(val) { props.vitem.id = val }
    });


    const tweetInfo = computed({
        get() { return tweetStore.currentTweets[tweetId.value] },
        set(val) { tweetStore.currentTweets[tweetId.value] = val }
    });

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
        <Tweet :tweetInfo="tweetInfo"></Tweet>
    </div>
</template>
