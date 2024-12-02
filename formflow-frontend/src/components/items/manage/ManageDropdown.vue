<template>
    <div class="element-details">
      <form @submit.prevent="emitUpdate">
        <div class="form-group">
          <label for="label">Label</label>
          <input
            id="label"
            type="text"
            v-model="editableField.label"
            class="form-control"
            placeholder="Field label"
          />
        </div>
        <div class="form-group">
          <label for="options">Options</label>
          <textarea
            id="options"
            v-model="editableField.optionsString"
            class="form-control"
            placeholder="Enter options in JSON format"
          ></textarea>
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
        editableField: {
          ...this.field,
          optionsString: JSON.stringify(this.field.options, null, 2),
        },
      };
    },
    methods: {
      emitUpdate() {
        try {
          this.editableField.options = JSON.parse(this.editableField.optionsString);
          this.updateField(this.editableField);
        } catch (error) {
          alert('Invalid JSON for options');
        }
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
  