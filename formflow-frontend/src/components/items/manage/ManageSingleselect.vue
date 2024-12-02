<template>
  <div class="element-details">
    <form @submit.prevent="emitUpdate">
      <div class="form-group">
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
        <div><label for="options">Options</label></div>
        <div v-for="(option, index) in editableField.options" :key="index" class="option-pair">
          <input
            type="text"
            v-model="option.label"
            placeholder="Label"
            class="form-control"
          />
          <input
            type="text"
            :value="generateValue(option.label, index)"
            placeholder="Value"
            class="form-control"
            disabled
          />
          <button type="button" class="btn btn-danger" @click="removeOption(index)" style="padding: 10px 15px;">X</button>
        </div>
        <button type="button" class="btn btn-primary add-option" @click="addOption">
          + Add Option
        </button>
      </div>

      <div class="form-group" v-if="editableField.options.length > 0">
        <label for="default">Default Selected</label>
        <select id="default" v-model="editableField.value" class="form-control">
          <option value="">No default option</option>
          <option  v-for="option in editableField.options" :key="option.value" :value="option.value">
            {{ option.label }}
          </option>
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
    deleteField: Function,
  },
  data() {
    return {
      editableField: {
        ...this.field,
        options: this.field.options || [],
      },
    };
  },
  watch: {
    field: {
      handler(newField) {
        this.editableField = {
          ...newField,
          options: newField.options || [],
        };
      },
      deep: true,
    },
  },
  methods: {
    emitUpdate() {
      this.$emit("field-update", this.editableField);
    },
    addOption() {
      this.editableField.options.push({ label: "", value: "" });
    },
    removeOption(index) {
      this.editableField.options.splice(index, 1);
    },
    generateValue(label, index) {
      if (!label) return ``;
      return `option-${index}-${label.toLowerCase().replace(/\s+/g, "-")}`;
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

    .option-pair {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;

      .form-control {
        height: 40px;
        flex: 1;
      }

      button {
        flex-shrink: 0;
        height: 40px;
      }
    }

    .add-option {
      margin-top: 10px;
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
