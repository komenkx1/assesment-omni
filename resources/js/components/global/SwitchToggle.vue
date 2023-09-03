<!--

contoh: 

<SwitchToggle
  :enabled="form[d.id]"
  @update:enabled="val => form[d.id] = val"
/>

-->

<template>
  <Switch
    v-model="switchToggle"
    :class="switchToggle ? 'bg-green-600' : 'bg-red-700'"
    class="relative overflow-hidden inline-flex h-[38px] w-[120px] shrink-0 cursor-pointer rounded-md border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
  >
    <div
      :class="switchToggle ? 'translate-x-0' : 'translate-x-[-92px]'"
      class="flex transition duration-200 ease-in-out"
    >
      <span
        class="block text-white pt-2 w-[92px]"
      >
        Ya
      </span>
      <span
        aria-hidden="true"
        class="pointer-events-none h-[34px] w-[24px] transform rounded-md bg-white shadow-lg ring-0 "
      />
      <span
        class="block text-white pt-2 w-[92px]"
      >
        Tidak
      </span>
    </div>
  </Switch>
</template>

<script>
import { Switch } from '@headlessui/vue'

export default {
  components: {
    Switch
  },
  props: {
    enabled: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },
  emits: ['update:enabled'],
  computed: {
    switchToggle: {
      get () { return this.enabled },
      set (value) {
        if (!this.disabled) {
          this.$emit('update:enabled', value)
        }
      },
    },
  },
}
</script>