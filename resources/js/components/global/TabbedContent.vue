<template>
    <div>
      <!-- nav menu -->
      <div
        :class="`
          flex
          border
          dark:border-gray-600
          rounded-lg
        `"
      >
        <template
          v-for="(e, i) in modeFormList"
          :key="e.key"
        >
          <button
            type="button"
            :class="`
              flex-1
              p-2
              ${
              modeForm === e.key ?
                `
                  bg-brand-600
                  text-white
                  hover:bg-brand-800
                  `
                :
                `
                  bg-white
                  dark:bg-gray-700
                  hover:bg-gray-200
                  dark:hover:bg-gray-800
                  `
            }
            ${i === 0 ? 'rounded-l-lg' : ''}
            ${i === modeFormList.length - 1 ? 'rounded-r-lg' : ''}
            `"
            @click="modeForm = e.key"
          >
            {{ e.nama }}
          </button>
        </template>
      </div>
  
      <!-- content -->
      <div
        class="mt-2"
      >
        <template
          v-for="e in modeFormList"
          :key="e.key"
        >
          <div
            :class="`
              ${e.key === modeForm ? 'block' : 'hidden'}
            `"
          >
            <slot :name="e.key" />
          </div>
        </template>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      modeFormList: {
        type: Array,
        default: () => []
      }
    },
    data () {
      return {
        modeForm: ''
      }
    },
    mounted () {
      this.setDefaultModeForm()
    },
    methods: {
      setDefaultModeForm () {
        if (this.modeFormList[0]) {
          this.modeForm = this.modeFormList[0].key
        }
      }
    }
  }
  </script>