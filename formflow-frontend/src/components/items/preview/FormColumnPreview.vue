<template>
    <div :class="column.width">
      <component v-for="(field, index) in column.fields" :key="index" :is="getComponent(field.type)" :field="field"/>
    </div>
  </template>
  
  <script>
  import FormInput from './../builder/FormInput.vue';
  import FormTextarea from '../builder/FormTextarea.vue';
  import FormDatepicker from '../builder/FormDatepicker.vue';
  import FormSubmit from '../builder/FormSubmit.vue';
  import FormHeading from '../builder/FormHeading.vue';
  import FormSpacer from '../builder/FormSpacer.vue';
  import FormDivider from '../builder/FormDivider.vue';
  import FormMultiselect from '../builder/FormMultiselect.vue';
  import FormSingleselect from '../builder/FormSingleselect.vue';
  import FormDropdown from '../builder/FormDropdown.vue';
  import FormCheckbox from '../builder/FormCheckbox.vue';
  
  export default {
    props: {
      column: Object,
    },
    components: {
      FormInput,
      FormTextarea,
      FormDatepicker,
      FormSubmit,
      FormHeading,
      FormSpacer,
      FormDivider,
      FormMultiselect,
      FormSingleselect,
      FormDropdown,
      FormCheckbox,
    },
    methods: {
      getComponent(type) {
        const componentMap = {
          input: 'FormInput',
          textarea: 'FormTextarea',
          datepicker: 'FormDatepicker',
          submit: 'FormSubmit',
          heading: 'FormHeading',
          spacer: 'FormSpacer',
          divider: 'FormDivider',
          dropdown: 'FormDropdown',
          multiselect: 'FormMultiselect',
          singleselect: 'FormSingleselect',
          checkbox: 'FormCheckbox',
        };
        return componentMap[type] || 'div';
      },
    },
  };
  </script>

<style scoped lang="scss">
</style>
  