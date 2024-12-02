<template>
  <hr :style="dividerStyle" />
</template>

<script>
export default {
  props: {
    field: {
      type: Object,
      required: false,
      default: () => ({}),
    },
  },
  computed: {
    dividerStyle() {
      return {
        borderColor: this.field.color || '#ccc',
        margin: this.field.margin || '1rem 0',
        borderWidth: this.field.thickness || '1px',
        width: this.field.width + 'px' || '200px'
      };
    },
  },
};
</script>

<style>
</style>
  