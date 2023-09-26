<script>
export default {
    props: ['scrollTop'],
    data() {
        return {
            currentScroll: 0,
            height: 0,
        }
    },
    methods: {
        scroll(newValue) {
            this.$el.scrollTo({
                left: 0,
                top: newValue,
            });
        }
    },
    watch: {
        scrollTop(newValue, oldValue) {
            this.currentScroll = Math.min(Math.max(this.currentScroll + (newValue - oldValue), 0), this.height);
            this.scroll(this.currentScroll);
        }
    },
    mounted() {
        this.height = this.$refs.container.scrollHeight - window.innerHeight;
    }
}
</script>
<script setup>

</script>

<template>
    <div class="side-bar-container" ref="container" style="position:sticky;top:0px;overflow-y: hidden;height: 100vh;"
        @scroll.prevent>
        <div ref="last">
            <div class="sticky-top side-bar-top-container">
                <div class="side-bar-top" style="display:flex;">
                    <i class="fs-5 bi-search"></i>
                    <input placeholder="Search" />
                </div>
            </div>
            <div class="trending">
                <div class="trending-title">
                    Trends
                </div>
                <div class="trending-item">
                    <div class="trending-item-top">
                        1·Only on Twitter · Trending
                    </div>
                    <div class="trending-item-body">
                        María Jiménez
                    </div>
                    <div class="trending-item-bottom">
                        3,948 posts
                    </div>
                </div>
                <div class="trending-item">
                    <div class="trending-item-top">
                        1·Only on Twitter · Trending
                    </div>
                    <div class="trending-item-body">
                        María Jiménez
                    </div>
                    <div class="trending-item-bottom">
                        3,948 posts
                    </div>
                </div>
                <div class="trending-item">
                    <div class="trending-item-top">
                        1·Only on Twitter · Trending
                    </div>
                    <div class="trending-item-body">
                        María Jiménez
                    </div>
                    <div class="trending-item-bottom">
                        3,948 posts
                    </div>
                </div>
                <div class="trending-item">
                    <div class="trending-item-top">
                        1·Only on Twitter · Trending
                    </div>
                    <div class="trending-item-body">
                        María Jiménez
                    </div>
                    <div class="trending-item-bottom">
                        3,948 posts
                    </div>
                </div>
                <div class="trending-item">
                    <div class="trending-item-top">
                        1·Only on Twitter · Trending
                    </div>
                    <div class="trending-item-body">
                        María Jiménez
                    </div>
                    <div class="trending-item-bottom">
                        3,948 posts
                    </div>
                </div>
                <div class="trending-item">
                    <div class="trending-item-top">
                        1·Only on Twitter · Trending
                    </div>
                    <div class="trending-item-body">
                        María Jiménez
                    </div>
                    <div class="trending-item-bottom">
                        3,948 posts
                    </div>
                </div>
                <div class="trending-item">
                    <div class="trending-item-top">
                        1·Only on Twitter · Trending
                    </div>
                    <div class="trending-item-body">
                        María Jiménez
                    </div>
                    <div class="trending-item-bottom">
                        3,948 posts
                    </div>
                </div>
                <div class="trending-item">
                    <div class="trending-item-top">
                        1·Only on Twitter · Trending
                    </div>
                    <div class="trending-item-body">
                        María Jiménez
                    </div>
                    <div class="trending-item-bottom">
                        3,948 posts
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.side-bar-top-container{
    padding:6px;
    background-color: white;
}

.side-bar-top {
    display: flex;
    border-radius: 20px;
    background-color: #F7F9F9;
    padding: 5px 10px;
}

.side-bar-top input {
    border: none;
    background-color: inherit;
    padding-left: 10px;
    width: 90%;

}

.side-bar-top input:focus {
    outline: none !important;
    border: none;
    box-shadow: none;
}

.side-bar-container {
    margin-top: 3px;
}

.trending {
    margin-top: 20px;
    border-radius: 15px;
    background-color: #F7F9F9;
    margin:6px;
}

.trending-title{
    padding:10px 15px 0 15px;
    font-weight: bold;
    font-size: 1rem;

}

.trending-item{
    margin-top:10px;
    padding: 10px 15px;
    cursor: pointer;
}
.trending-item:hover{
    margin-top:10px;
    background-color: #e9e9e9;
}

.trending-item-top {
    font-size: 0.7rem;
    color: rgb(83, 100, 113);
}

.trending-item-body {
    font-size: 0.8rem;
    font-weight: bold;
}

.trending-item-bottom {
    font-size: 0.7rem;
    color: rgb(83, 100, 113);
}</style>
