<script setup>
import Trending  from '../Global/Trending.vue';
</script>
<script>
import {_} from 'vue-underscore';
import { useVirtualListStore } from '../../state/VirtualListStore';

import emitter from 'tiny-emitter/instance';


// This Virtual was taken from https://codepen.io/zupkode/pen/MWwgLyb, and added some functionalities

// https://blog.codepen.io/2016/06/08/can-adjust-infinite-loop-protection-timing/
//window.CP.PenTimer.MAX_TIME_IN_LOOP_WO_EXIT = 3000;
const PAGE_SIZE = 10;


// https://dev.to/adamklein/build-your-own-virtual-scroll-part-ii-3j86
// define a mixin object to check if the browser supports the option passive that can be used while dealing with scroll events
const PassiveSupportMixin = {
    methods: {
        // This snippet is taken straight from https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener
        // It will only work on browser so if you are using in an SSR environment, keep your eyes open
        doesBrowserSupportPassiveScroll() {
            let passiveSupported = false;

            try {
                const options = {
                    get passive() {
                        // This function will be called when the browser
                        //   attempts to access the passive property.
                        passiveSupported = true;
                        return false;
                    }
                };

                window.addEventListener("test", null, options);
                window.removeEventListener("test", null, options);
            } catch (err) {
                passiveSupported = false;
            }
            return passiveSupported;
        }
    }
};


const SearchMixin = {
    methods: {
        binarySearch(arr, x) {
            let low = 0;
            let high = Array.isArray(arr)
                ? arr.length - 1
                : Object.keys(arr).length - 1;
            let mid;
            while (low < high) {
                mid = Math.floor((high + low) / 2);
                // Check if x is present at middle position
                if (arr[mid] == x) {
                    break;
                } else if (arr[mid] > x) {
                    high = mid - 1;
                } else {
                    low = mid + 1;
                }
            }
            mid = Math.floor((high + low) / 2);
            if (x <= arr[mid]) return mid;
            else return mid + 1;
        },
        /**
        Given a scroll top value, the map containing id of the each row as key and its vertical position from the top of the viewport in px and the number of total number of items available, find the index of the first node that is just above the current scroll top value or in simple words, find the index of the item that is just not seen by the user and is above the current scroll bar position
        */
        findStartNode(scrollTop, nodePositions, itemCount) {
            let startRange = 0;
            let endRange = itemCount - 1;
            while (endRange !== startRange) {
                const middle = Math.floor((endRange - startRange) / 2 + startRange);
                if (
                    nodePositions[middle] <= scrollTop &&
                    nodePositions[middle + 1] > scrollTop
                ) {
                    return middle;
                }
                if (middle === startRange) {
                    // edge case - start and end range are consecutive
                    return endRange;
                } else {
                    if (nodePositions[middle] <= scrollTop) {
                        startRange = middle;
                    } else {
                        endRange = middle;
                    }
                }
            }
            return itemCount;
        }
    }
};



