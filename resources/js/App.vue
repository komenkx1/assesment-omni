<template>
  <!-- ketika sudah ready, dan pakai layout admin -->
  <LayoutsAdmin v-if="ready && isLayout">
    <router-view />
  </LayoutsAdmin>

  <!-- ketika sudah ready, dan tidak pakai layout admin -->
  <div v-else-if="ready && !isLayout" class="text-sm">
    <router-view />
  </div>

  <!-- ketika belum ready, loading -->
  <template v-else-if="!ready">
    <div class="
        fixed
        top-0
        left-0
        z-30
        h-screen
        w-full
      " style="background: rgba(255, 255, 255, .5)">
      <div class="spinner-container" style="margin-top: 30%">
        <div class="spinner" />
      </div>
    </div>
  </template>

</template>

<script>
import { useToast } from 'vue-toastification'
import LayoutsAdmin from './layouts/admin.vue'
export default {
  components: {
    LayoutsAdmin
  },
  setup() {
    const toast = useToast()
    return { toast }
  },
  data() {
    return {
      ready: false,
      withoutLayout: [
        'login','register'
      ],
    }
  },
  computed: {
    currentUrl() {
      return this.$route.name
    },

    isLayout() {
      return !this.withoutLayout.includes(this.currentUrl)
    }
  },
  created() {
    axios.interceptors.request.use(
      (config) => {
        // Ambil token otentikasi dari tempat yang sesuai, localStorage atau sessionStorage
        const token = localStorage.getItem('token') || sessionStorage.getItem('token');

        // Set header Authorization dengan token bearer
        if (token) {
          config.headers.Authorization = `Bearer ${token}`;
        }

        return config;
      },
      (error) => {
        return Promise.reject(error);
      }
    );
  },
  mounted() {
    this.loadUser()
  },
  methods: {
    async loadUser() {
      this.ready = false
      try {
        const resUser = await this.$store.dispatch('getUser',1)
        if (resUser.data.status) {
          this.$store.commit('SET_AUTH_USER', resUser.data.data)
        } else {
          alert(resUser.data.message)
        }
      } catch (error) {
        const { statusCode, message } = this.$helpers.errorHandlingAxios(error)
        if (statusCode === 401) {
          //empty state user
          this.$store.commit('SET_AUTH_USER', {})
          localStorage.clear()
          sessionStorage.clear()
          this.$router.push('/login')
        }
      }
      this.ready = true
    }
  }
}
</script>