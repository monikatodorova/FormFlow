<template>
  <div>
    <label :for="field.id" class="form-label">{{ field.label }}</label>
    <select
      :id="field.id"
      :name="field.name"
      class="form-control form-field"
      v-model="selectedOption"
    >
      <option value="" disabled selected>{{ field.placeholder || "Select an option" }}</option>
      <option
        v-for="(option, index) in field.options"
        :key="index"
        :value="option.value"
      >
        {{ option.label }}
      </option>
    </select>
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
  },
};
</script>

<style scoped lang="scss">
.form-field {
  height: 50px;
}
</style>
  