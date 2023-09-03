<template>
    <div class="text-center">
      <p class="text-center font-medium">
        {{ textHeader }}
      </p>
      <img
        v-if="form[formStatus]"
        :src="`${urlSistemBerkas}/${form[formFileTtd]}`"
        class="inline h-24"
      >
      <div
        v-if="!form[formStatus]"
        class="py-10 text-gray-500 text-xs text-center "
      >
        Belum ditandatangani
      </div>
      <input
        v-if="formType == 'text'"
        v-model="form[formEntitas]"
        type="text"
        class="t-form"
        :disabled="disabledForm || form[formStatus] === 1"
      >
      <v-select
        v-if="formType == 'select'"
        v-model="form[formEntitas]"
        :options="widget"
        :label="widgetLabel"
        :clearable="false"
        :disabled="disabledForm || form[formStatus] === 1"
      />
      <div class="h-1" />
      <BtnWithIcon
        type="button"
        color="brand"
        title="Tanda Tangani"
        icon="CheckBadgeIcon"
        add-class=" w-full "
        @handle-click="showModalTandaTangan"
      >
        Tanda Tangani
      </BtnWithIcon>
    </div>
  </template>
  
  <script>
  import { mapState } from 'vuex'
  
  export default {
    props: {
      textHeader: { type: String, default: () => '' },
      disabledForm: { type: Boolean, default: () => false },
      form: { type: Object, default: () => {} },
  
      /**
       * type, text/select
       * widget, widget (jika form select)
       * widget_label, label widget (jika frm select)
       * model_status, model tempat simpan status ttd
       * model_file_ttd, model tempat simpan file ttd
       * model_entitas, model tempat simpan id entitas
       */
      formSetting: { type: Object, default: () => {} }
  
    },
    emits: ['showModalTandaTangan'],
    computed: {
      ...mapState({
        urlSistemBerkas: s => s.setupUnit.setupUnit.url_berkas
      }),
      formType () {
        return this.formSetting?.type || 'text'
      },
      formStatus () {
        return this.formSetting?.model_status || ''
      },
      formFileTtd () {
        return this.formSetting?.model_file_ttd || ''
      },
      formEntitas () {
        return this.formSetting?.model_entitas || ''
      },
      widget () {
        return this.formSetting?.widget || []
      },
      widgetLabel () {
        return this.formSetting?.widget_label || ''
      }
    },
    methods: {
      showModalTandaTangan () {
        this.$emit('showModalTandaTangan')
      }
    }
  }
  </script>