<template>
  <div>
    <div ref="button" @click="toggle()">
      <button type="button"
        class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-brand-600 border rounded-md shadow-sm"
        aria-haspopup="true" aria-expanded="true">
        {{ btnText }}
        <ChevronDownIcon class="w-5 h-5 ml-2 -mr-1 text-white" aria-hidden="true" />
      </button>
    </div>
    <div ref="content" class="z-10">
      <transition enter-active-class="transition duration-100 ease-out" enter-class="transform scale-75 opacity-0"
        enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in"
        leave-class="transform scale-100 opacity-100 " leave-to-class="transform scale-75 opacity-0">
        <div v-show="isOpen" class="w-64 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
          <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            <template v-if="listStyle === '1d'">
              <div class="px-1 py-1">
                <template v-for="m in menuList" :key="m.id">
                  <button :disabled="m.isDisable" class="
                  text-gray-900
                  group flex w-full items-center rounded-md px-2 py-2 text-sm
                  hover:bg-brand-600 hover:text-white
                  " @click="$emit('handleClick', m, data)">
                    <component :is="m.icon" class="mr-2 h-5 w-5 text-brand-500 group-hover:text-white" />
                    {{ m.text }}
                  </button>
                </template>
              </div>
            </template>
            <template v-else-if="listStyle === '2d'">
              <div v-for="(p, i) in menuList" :key="i" class="px-1 py-1"
                :class="i === menuList.length - 1 ? '' : 'border-b'">
                <template v-for="m in p" :key="m.id">
                  <button :disabled="m.isDisable" :class="[`text-gray-900 flex w-full items-center rounded-md px-2 py-2 text-sm
                    hover:bg-brand-600 hover:text-white group`, m.isDisable ? `bg-gray-300` : '']"
                    @click="handleClickMenu(m, data)">
                    <component :is="m.icon" class="mr-2 h-5 w-5 text-brand-500 group-hover:text-white" />

                    {{ m.text }}
                  </button>
                </template>
              </div>
            </template>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import { createPopper } from '@popperjs/core'
import {
  ChevronDownIcon,
  ArchiveBoxIcon,
  UsersIcon,
  EyeIcon,
  ChevronRightIcon,
  PencilIcon,
  EyeDropperIcon,
  ClipboardDocumentCheckIcon,
  HomeModernIcon,
  ShieldCheckIcon,
  CheckCircleIcon,
  ClipboardDocumentListIcon,
  CheckBadgeIcon,
  SpeakerWaveIcon,
  CheckIcon,
  XMarkIcon,
  TrashIcon,
  PencilSquareIcon,
  PrinterIcon,
  BarsArrowDownIcon,
  CreditCardIcon,
  PlusIcon,
  HandRaisedIcon,
  KeyIcon,
} from '@heroicons/vue/20/solid'

export default {
  components: {
    ChevronDownIcon,
    EyeIcon,
    ArchiveBoxIcon,
    UsersIcon,
    CheckCircleIcon,
    PencilIcon,
    EyeDropperIcon,
    ClipboardDocumentCheckIcon,
    HomeModernIcon,
    ShieldCheckIcon,
    ClipboardDocumentListIcon,
    CheckBadgeIcon,
    SpeakerWaveIcon,
    CheckIcon,
    XMarkIcon,
    PencilSquareIcon,
    PrinterIcon,
    BarsArrowDownIcon,
    CreditCardIcon,
    PlusIcon,
    HandRaisedIcon,
    KeyIcon,
    TrashIcon
  },
  props: {
    btnText: {
      type: String,
      default: 'Button'
    },

    /**
     * list style nya apakh 1 dimensi,
     * atau 2 dimensi
     * jika 1 dimensi, biasa saja,
     * kalau 2 dimensi, ada separatornya
     * nilainya: '1d', '2d'
     */
    listStyle: {
      type: String,
      default: '1d'
    },
    /**
     * List menu
     * example: [{ id: 1, text: 'Edit', icon: 'PencilIcon', disabled: false }]
     */
    menuList: {
      type: Array,
      default: () => []
    },
    data: {
      type: Object,
      default: () => { }
    }
  },
  emits: ['handleClick'],
  data() {
    return {
      isOpen: false,
      popperInstance: null,
    }
  },
  mounted() {
    document.addEventListener('click', this.close);

    this.popperInstance = createPopper(this.$refs["button"], this.$refs["content"], {
      placement: 'bottom-end',
      modifiers: [
        {
          name: 'offset',
          options: {
            offset: [0, 4],
          },
        },
      ],
    });
  },
  beforeUnmount() {
    document.removeEventListener('click', this.close);

    if (this.popperInstance) {
      this.popperInstance.destroy();
      this.popperInstance = null;
    }
  },
  methods: {
    close(event) {
      if (!this.$el.contains(event.target)) {
        this.isOpen = false;
      }
    },
    toggle() {
      this.isOpen = !this.isOpen;
      this.popperInstance.update();
    },
    handleClickMenu(m, row) {
      this.toggle()
      if ('disabled' in m && m.isDisable) {
        return false
      }
      this.$emit('handleClick', m, row)
    }
  }
}
</script>