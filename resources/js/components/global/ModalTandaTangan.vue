<template>
  <!-- modal tanda tangan jon -->
  <!-- cara pakai baca readme -->
  <ModalComp
    :showing="modal"
    :show-close="true"
    @close="closeModal"
  >
    <div class="bg-white dark:bg-gray-900 shadow rounded-lg">
      <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 dark:text-gray-300 font-medium">
          Tanda Tangan
        </h3>
      </div>
      <div v-if="setup">
        <IframeTandaTangan
          :setup="setup"
          @on-submit="onSubmit"
          @on-check-passcode="onCheckPasscode"
        />
      </div>
    </div>
  </ModalComp>
</template>

<script>
import ModalComp from './ModalComp.vue'
import IframeTandaTangan from './IframeTandaTangan.vue'

export default {
  components: {
    ModalComp,
    IframeTandaTangan
  },
  props: {
    modal: {
      type: Boolean,
      default: false
    },
    setup: {
      type: Object,
      default: () => null
    }
  },
  emits: ['closeModal', 'onSubmit', 'onCheckPasscode'],
  data () {
    return {

    }
  },
  methods: {
    closeModal () {
      this.$emit('closeModal')
    },
    onSubmit (data) {
      this.$emit('onSubmit', data)
    },
    onCheckPasscode (data) {
      this.$emit('onCheckPasscode', data)
    }
  }
}
</script>