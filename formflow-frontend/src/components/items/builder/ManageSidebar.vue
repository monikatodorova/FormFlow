<template>
    <div class="element-sidebar">
      <div class="header">
        <h4>Manage Element</h4>
        <div class="close" @click="$emit('hide-manage-sidebar')">X</div>
      </div>
      <div class="body">
        <component
          :is="getFieldManager(selectedField.fields[0].type)"
          :field="selectedField.fields[0]"
          :updateField="updateField"
          :deleteField="deleteField"
        />
      </div>
    </div>
  </template>
  
  <script>
  import ManageInput from '../manage/ManageInput.vue';
  import ManageTextarea from '../manage/ManageTextarea.vue';
  import ManageDropdown from '../manage/ManageDropdown.vue';
  import ManageDatepicker from '../manage/ManageDatepicker.vue';
  import ManageHeading from '../manage/ManageHeading.vue';
  import ManageSubmit from '../manage/ManageSubmit.vue';
  import ManageSpacer from '../manage/ManageSpacer.vue';
  import ManageDivider from '../manage/ManageDivider.vue';
  import ManageSingleselect from '../manage/ManageSingleselect.vue';
  import ManageMultiselect from '../manage/ManageMultiselect.vue';
  import ManageCheckbox from '../manage/ManageCheckbox.vue';
  import ManageParagraph from '../manage/ManageParagraph.vue';

  export default {
    props: ['selectedField'],
    components: {
      ManageInput,
      ManageTextarea,
      ManageDropdown,
      ManageDatepicker,
      ManageHeading,
      ManageSubmit,
      ManageSpacer,
      ManageDivider,
      ManageSingleselect,
      ManageMultiselect,
      ManageCheckbox,
      ManageParagraph
    },
    methods: {
      getFieldManager(type) {
        const componentMap = {
          input: 'ManageInput',
          textarea: 'ManageTextarea',
          datepicker: 'ManageDatepicker',
          heading: 'ManageHeading',
          spacer: 'ManageSpacer',
          divider: 'ManageDivider',
          dropdown: 'ManageDropdown',
          singleselect: 'ManageSingleselect',
          multiselect: 'ManageMultiselect',
          checkbox: 'ManageCheckbox',
          submit: 'ManageSubmit',
          paragraph: 'ManageParagraph'
        };
        return componentMap[type] || 'div';
      },
      updateField(field) {
        if (field.type === 'singleselect' || field.type === 'multiselect') {
          field.options = field.options.filter(option => option.value !== '');
        }

        this.$emit('field-update', field);
      },
      deleteField() {
        this.$emit('hide-manage-sidebar');
        this.$emit('field-delete');
      },
    },
  };
  </script>
  
  <style lang="scss" scoped>
  @import "../../../scss/variables";
  
  .element-sidebar {
      background: #fefefe;
      border: 1px solid #eee;
      border-radius: 15px;
      padding: 20px 40px;
      min-height: 80vh;
  
      .header {
          display: flex;
          justify-content: space-between;
          align-items: center;
      }
  
      .close {
        font-weight: 800;
        font-size: 15px;
        border: 1px solid #eee;
        color: #aaa;
        padding: 2px 8px;
        border-radius: 8px;

        &:hover {
          cursor: pointer;
          border: 1px solid #a9a9a9;
          color: #212529;
        }
      }
  
      .elements {
          .field-item {
              padding: 10px 15px;
              border: 1px solid #000;
              border-radius: 15px;
              margin-bottom: 5px;
          }
      }
  }
  </style>
  