<template>
  <div class="text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-900">
    <!-- navbar -->
    <LayoutsNavbarAdmin
      :sidebar="isSidebar"
      :show-sidebar="showSidebar"
    />
    
    <!-- sidebar menu -->
    <LayoutsSidebarMenu
      v-if="isSidebar"
      :show-sidebar="showSidebar"
      :sidebarStyle="`separate`"
    />
    
    <div class="bg-gray-100 dark:bg-gray-900 pt-16">
      <div
        :class="`
          min-h-screen
          px-8
          pt-0
          pb-8
          ${(!isSidebar) ? '' : (showSidebar) ? 'lg:ml-80' : '' }
          transition-all
        `"
      >
        <slot />
      </div>
    </div>

    <!-- footer -->
    <div
      :class="`
      bg-brand-800 
        p-8 text-white
        ${(!isSidebar) ? '' : (showSidebar) ? 'lg:ml-80' : '' }
      `"
    >
      <div class="md:flex">
        <div class="flex">
          <img :src="``" alt="" class="h-9">
          <span class="block mt-1 mx-4 h-8 w-1 bg-white rounded-sm"></span>
          <span class="block mt-2">Dashboard</span>
        </div>
        <div class="md:flex-1 text-center md:text-right text-xs mt-4">
          Copyright 2022 Licence to Mang Wahyu
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid'
import LayoutsNavbarAdmin from './../components/layouts/LayoutsNavbarAdmin.vue'
import LayoutsSidebarMenu from './../components/layouts/LayoutsSidebarMenu.vue'
import BtnWithIcon from './../components/global/BtnWithIcon.vue'

export default {
  components: {
    ExclamationTriangleIcon,
    LayoutsNavbarAdmin,
    LayoutsSidebarMenu,
    BtnWithIcon, 
  },
  data () {
    return {
      withoutSidebar: [
        'login','register'
      ]
    }
  },
  computed: {
   
    currentUrl () {
      return this.$route.name
    },
    isSidebar () {
      return !this.withoutSidebar.includes(this.currentUrl)
    },
    showSidebar () {
      return this.$store.state.main.sidebar
    },
  }
}
</script>