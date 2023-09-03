<!--
  Component untuk set session pada iframe yang akan dibuka
-->
<template>
  <iframe
    v-if="isCallSession"
    :src="urlForm"
    style="width: 0px; height: 0px;"
    scrolling="no"
  />
  <div
    v-if="isCallSession"
    class="spinner-container"
  >
    <div class="spinner" />
  </div>
</template>

<script>
export default {
  props: {
    urlForm: {
      type: String,
      default: ''
    },
    systemCode: {
      type: String, // hanya bisa rajal, ugd, booking, frmmedis
      default: 'rajal'
    }
  },
  emits: ['onSetSession'],
  data () {
    return {
      isCallSession: false,
    }
  },
  async mounted () {
    if (!sessionStorage[this.systemCode]) {
      // jika belum set session
      this.isCallSession = true
      
      setTimeout(() => {
        this.isCallSession = false
        sessionStorage.setItem(this.systemCode, 1)
        this.$emit('onSetSession', true)
      }, 5000)
    } else {
      setTimeout(() => {
        this.$emit('onSetSession', true)
      }, 500)
    }
  }
}
</script>