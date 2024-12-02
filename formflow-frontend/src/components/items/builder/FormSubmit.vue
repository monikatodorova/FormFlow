<template>
  <button type="submit" :id="field.id" class="btn btn-primary">
    {{ field.label }}
  </button>
</template>

<script>
export default {
  props: {
    field: Object
  },
  methods: {
  }
};
</script>

<style scoped lang="scss">
button {
  width: 100%;
}
</style>
  