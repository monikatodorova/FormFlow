<template>
    <div class="row">
      <FormColumn v-for="(column, index) in columns" :key="index" :column="column" :rowIndex="rowIndex" :columnIndex="index" :selectColumn="selectColumn"
      :manageElement="manageElement" />
    </div>
  </template>
  
  <script>
  import FormColumn from './FormColumn.vue';
  
  export default {
    props: { columns: Array, rowIndex: Number, selectColumn: Function, manageElement: Function },
    components: {
      FormColumn,
    },
    methods: {
    }
  };
  </script>
  