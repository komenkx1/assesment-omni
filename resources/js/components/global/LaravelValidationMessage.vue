<template>
  <div>
    <p class="font-bold">
      {{ message }}
    </p>
    <ul
      v-if="dataMessage"
    >
      <li
        v-for="e in Object.keys(dataMessage)"
        :key="e"
      >
        <span>{{ e }}</span>
        <ul class="list-disc pl-4">
          <li
            v-for="f in dataMessage[e]"
            :key="f"
          >
            {{ f }}
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      default: ''
    },
    dataMessage: {
      type: Object,
      default: () => null
    }
  },
}
</script>