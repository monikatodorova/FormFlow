<template>
    <div class="form-check">
      <input
        type="checkbox"
        :id="field.id"
        class="form-check-input"
        v-model="checked"
      />
      <label :for="field.id" class="form-check-label">
        {{ field.label }}
      </label>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      field: {
        type: Object,
        required: true,
      },
    },
    data() {
      return {
        checked: this.field.value || false,
      };
    },
    watch: {
      checked(newValue) {
        this.$emit("input", newValue);
      },
    },
  };
  </script>
  