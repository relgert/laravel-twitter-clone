import { defineStore } from "pinia";

export const useVirtualListStore = (name) => defineStore(name, {
    state: () => {
        return {
            data:{
                url: null,
                // Has the mount() been called yet atleast once?
                isMounted: false,
                // Are items currently loading as part of the infinite scroll?, handly if you got AJAX calls
                loading: false,
                // Index of the starting page, each page has PAGE_SIZE items
                pageStartIndex: 0,
                // Index of the first list item on DOM
                startIndex: 0,
                endIndex: 10,

                items: [],
                // List of all the items out of which a subset will be rendered on DOM
                pendingItems:[],
                // Height of each row
                heights: [],
                pedingItems: [],
                // Total height per page
                // On page 0 , lets say all PAGE_SIZE rows add up to 2000
                // On page 1, lets say all PAGE_SIZE rows add up to 2500, then
                // rollingPageHeights: [2000, 4500]
                // page 1 = page 0 height of PAGE_SIZE items + page 1 height of PAGE_SIZE items
                rollingPageHeights: [],
                // Height of the smallest row
                smallestRowHeight: Number.MAX_SAFE_INTEGER,
                // Height of the largest row
                largestRowHeight: Number.MIN_SAFE_INTEGER,
                // How much to shift the spacer vertically so that the scrollbar is not disturbed when hiding items
                translateY: 0,
                // Height of the outermost div inside which all the list items are present
                rootHeight: 0,
                // Total height of all the rows of all the pages
                viewportHeight: 0,
                // Current scroll position
                scrollTop: 0,
                renderAhead: 10,
                // The id of the currently selected item, by default set to 0
                selectedIndex: 0,
            }
        }
    }
});
