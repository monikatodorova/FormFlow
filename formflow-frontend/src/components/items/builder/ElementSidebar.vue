<template>
	<div class="element-sidebar">
        <div class="header">
            <h4 @click="showFields()">Choose element</h4>
            <div class="close" @click="$emit('hide-element-sidebar')">X</div>
        </div>
        <div class="elements">
            <p>Most popular</p>
            <div v-for="field in formFields.filter(item => item.category==='most-popular')" :key="field">
                <div class="field-item" @click="selectField(field)">{{ field.title }}</div>
            </div>

            <p>Headings & paragraphs</p>
            <div v-for="field in formFields.filter(item => item.category==='headings-paragraphs')" :key="field">
                <div class="field-item" @click="selectField(field)">{{ field.title }}</div>
            </div>

            <p>Simple fields</p>
            <div v-for="field in formFields.filter(item => item.category==='simple-field')" :key="field">
                <div class="field-item" @click="selectField(field)">{{ field.title }}</div>
            </div>

            <p>Layout</p>
            <div v-for="field in formFields.filter(item => item.category==='layout')" :key="field">
                <div class="field-item" @click="selectField(field)">{{ field.title }}</div>
            </div>
        </div>
	</div>
</template>

<script>
import formFields from '@/data/formFields';

export default {
    props: ['formId'],
    data() {
        return {
            formFields,
            loaded: false,
        }
    },
    methods: {
        showFields() {
            console.log(this.formFields);
        },
        selectField(field) {
            this.$emit('field-selected', field);
        },
    }
}

</script>

<style lang="scss" scoped>
@import "../../../scss/variables";

.element-sidebar {
    background: #fefefe;
    border: 1px solid #eee;
    border-radius: 15px;
    padding: 20px 40px;
    min-height: 80vh;

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close {
        font-weight: 800;
        font-size: 15px;
        border: 1px solid #eee;
        color: #aaa;
        padding: 2px 8px;
        border-radius: 8px;

        &:hover {
          cursor: pointer;
          border: 1px solid #a9a9a9;
          color: #212529;
        }
      }

    .elements {
        p {
            font-weight: 500;
            margin: 0;
            margin-top: 20px;
        }

        .field-item {
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-bottom: 5px;

            &:hover {
                background: #f2f4f9;
                color: $primary;
                cursor: pointer;
            }
        }
    }
}
</style>
