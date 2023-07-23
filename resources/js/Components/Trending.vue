<script>
export default {
    props: ['scrollTop'],
    data() {
        return {
            currentScroll:0,
            height:0,
        }
    },
    methods: {
        scroll(newValue){
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
        this.height = this.$refs.container.scrollHeight - window. innerHeight;
        console.log(this.$refs.container.scrollHeight);
        console.log(window. innerHeight);
    }
}
</script>
<script setup>

</script>

<template>
    <div class="trending" ref="container" style="background-color: red;position:sticky;top:0px;overflow-y: hidden;height: 100vh;"
 @scroll.prevent>
        <div style=" background-color: blue;" ref="last">
            <div class="sticky-top" style="background-color: red;" >
                <div class="card-body"> Text</div>
                <div class="card-footer">
                    Like Comment Retweet
                </div>
            </div>
            <div class="card">
                <div class="card-body"> Text</div>
                <div class="card-footer">
                    Like Comment Retweet
                </div>
            </div>
            <div class="card">
                <div class="card-body"> Text</div>
                <div class="card-footer">
                    Like Comment Retweet
                </div>
            </div>
            <div class="card">
                <div class="card-body"> Text</div>
                <div class="card-footer">
                    Like Comment Retweet
                </div>
            </div>
            <div class="card">
                <div class="card-body"> Text</div>
                <div class="card-footer">
                    Like Comment Retweet
                </div>
            </div>
            <div class="card">
                <div class="card-body"> Text</div>
                <div class="card-footer">
                    Like Comment Retweet
                </div>
            </div>
            <div class="card">
                <div class="card-body"> Text</div>
                <div class="card-footer">
                    Like Comment Retweet
                </div>
            </div>
            <div class="card">
                <div class="card-body"> Text</div>
                <div class="card-footer">
                    Like Comment Retweet
                </div>
            </div>
            <div class="card">
                <div class="card-body"> Text</div>
                <div class="card-footer">
                    Like Comment Retweet
                </div>
            </div>
            <div class="card">
                <div class="card-body"> Text</div>
                <div class="card-footer">
                    Like Comment Retweet
                </div>
            </div>
            <div class="card">
                <div class="card-body"> Text</div>
                <div class="card-footer">
                    Like Comment Retweet
                </div>
            </div>
            <div style="background-color: red;" >Last</div>
        </div>
    </div>
</template>
