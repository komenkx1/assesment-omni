<template>
    <div
      :class="`
        ${wrapperClass}
      `"
    >
      <template
        v-for="e in dataCheckbox"
        :key="e.model"
      >
        <label class="block cursor-pointer">
          <input
            v-model="form[e.model]"
            type="checkbox"
            :value="1"
            :name="`form.${e.model}`"
            class="t-form-radio mr-2"
          >
          <span>{{ e.text }}</span>
        </label>
      </template>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      form: { type: Object, default: () => {} },
      dataCheckbox: { type: Array, default: () => [] },
      wrapperClass: { type: String, default: () => '' },
      
    },
    data () {
      return {
  
      }
    },
    methods: {
      
    }
  }
  </script>