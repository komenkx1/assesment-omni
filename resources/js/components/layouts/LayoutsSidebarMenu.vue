<template>
  <div>
    <aside :class="`
      ${showSidebar ? 'fixed' : 'hidden'}
      z-30
      top-0
      h-screen
      w-80
        bg-white
        dark:bg-gray-800
        border-r
        border-gray-200
        dark:border-gray-700
        overflow-auto
        pb-8
      `">
      <!-- logo -->
      <div class="py-4 px-8 border-b dark:border-gray-700">
        <RouterLink to="/" class="">
          <h3 class="font-bold text-lg text-center text-brand-600">Admin Panel User</h3>
        </RouterLink>
      </div>

      <!-- style default -->
      <template v-if="sidebarStyle == 'default'">
        <div class="p-4">
          <template v-for="m in menu" :key="m.id">
            <RouterLink v-if="m.children.length === 0" :to="m.link" class="
                sidebar-menu
              ">
              <component :is="m.icon" v-if="!loading" :class="'w-5 h-5'" />
              {{ m.text }}
            </RouterLink>
            <button v-else :class="`
                sidebar-menu relative w-full text-left
                ${childOpen.includes(m.id) ? 'bg-gray-100 dark:bg-gray-900' : ''}
              `" @click="toggleChild(m.id)">
              <component :is="m.icon" v-if="!loading" :class="'w-5 h-5'" />
              {{ m.text }}
              <ChevronUpIcon :class="`
                  absolute right-4 top-4
                  ${childOpen.includes(m.id) ? '' : 'rotate-180 transform'}
                  h-4 w-4 transition-all text-gray-500
                `" />
            </button>
            <!-- child open -->
            <div v-if="childOpen.includes(m.id)">
              <template v-for="m2 in m.children" :key="m2.id">
                <RouterLink :to="m2.link" :class="`
                    sidebar-menu-child
                  `">
                  {{ m2.text }}
                </RouterLink>
              </template>
            </div>
          </template>


        </div>
      </template>

      <!-- style separate -->
      <template v-if="sidebarStyle == 'separate'">
        <div class="p-4">
          <template v-for="m in menu" :key="m.id">
            <RouterLink v-if="m.children.length === 0" :to="m.link" class="
                sidebar-menu
              ">
              {{ m.text }}
            </RouterLink>

            <span v-else class="block uppercase px-2 pt-4 pb-2 font-bold text-brand-600">

              {{ m.text }}
            </span>

            <template v-for="m2 in m.children" :key="m2.id">
              <RouterLink :class="`
                  sidebar-menu relative w-full text-left flex gap-2 items-center
                `" :to="m2.link">
                <component :is="m2.icon" v-if="!loading" :class="'w-5 h-5'" />
                {{ m2.text }}
              </RouterLink>
            </template>
          </template>


        </div>
      </template>
    </aside>
    <!-- sidebar overlay -->
    <div :class="`
        ${showSidebar ? 'fixed' : 'hidden'}
        lg:hidden
        top-0
        z-20
        h-screen
        w-full
        bg-gray-900
        opacity-50
      `" @click="toggleSidebar">

    </div>
  </div>
</template>
<script>
import { ChevronUpIcon, UserCircleIcon, DocumentIcon } from '@heroicons/vue/24/outline'

export default {
  components: {
    ChevronUpIcon, UserCircleIcon, DocumentIcon
  },
  computed: {
    menu() {
      return [
        //retunrn bentuk menu data sesuai dengan kode routeLink di atas
        {
          id: 1,
          text: 'Dashboard',
          icon: 'ChevronUpIcon',
          link: '',
          children: [
            {
              id: 1,
              text: 'Manajemen User',
              icon: 'UserCircleIcon',
              link: '/',
            },
            {
              id: 2,
              text: 'Log',
              icon: 'DocumentIcon',
              link: '/log',
            },
          ]
        },

      ]
    }
  },
  props: {
    showSidebar: {
      type: Boolean,
      default: false
    },
    sidebarStyle: {
      type: String,
      default: 'default', // default, separate
    }
  },
  data() {
    return {
      childOpen: [],
      loading: false
    }
  },
  watch: {
    $route() {
      // hide sidebar jika layar < lg
      if (window.innerWidth < 1024) {
        this.$store.commit('SET_SIDEBAR', false)
        window.scrollTo(0, 0)
      }
    }
  },
  methods: {
    toggleSidebar() {
      this.$store.commit('SET_SIDEBAR', !this.showSidebar)
    },
    toggleChild(id) {
      const childOpen = [...this.childOpen]
      if (this.childOpen.includes(id)) {
        childOpen.splice(childOpen.findIndex(e => e === id), 1)
      } else {
        childOpen.push(id)
      }
      this.childOpen = childOpen
    },
  }
}
</script>