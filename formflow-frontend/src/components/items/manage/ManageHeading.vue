<template>
    <div class="element-details">
      <form @submit.prevent="emitUpdate">
        <div class="form-group">
          <label for="content">Heading Content</label>
          <input
            id="content"
            type="text"
            v-model="editableField.content"
            class="form-control"
            placeholder="Heading text"
          />
        </div>
  
        <div class="form-group">
          <label for="level">Heading Level</label>
          <select
            id="level"
            v-model="editableField.level"
            class="form-control"
          >
            <option value="1">H1</option>
            <option value="2">H2</option>
            <option value="3">H3</option>
            <option value="4">H4</option>
            <option value="5">H5</option>
            <option value="6">H6</option>
          </select>
        </div>
  
        <div class="actions">
          <button type="submit" class="btn btn-primary mt-3" @click="this.updateField(editableField)">Update</button>
          <button type="submit" class="btn btn-secondary mt-3" @click="this.deleteField()">Delete</button>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      field: {
        type: Object,
        required: true,
      },
      updateField: Function,
      deleteField: Function
    },
    data() {
      return {
        editableField: { ...this.field },
      };
    },
    watch: {
      field: {
        handler(newField) {
          this.editableField = { ...newField };
        },
        deep: true,
      },
    },
    methods: {
      emitUpdate() {
        this.$emit("field-update", this.editableField);
      },
    },
  };
  </script>
  
  <style lang="scss" scoped>
  .element-details {
    padding-top: 30px;

    .form-group {
      margin-bottom: 30px;

      label {
        font-weight: 600;
      }

      .form-control {
        height: 50px;
      }
    }

    .actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 10px;

      button {
        width: 100%;
      }
    }
  }
  
  </style>
  