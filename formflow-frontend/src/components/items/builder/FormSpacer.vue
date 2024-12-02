<template>
    <div :style="spacerStyle"></div>
  </template>
  
  <script>
  export default {
    props: {
      field: Object
    },
    computed: {
      spacerStyle() {
        return {
          height: this.field.height + 'px' || '1rem',
        };
      },
    },
  };
  </script>
  