export default {
    mixins: [SearchMixin, PassiveSupportMixin],
    props: {
        paginationUrl:{type: String},
        vPendingItems:{type: Array,default: []},
        vStore:{type: Object,default: null},
        vTopItems:{type: Array,default: []},
        vName:{type: String,default:'virtual'},
        vAlwaysUpdate:{type: Boolean, default:false},
        vUpdateTypes:{type: Array,default: []},
        vUpdateConditions:{type: Function, defautl: ()=>{return true}}
    },
    data() {
        let virtualListStore = useVirtualListStore(this.paginationUrl)();
        if(this.vAlwaysUpdate){
            virtualListStore.data.isMounted = false;
            virtualListStore.data.items = [];
        }

        if(!virtualListStore.data.isMounted){
            virtualListStore.data.url = this.paginationUrl;
        }
        virtualListStore.data.showFloatingButton = false;
        return virtualListStore.data;
    },
    computed: {
        /**  If the current page is 0, take a slice of the heights of all rows from index 0 to 49
        If the current page is 1, the slice goes from index 50 to 99

          We need the total height till the end of wherever we will scroll to
          Let's say we have scrolled 2 pages down, page 0 and page 1
          Page 0 had 50 rows with a height of 2000 px
          For page 0, total height is 2000px
          Page 1 had 50 rows with a height of 2500 px
          For page 1, total height is 2000 + 2500 = 4500px and this goes on increasing with each page
          rollingPageHeights currently would contain an array [2000, 4500]
          For any scroll top less than 2000, we know that we are on page 0 now
         Now we try to find how far each row is from the top of its current page
          If page 0 has 50 rows with heights say 25 30 35 40 ...
          Row 1 of page 0 is 0 from top of page 0
          Row 2 of page 0 is 25 from top of page 0
          Row 3 of page 0 is 25 + 30 = 55 from top of page 0
          Row 4 of page 0 is 25 + 30 + 35 = 90 from top of page 0
          If page 1 has 50 rows with heights 25 30 35 40, remember that page 1 itself is 2000px from top of the viewport
          Row 0 of page 1 is 0 + 2000 from top of page 1
          Row 1 of page 1 is 25 + 2000 = 2025 from top of page 1
          Row 2 of page 1 is 25 + 30 + 2000 = 2055 from top of page 1
          Row 3 of page 1 is 25 + 30 + 35 + 2000 = 2090 from top of page 1
          We ll get a bunch of ever increasing numbers for a given page and we need to find out where the scroll top lies to identify the start index
        */
        rowPositions() {
            const currentHeights = this.heights.slice(
                this.pageStartIndex * PAGE_SIZE,
                (this.pageStartIndex + 1) * PAGE_SIZE
            );
            let totalDisplacement =
                this.rollingPageHeights[this.pageStartIndex - 1] || 0;
            let displacements = [];
            for (let i = 0; i < currentHeights.length; i++) {
                displacements.push(totalDisplacement);
                totalDisplacement += currentHeights[i];
            }
            displacements.push(totalDisplacement);
            return displacements;
        },
        /**
        Subset of list items rendered on the DOM
        */
        visibleItems() {
            return this.items.slice(this.startIndex, this.endIndex+ 3);
        },
        /**
        Translate the spacer verticaly to keep the scrollbar intact
        We only show N items at a time so the scrollbar would get affected if we dont translate
        */
        spacerStyle() {
            let t = this.translateY - 3 ;
            return {
                willChange: "auto",
                transform: "translateY(" + t + "px)"
            };
        },
        /**
        Set the height of the viewport
        For a list where all items are of equal height, height of the viewport = number of items x height of each item
        For a list where all items are of different height, it is the sum of height of each row
        */
        viewportStyle() {
            return {
                height: this.viewportHeight + "px",
                position: "relative",
                willChange: "auto"
            };
        }
    },
    methods: {
        addPendingItem(item){
            this.pendingItems.push(item);
            this.centerFloatingButton();
        },
        showPendingItems(){
            let items = this.processItems(this.vPendingItems,false);
            this.insertItems(items,false,false);
            //this.pendingItems = [];
            emitter.emit('cleanPendingItems');
        },
        myEventHandler(){
            this.centerFloatingButton();
        },
        centerFloatingButton(){
            this.$refs['floating-button'].style.left = this.$refs['vlist-container'].offsetLeft + (this.$refs['vlist-container'].clientWidth / 2) - 60 + 'px';
            this.$refs['floating-button'].style.top = this.$refs['viewport'].offsetTop + 20 + 'px';
        },
        handleUpdateItem(index){
            this.updateItemHeight(index,this.items[index].id);
        },
        handleUpdateItemProperty(index,path,data){
            this.items[index].data[path] = data;
        },
        updateItemHeight(index,id){
            if (this.$refs[id+'-'+index] && this.$refs[id+'-'+index][0]) {
                this.heights[index] = this.$refs[id+'-'+index][0].scrollHeight;
                this.updatePageHeights();
            }
        },
        init() {
            if(!this.isMounted){
                this.isMounted = true;
                this.initTopItems();
                this.callLoadMore();
            }
            this.$el.addEventListener(
                "scroll",
                this.handleScroll,
                this.doesBrowserSupportPassiveScroll() ? { passive: true } : false
            );
        },
        initTopItems(){
            let topI = this.processItems(this.vTopItems,false);
            this.insertItems(topI,false,true);



        },
        select(itemId) {
            this.selectedIndex = itemId;
            // scrollIntoViewIfNeeded(this.$el, this.childPositions[itemId]);
            // this.$el.children[item.id].scrollIntoView({ behavior: "smooth" });
        },

        scrollTo(index) {
            const pageStartIndex = Math.floor(index / PAGE_SIZE);

            const currentHeights = this.heights.slice(
                pageStartIndex * PAGE_SIZE,
                (pageStartIndex + 1) * PAGE_SIZE
            );
            let totalDisplacement = this.rollingPageHeights[pageStartIndex - 1] || 0;
            let displacements = [];
            for (let i = 0; i < currentHeights.length; i++) {
                displacements.push(totalDisplacement);
                totalDisplacement += currentHeights[i];
            }
            displacements.push(totalDisplacement);
            // console.log(pageStartIndex, this.rollingPageHeights[pageStartIndex], this.heights.slice(pageStartIndex * PAGE_SIZE, (pageStartIndex + 1) * PAGE_SIZE), displacements[index]);
            const top = displacements[index % PAGE_SIZE];
            const isVisible =
                top >= this.scrollTop && top <= this.scrollTop + this.$el.offsetHeight;
            if (!isVisible) {
                this.$el.scrollTo({
                    left: 0,
                    top: displacements[index % PAGE_SIZE],
                    behavior: "smooth"
                });
            }
        },
        update(insertedItems,insertAfter,isTop) {
            if(!insertAfter){
                insertedItems = insertedItems.reverse();
            }
            for (let i = 0; i < insertedItems.length; i++) {
                // Get the id and index of the inserted items from the array
                const { id, index } = insertedItems[i];
                // Check if the id has been rendered on DOM and is available
                if (this.$refs[id+'-'+index] && this.$refs[id+'-'+index][0]) {
                    // Get the scroll height and update the height of the item at index
                    const height = this.$refs[id+'-'+index][0].scrollHeight;

                    if(insertAfter){
                        this.heights.push(height);
                    }else{
                        if(isTop){
                            this.heights.unshift(height);
                        }else{
                            let tmp =[];
                            for(i = 0;i < this.vTopItems.length;i++){
                                tmp.unshift(this.heights.shift());
                            }
                            this.heights.unshift(height);
                            for(i = 0;i < this.vTopItems.length;i++){
                                this.heights.unshift(tmp[i]);
                            }
                        }

                    }
                    // Update the largest and smallest row heights
                    this.largestRowHeight =
                        height > this.largestRowHeight ? height : this.largestRowHeight;
                    this.smallestRowHeight =
                        height < this.smallestRowHeight ? height : this.smallestRowHeight;
                    // Given an item index, compute the page index
                    // For example, any item index from 0 to 40 would translate to page index 0
                    // Any item with index 50 to 99 would translate to page index 1
                    if(insertAfter){
                        const pageIndex = Math.floor(index / PAGE_SIZE);
                        if (pageIndex === 0) {
                            if (!this.rollingPageHeights[pageIndex]) {
                                this.rollingPageHeights[pageIndex] = 0;
                            }
                        } else {
                            if (!this.rollingPageHeights[pageIndex]) {
                                this.rollingPageHeights[pageIndex] = this.rollingPageHeights[
                                    pageIndex - 1
                                ];
                            }
                        }
                        //Add the height of the row to the total height of all rows on the current page
                        this.rollingPageHeights[pageIndex] += height;
                    }
                }
                // else {
                //    console.log(id, "was not found");
                // }
            }
            if(!insertAfter){
                this.updatePageHeights();
            }
            this.rootHeight = this.$el.offsetHeight;
            // Total height of the viewport is the sum of heights of all the rows on all the pages currently stored at the last index of page positions
            // For our example with page 0 of 2000px and page 1 of 2500px, the rollingPageHeights array looks like [2000, 4500]
            // Viewport height = 4500px
            this.viewportHeight = this.rollingPageHeights[
                this.rollingPageHeights.length - 1
            ];
        },
        updatePageHeights(){
            var newPageHeights = [];
            for (var i = 0; i < this.heights.length; i++) {
                const pageIndex = Math.floor(i / PAGE_SIZE);
                if (pageIndex === 0) {
                    if (!newPageHeights[pageIndex]) {
                        newPageHeights[pageIndex] = 0;
                    }
                } else {
                    if (!newPageHeights[pageIndex]) {
                        newPageHeights[pageIndex] = newPageHeights[
                            pageIndex - 1
                        ];
                    }
                }
                newPageHeights[pageIndex] += this.heights[i];
            }
            this.rollingPageHeights = newPageHeights;
        },
        handleScroll: _.throttle(function () {
            const { scrollTop, offsetHeight, scrollHeight } = this.$el;
            this.scrollTop = scrollTop;


            if (scrollTop + offsetHeight >= scrollHeight - 10) {
                this.callLoadMore();
            }
        }, 17),
        callLoadMore(){
            if(!this.loading){
                if (this.url === null) {
                    return
                }
                this.loading =true;
                axios
                .get(this.url)
                .then((response) => {
                    this.url = response.data.next_page_url;
                    let items = this.processItems(response.data.data,true);
                    this.insertItems(items,true,false);
                })
            }
        },
        callLoadBefore(){
            if(!this.loading){
                if (this.url === null) {
                    //return
                }
                this.loading =true;
                axios
                .get('/timeline')
                .then((response) => {
                    //this.url = response.data.next_page_url;
                    let items = this.processItems(response.data.data,false);
                    this.insertItems(items,false,false);
                })
            }
        },
        processItems(newItems,insertAfter){
            const items = [];
            const length = PAGE_SIZE;

            for (let i = 0; i < newItems.length; i++) {

                items.push({
                    id: newItems[i].id,
                    index: (insertAfter)?this.items.length + i:i,
                    data: newItems[i]
                });
                if(this.vStore){
                    this.vStore.add(newItems[i]);
                }
            }
            return items;
        },
        insertItems(insertedItems,insertAfter,isTop) {
            // Mark the loading status
            setTimeout(() => {
                // Add more dummy data
                if(insertAfter){
                    this.items.push(...insertedItems);
                }else{
                    if(isTop){
                        this.items.map((obj) => {obj.index = obj.index + insertedItems.length;})
                        this.items.unshift(...insertedItems);
                    }else{
                        let tmp = [];
                        for(var i = 0;i < this.vTopItems.length;i++){
                            tmp.unshift(this.items.shift());
                        }
                        insertedItems.map((obj) => {obj.index = obj.index + this.vTopItems.length;})
                        this.items.map((obj) => {obj.index = obj.index + insertedItems.length;})
                        this.items.unshift(...insertedItems);
                        this.items.unshift(...tmp);
                    }

                }

                // Very important to update the end index here to be the page size at this stage
                // If you are on page 0 with 50 items and loaded 50 more items, endIndex is set to 100
                // Without this step, the 50 new items on DOM are not rendered and therefore we dont get their heights

                // REMOVING this LINE will CRASH THE ENTIRE COMPONENT
                // If you have a better idea, you better comment :)
                if(!insertAfter && insertedItems.length){
                    this.scrollTo(insertedItems[0].index);
                    this.startIndex = 0;
                    this.endIndex = PAGE_SIZE + PAGE_SIZE;
                }else{
                    if(this.items.length){
                        this.endIndex =
                        Math.floor(this.items[this.items.length - 1].index / PAGE_SIZE) *
                        PAGE_SIZE +
                        PAGE_SIZE;
                    }

                }

                this.$nextTick(() => {
                    // Update the heights for the newly inserted rows
                    this.update(insertedItems,insertAfter,isTop);
                    // this.update2();
                    this.loading = false;

                });
            }, 1);
        }
    },
    watch: {
        scrollTop(newValue, oldValue) {
            this.pageStartIndex = this.binarySearch(
                this.rollingPageHeights,
                this.scrollTop
            );
            const startNodeIndex = Math.max(
                0,
                this.findStartNode(
                    this.scrollTop,
                    this.rowPositions,
                    this.rowPositions.length
                )
            );
            this.startIndex = this.pageStartIndex * PAGE_SIZE + startNodeIndex;

            this.endIndex =
                this.startIndex + Math.floor(this.rootHeight / this.smallestRowHeight);

            this.translateY = this.rowPositions[startNodeIndex];
        }
    },
    mounted() {
        this.init();
        // https://stackoverflow.com/questions/641857/javascript-window-resize-event/641874#641874
        var ro = new ResizeObserver(entries => {
            for (let entry of entries) {
                const cr = entry.contentRect;
                this.rootHeight = cr.height;
            }
        });
        ro.observe(this.$el);

        emitter.on('createdTweets', createTweet => {
            let includeItems = [];
            for(var i = 0;i < createTweet.length; i++){
                if(this.vUpdateConditions(createTweet[i])){
                    includeItems.push(createTweet[i]);
                }
            }
            if(includeItems.length){
                let items = this.processItems(includeItems,false);
                this.insertItems(items,false,false);
            }
        });



        emitter.on('addPendingItems', newItem => {
            this.addPendingItem(newItem,false);
        });

        this.centerFloatingButton();
        window.addEventListener("resize", this.myEventHandler);


    },
    beforeUnmount(){
        window.removeEventListener("resize", this.myEventHandler);
        let virtualListStore = useVirtualListStore(this.paginationUrl)();
        virtualListStore.data = this.$data;
        emitter.off('createdTweets');
        emitter.off('addPendingItems');
    },
    destroyed() {
        this.$el.removeEventListener("scroll", this.handleScroll);
        this.isMounted = false;
    },
    activated(){
        this.$el.scrollTo({
            left: 0,
            top: this.scrollTop,
        });
    }
};
</script>



