<template>
    <div :class="column.width">
      <div 
        v-if="!column.fields || column.fields.length === 0" 
        class="add-element-placeholder" 
        @click="handleClick"
      >
        + Add form element
      </div>
      <!-- <component v-for="(field, index) in column.fields" :key="index" :is="getComponent(field.type)" :field="field" @click="openManageElement"/> -->
      <div>
      <div v-for="(field, index) in column.fields" :key="index" class="field-container">
        <component :is="getComponent(field.type)" :field="field"/>
        <div class="overlay" @click="openManageElement"></div>
      </div>
    </div>
    </div>
  </template>
  
  <script>
  import FormInput from './FormInput.vue';
  import FormTextarea from './FormTextarea.vue';
  import FormDatepicker from './FormDatepicker.vue';
  import FormSubmit from './FormSubmit.vue';
  import FormHeading from './FormHeading.vue';
  import FormSpacer from './FormSpacer.vue';
  import FormDivider from './FormDivider.vue';
  import FormMultiselect from './FormMultiselect.vue';
  import FormSingleselect from './FormSingleselect.vue';
  import FormDropdown from './FormDropdown.vue';
  import FormCheckbox from './FormCheckbox.vue';
  import FormParagraph from './FormParagraph.vue';
  
  export default {
    props: {
      column: Object,
      rowIndex: Number,
      columnIndex: Number,
      selectColumn: Function,
      manageElement: Function,
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
      FormParagraph,
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
          paragraph: 'FormParagraph'
        };
        return componentMap[type] || 'div';
      },
      handleClick() {
        this.selectColumn(this.rowIndex, this.columnIndex);
      },
      openManageElement() {
        this.manageElement(this.rowIndex, this.columnIndex);
      },
    },
  };
  </script>

<style scoped lang="scss">
@import "../../../scss/variables";

  .add-element-placeholder {
      text-align: center;
      padding: 30px;
      background: #f2f4f9;
      border-radius: 8px;
      font-weight: 500;
      color: rgba(14,18,46,.65);

      &:hover {
        color: $primary;
        cursor: pointer;
        background: rgba(3,31,235,.075);
      }
  }

  .field-container {
    position: relative;

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, 0);
      cursor: pointer;
      z-index: 10;
    }

    > *:not(.overlay) {
      pointer-events: none;
    }
  }
</style>
  