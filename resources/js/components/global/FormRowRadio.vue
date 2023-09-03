<template>
    <div>
      <div
        :class="`
          ${wrapperClass}
        `"
      >
        <template
          v-for="e in dataRadio"
          :key="e.value"
        >
          <label
            :class="`
              block cursor-pointer
              ${form[formModel] === e.value ? 'font-medium' : ''}
            `"
          >
            <input
              v-model="form[formModel]"
              type="radio"
              :value="e.value"
              :name="`form.${formModel}`"
              class="t-form-radio mr-2"
              :disabled="formDisabled"
              :required="formRequired"
            >
            <span>{{ e.text }}</span>
          </label>
        </template>
      </div>
      <p v-if="form[formModel]">
        <button
          type="button"
          class="
            text-brand-600
            border-b
            text-xs
          "
          @click="form[formModel] = ''"
        >
          Kosongkan
        </button>
      </p>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      form: { type: Object, default: () => {} },
      formModel: { type: String, default: () => '' },
      formDisabled: { type: Boolean, default: () => false },
      formRequired: { type: Boolean, default: () => false },
      dataRadio: { type: Array, default: () => [] },
      wrapperClass: { type: String, default: () => 'grid sm:grid-cols-3' },
      
    },
    data () {
      return {
  
      }
    },
    methods: {
      
    }
  }
  </script>