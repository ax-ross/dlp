import { defineStore } from "pinia";

export const useSidebarStore = defineStore('sidebar', {
   state: () => ({ collapsed: false, SIDEBAR_WIDTH: 180, SIDEBAR_WIDTH_COLLAPSED: 38 }),
    actions: {
       toggleSidebar() {
           this.collapsed = !this.collapsed;
       },
        getSidebarWidth() {
           return `${this.collapsed ? this.SIDEBAR_WIDTH_COLLAPSED : this.SIDEBAR_WIDTH}px`
        }
    }
});



//
// export const collapsed = { value: false};
// export const toggleSidebar = () => {collapsed.value = !collapsed.value};
//
// export const SIDEBAR_WIDTH = 180;
// export const SIDEBAR_WIDTH_COLLAPSED = 38;
// export const sidebarWidth = ''
