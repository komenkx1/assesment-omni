<template>
    <div
      :class="`
        form-row
        ${formSetting?.disabled ? 'opacity-50 cursor-not-allowed' : ''}
      `"
    >
      <slot name="formFirstCol" />
      <label
        :for="`form.${formModel}`"
        :class="`
          ${formLabelClass}
        `"
      >
        {{ formLabel }}
        <span
          v-if="formSetting?.required"
          class="text-red-600"
        >*</span>
      </label>
      <div
        :class="`
          ${formInputWrapperClass}
        `"
      >
        <!-- jika tidak input custom -->
        <template v-if="!formInputCustom">
          <template v-if="formType === 'text'">
            <input
              :id="`form.${formModel}`"
              v-model="form[formModel]"
              type="text"
              class="t-form"
              required
              min="1"
              maxlength="255"
              :disabled="formSetting?.disabled"
            >
          </template>
          <template v-else-if="formType === 'textarea'">
            <textarea
              v-model="form[formModel]"
              class="t-form"
              rows="4"
              required
              :disabled="formSetting?.disabled"
            />
          </template>
          <template v-else-if="formType === 'date'">
            <DatePicker
              v-model:value="form[formModel]"
              value-type="YYYY-MM-DD"
              type="datetime"
              format="D MMM YYYY"
              class="!w-full"
              input-class="t-form"
              confirm
              :shortcuts="[
                { text: 'Today', onClick: () => new Date() }
              ]"
              placeholder="Contoh: 28 Feb 2023"
              :disabled="formSetting?.disabled"
              :disabled-date="(date) => date > new Date()/**disabled date lebih dari hari ini */"
            />
          </template>
          <template v-else-if="formType === 'yesno'">
            <SwitchToggle
              :enabled="form[formModel]"
              @update:enabled="val => form[formModel] = val"
            />
          </template>
          <template v-else-if="formType === 'checkbox'">
            <FormRowCheckbox
              :form="form"
              :data-checkbox="formSetting?.dataCheckbox || []"
            />
          </template>
          <template v-else-if="formType === 'radio'">
            <FormRowRadio
              :form="form"
              :form-model="formModel"
              :form-disabled="formSetting?.disabled"
              :form-required="formSetting?.required"
              :data-radio="formSetting?.dataRadio || []"
              :wrapper-class="formSetting?.wrapperClass || undefined"
            />
          </template>
        </template>
        <!-- jika input custom, ada slot -->
        <template v-else-if="formInputCustom">
          <slot name="formInputCustom" />
        </template>
  
        <slot name="formInputAppend" />
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      form: { type: Object, default: () => {} },
      formModel: { type: String, default: () => '' },
      formType: { type: String, default: () => 'text' },
      formSetting: { type: Object, default: () => {} },
      formInputCustom: { type: Boolean, default: false },
      formLabel: { type: String, default: () => '' },
      formLabelClass: { type: String, default: () => 'font-medium p-2' },
      formInputWrapperClass: { type: String, default: () => 'sm:col-span-3 p-2' },
    },
    data () {
      return {
  
      }
    },
    methods: {
      
    }
  }
  </script>