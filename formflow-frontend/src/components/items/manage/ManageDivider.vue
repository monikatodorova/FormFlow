<template>
    <div class="element-details">
      <form @submit.prevent="emitUpdate">
        <div class="form-group">
          <label for="thickness">Thickness (in pixels)</label>
          <input
            id="thickness"
            type="number"
            v-model.number="editableField.thickness"
            class="form-control"
            placeholder="Enter thickness of the divider"
          />
        </div>

        <div class="form-group">
          <label for="width">Width (in pixels)</label>
          <input
            id="width"
            type="number"
            v-model.number="editableField.width"
            class="form-control"
            placeholder="Enter width of the divider"
          />
        </div>
  
        <div class="form-group">
          <label for="color">Color</label>
          <input
            id="color"
            type="text"
            v-model="editableField.color"
            class="form-control"
            placeholder="Enter color (e.g., #000000, red)"
          />
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
      deleteField: Function,
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
  