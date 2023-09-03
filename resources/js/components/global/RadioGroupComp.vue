<template>
  <RadioGroup v-model="dataSelected">
    <RadioGroupLabel class="sr-only">
      {{ formLabel }}
    </RadioGroupLabel>
    <div class="space-y-2">
      <RadioGroupOption
        v-for="l in list"
        :key="l.id"
        v-slot="{ active, checked }"
        as="template"
        :value="l"
      >
        <div
          :class="[
            active
              ? `ring-2 ring-white ring-opacity-60 ring-offset-2 ring-offset-${l.colorSelected}-100`
              : '',
            checked ? `bg-${l.colorSelected}-600 text-white ` : 'bg-gray-100 ',
          ]"
          class="relative flex cursor-pointer rounded-lg p-4 shadow-md focus:outline-none"
        >
          <div class="flex w-full items-center justify-between">
            <div class="flex">
              <div class="mr-2">
                <component
                  :is="l.icon"
                  :class="checked ? 'text-white' : 'text-gray-500'"
                  class="w-8 h-8"
                />
              </div>
              <div class="text-sm">
                <RadioGroupLabel
                  as="p"
                  :class="checked ? 'text-white' : 'text-gray-900'"
                  class="font-bold"
                >
                  {{ l.name }}
                </RadioGroupLabel>
                <RadioGroupDescription
                  as="span"
                  :class="checked ? 'text-white' : 'text-gray-500'"
                  class="inline"
                >
                  <span> {{ l.desc }}</span>
                </RadioGroupDescription>
              </div>
            </div>
            <div
              v-show="checked"
              class="shrink-0 text-white"
            >
              <svg
                class="h-6 w-6"
                viewBox="0 0 24 24"
                fill="none"
              >
                <circle
                  cx="12"
                  cy="12"
                  r="12"
                  fill="#fff"
                  fill-opacity="0.2"
                />
                <path
                  d="M7 13l3 3 7-7"
                  stroke="#fff"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </div>
          </div>
        </div>
      </RadioGroupOption>
    </div>
  </RadioGroup>
</template>

<script>
import {
  RadioGroup,
  RadioGroupLabel,
  RadioGroupDescription,
  RadioGroupOption,
} from '@headlessui/vue'

import {
  CheckCircleIcon,
  XCircleIcon
} from '@heroicons/vue/24/outline'

export default {
  components: {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupDescription,
    RadioGroupOption,

    CheckCircleIcon,
    XCircleIcon
  },
  props: {
    formLabel: {
      type: String,
      default: ''
    },
    list: {
      type: Array,
      default: () => []
    },
    selected: {
      type: Object,
      default: () => {}
    }
  },
  data () {
    return {
      dataSelected: {}
    }
  },
  watch: {
    selected (newVal) {
      this.dataSelected = newVal
    },
    dataSelected (newVal) {
      this.$emit('setSelected', newVal)
    }
  }
}
</script>