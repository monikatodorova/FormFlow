<template>
  <div class="form-group">
    <label :for="field.id">{{ field.label }}</label>
    <input
      type="date"
      :name="field.name"
      :id="field.id"
      :required="field.required"
      v-model="value"
      class="form-control form-field"
    />
  </div>
</template>

<script>
export default {
  props: {
    field: Object,
  },
  data() {
    return {
      value: this.field.value,
    }
  }
};
</script>

<style scoped lang="scss">
.form-field {
  height: 50px;
}
</style>
  