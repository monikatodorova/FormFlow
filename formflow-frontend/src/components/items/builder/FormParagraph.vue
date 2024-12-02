<template>
    <p>{{ field.content }}</p>
  </template>
  
  <script>
  export default {
    props: {
      field: {
        type: Object,
        required: true,
      },
    },
  };
  </script>
  
  <style>
  .form-heading {
    margin-bottom: 1rem;
  }
  </style>
  