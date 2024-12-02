<template>
  <div class="form-group">
    <label :for="field.id">{{ field.label }}</label>
    <textarea
      :name="field.name"
      :id="field.id"
      :placeholder="field.placeholder"
      :required="field.required"
      v-model="value"
      class="form-control form-field"
    ></textarea>
  </div>
</template>

<script>
export default {
  props: {
    field: Object,
  },
  data() {
    return {
      value: this.field.value
    }
  }
};
</script>

<style scoped lang="scss">
.form-field {
  height: 50px;
  padding-top: 15px;
}
</style>
  