<template>
    <div>
      <label class="form-label">{{ field.label }}</label>
      <div v-for="(option, index) in field.options" :key="index" class="form-check">
        <input
          type="radio"
          :id="`${field.id}-${index}`"
          :name="field.name"
          :value="option.value"
          class="form-check-input"
          v-model="selectedOption"
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
        selectedOption: this.field.value || "",
      };
    },
    watch: {
      selectedOption(newValue) {
        this.$emit("input", newValue);
      },
      "field.value": {
        immediate: true,
        handler(newValue) {
          this.selectedOption = newValue;
        },
      },
    },
  };
  </script>
  