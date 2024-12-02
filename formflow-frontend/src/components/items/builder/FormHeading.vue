<template>
    <component :is="headingTag" class="form-heading">
      {{ field.content }}
    </component>
  </template>
  
  <script>
  export default {
    props: {
      field: {
        type: Object,
        required: true,
      },
    },
    computed: {
      headingTag() {
        const level = this.field.level || 3; 
        return `h${Math.min(Math.max(level, 1), 5)}`;
      },
    },
  };
  </script>
  
  <style scoped lang="scss">
  
  h1 {
    font-size: 2em;
    font-weight: bolder;
    margin: 0 !important;
    color: inherit !important;
  }
  h2 {
    font-size: 1.5em;
    font-weight: bolder;
    margin: 0 !important;
    color: inherit !important;
  }
  h3 {
    font-size: 1.17em;
    font-weight: bolder;
    margin: 0 !important;
    color: inherit !important;
  }
  h4 {
    font-size: 1em;
    font-weight: bolder;
    margin: 0 !important;
    color: inherit !important;
  }
  h5 {
    font-size: 0.83em;
    font-weight: bolder;
    margin: 0 !important;
    color: inherit !important;
  }
  h5 {
    font-size: 0.67em;
    font-weight: bolder;
    margin: 0 !important;
    color: inherit !important;
  }
  .form-heading {
    margin-bottom: 1rem;
  }
  </style>
  