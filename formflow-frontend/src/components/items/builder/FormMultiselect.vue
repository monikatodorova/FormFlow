<template>
    <div>
      <label class="form-label">{{ field.label }}</label>
      <div v-for="(option, index) in field.options" :key="index" class="form-check">
        <input
          type="checkbox"
          :id="`${field.id}-${index}`"
          :value="option.value"
          class="form-check-input"
          v-model="selectedOptions"
        />
        <label :for="`${field.id}-${index}`" class="form-check-label">
          {{ option.label }}
        </label>
      </div>
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
        selectedOptions: this.field.value || [],
      };
    },
    watch: {
      selectedOptions(newValue) {
        this.$emit("input", newValue);
      },
    },
  };
  </script>
  