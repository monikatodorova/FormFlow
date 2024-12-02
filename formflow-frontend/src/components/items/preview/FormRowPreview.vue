<template>
    <div class="row">
      <FormColumnPreview v-for="(column, index) in columns" :key="index" :column="column" />
    </div>
  </template>
  
  <script>
  import FormColumnPreview from './FormColumnPreview.vue';
  
  export default {
    name: 'FormRowPreview',
    props: { columns: Array },
    components: { FormColumnPreview }
  };
  </script>
  