<template>
    <div id="root" ref="root" class="p-0" >
        <div  style="display: flex;flex-wrap: nowrap;" >
            <div ref="vlist-container" style="min-width: 25rem;max-width: 35rem;width:100%;">
                <div class="sticky-top vlist-header">
                    <slot name="header" :updateHeader="handleUpdateItem"></slot>
                </div>

                <div class="more" ref="floating-button" @click="showPendingItems" v-show="vPendingItems.length > 0">
                    See New Posts
                </div>
                <div id="viewport" ref="viewport" :style="viewportStyle" class="vlist">
                    <div id="spacer" ref="spacer" :style="spacerStyle">
                        <div class="vlist-item fade-in-tweet" v-for="vitem in visibleItems" :key="vitem.id+'-'+vitem.index" :ref="vitem.id+'-'+vitem.index">
                            <slot name="vitemslot" v-bind:vitem="vitem.data" v-bind:vindex="vitem.index" :updateItem="handleUpdateItem" :updateItemPorperty="handleUpdateItemProperty"></slot>
                        </div>
                    </div>
                </div>
                <div style="">
                    <div v-if="loading" style="text-align: center;padding:10px 0px 100px 0px;">
                        <img src="/images/loading.gif" height="50" />
                    </div>

                    <div v-if="!url" style="text-align: center;padding:10px 0px 200px 0px;">

                    </div>

                </div>

            </div>
            <div style="min-width:200px;max-width:250px;width:100%;position:sticky;top:0px;height:100%;" class="d-none d-md-inline">

                    <Trending :scrollTop="scrollTop" ></Trending>

            </div>

        </div>

    </div>

</template>

<style>


.more{
    z-index: 100;
    position:absolute;
    color:white;
    width:120px;
    background-color: rgb(26, 140, 216);
    border-radius: 15px;
    color:white;
    font-weight: bold;
    font-size: 0.7rem;
    text-align: center;
    padding:8px 15px;
    cursor:pointer;
}
.more:hover{
    background-color: rgb(53, 162, 235);;
}


.fade-in-tweet { animation: fadeIn 0.5s; }


.vlist{
    /* border:1px solid rgb(239, 243, 244); */
}

.vlist-header{
    height:auto;
    border-bottom:1px solid rgb(209, 209, 209);
    backdrop-filter: blur(12px);
    background-color: rgba(255, 255, 255, 0.85);
    height: 53px;
    padding:10px;
    padding-top:20px;
    font-weight: bold;
}

.vlist-item {
    border:1px solid rgb(239, 243, 244);
    border-top:0px solid gray;
}

.header-back-button{
    border-radius: 20px;
}

.header-back-button i{
    padding:7px 8px;

}
.header-back-button i:hover{
    background-color: #e9e9e9;
    border-radius: 20px;
}


</style>
