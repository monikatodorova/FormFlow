<template>
	<div class="build-form">
        <div class="row">
            <div class="col-md-12" v-if="formData">
                <div class="title" v-if="formData.rows.length === 0 && this.type !== 'ai'">
                    <h2>Add form elements</h2>
                    <p>Start building your form by adding a row and elements</p>
                </div>
                <div class="form-elements">
                    <draggable v-model="formData.rows" handle=".row-handle">
                        <template #item="{element: row, index: rowIndex}">
                            <div class="form-rows" @mouseover="setActiveRow(rowIndex)" @mouseleave="clearActiveRow">
                                <div class="row-handle"><span>::</span></div>
                                <FormRow :columns="row.columns" :rowIndex="rowIndex" :selectColumn="selectColumn" :manageElement="manageElement"></FormRow>
                                <button v-if="activeRow === rowIndex" class="delete-row-btn" @click="deleteRow(rowIndex)">X</button>
                            </div>
                        </template>
                    </draggable>
                </div>
                <div class="add-row" v-if="!newRow && generated" @click="showRowOptions()">
                    <p>+ Add new row</p>
                </div>
                <div class="choose-layout" v-if="newRow">
                    <p>Choose row layout</p>
                    <div class="row-options">
                        <div class="row-option" @click="addRow(rowLayout.oneColumn.value)">
                            <div class="layout-option one"></div>
                        </div>
                        <div class="row-option" @click="addRow(rowLayout.twoColumns.value)" >
                            <div class="layout-option two"></div>
                            <div class="layout-option two"></div>
                        </div>
                        <div class="row-option" @click="addRow(rowLayout.threeColumns.value)">
                            <div class="layout-option three"></div>
                            <div class="layout-option three"></div>
                            <div class="layout-option three"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</template>

<script>
import FormRow from './FormRow.vue';
import draggable from 'vuedraggable';

export default {
    props: ['formId', 'currentForm', 'fields', 'type', 'generated'],
    components: {FormRow, draggable},
    data() {
        return {
            newRow: false,
            choseElement: false,
            activeRowIndex: null,
            activeColIndex: null,
            activeRow: null,
            rows: [],
            rowLayout: {
                oneColumn: {
                    value: 1,
                    class: 'col-12',
                    fields: [],
                },
                twoColumns: {
                    value: 2,
                    class: 'col-6',
                    fields: [],
                },
                threeColumns: {
                    value: 3,
                    class: 'col-4',
                    fields: [],
                }
            },
            formData: this.fields !== null ? this.fields : {"rows": []},
        }
    },
    methods: {
        updateFields(newFields) {
            try {
                newFields = typeof newFields === 'string' ? JSON.parse(newFields) : newFields;
            } catch (e) {
                console.error("Failed to parse newFields:", e);
                newFields = {"rows": []};
            }
            this.formData = newFields !== null ? newFields : {"rows": []}
        },
        showRowOptions() {
            this.newRow = true;
        },
        showElementsSidebar() {
            this.choseElement = true;
        },
        addRow(colNum) {
            let newRow;
            if (colNum === 1) {
                newRow = { ...this.rowLayout.oneColumn };
            } else if (colNum === 2) {
                newRow = { ...this.rowLayout.twoColumns };
            } else if (colNum === 3) {
                newRow = { ...this.rowLayout.threeColumns };
            }

            this.rows.push(newRow);

            this.formData.rows.push({
                columns: Array.from({ length: colNum }).map(() => ({
                    width: newRow.class,
                    fields: [],
                })),
            });

            this.newRow = false;
        },
        selectColumn(rowIndex, colIndex) {
            this.activeRowIndex = rowIndex;
            this.activeColIndex = colIndex;
            this.$emit('choose-element-sidebar');
        },
        getSelectedField() {
            return this.formData.rows[this.activeRowIndex].columns[this.activeColIndex];
        },
        manageElement(rowIndex, colIndex) {
            this.activeRowIndex = rowIndex;
            this.activeColIndex = colIndex;
            this.$emit('manage-element-sidebar');
        },
        addFieldToColumn(field) {
            if (this.activeRowIndex !== null && this.activeColIndex !== null) {
                const column = this.formData.rows[this.activeRowIndex].columns[this.activeColIndex];
                column.fields.push(field);
            }
        },
        updateField(field) {
            this.formData.rows[this.activeRowIndex].columns[this.activeColIndex].fields[0] = field;
        },
        deleteField() {
            this.formData.rows[this.activeRowIndex].columns[this.activeColIndex].fields = [];
        },
        setActiveRow(rowIndex) {
            this.activeRow = rowIndex;
        },
        clearActiveRow() {
            this.activeRow = null;
        },
        deleteRow(rowIndex) {
            this.formData.rows.splice(rowIndex, 1);
        },
        getFields() {
            return this.formData;
        }
    }
}

</script>

<style lang="scss" scoped>
@import "../../../scss/variables";

.build-form {
    background: #fefefe;
    border: 1px solid #f2f4f9;
    border-radius: 15px;
    padding: 40px 20px;
    min-height: 80vh;
    position: relative;

    

    .title {
        text-align: center;
    }

    .add-row {
        text-align: center;
        padding: 20px;
        border-radius: 15px;
        background: #f2f4f9;
        color: $primary;
        margin-top: 20px;

        p {
            margin: 0;
            font-weight: bold;
        }

        &:hover {
            cursor: pointer;
            background: #f0f0f5;
        }
    }

    .choose-layout {
        text-align: center;
        padding: 15px;
        border-radius: 15px;
        background: #fff;
        border: 1px dashed #ccc;
        color: #212529;
        font-weight: 600;
        margin-top: 20px;

        .row-options {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;

            .row-option {
                display: flex;
                justify-content: space-around;
                align-items: center;
                padding: 10px;
                border: 1px solid #fff;
                border-radius: 8px;

                &:hover {
                    .layout-option {
                        background: #ccc;
                    }
                    cursor: pointer;
                    background: #f2f4f9;
                }

                .layout-option {
                    padding: 14px 8px;
                    margin: 0 2px;
                    border-radius: 5px;
                    background: #e3e3e3;

                    &.one {
                        width: calc(50px / 1 - 1 * 4px);
                    }
                    &.two {
                        width: calc(50px / 2 - 3 * 4px);
                    }
                    &.three {
                        width: calc(50px / 3 - 3 * 4px);
                    }
                }
            }
        }
    }

    .form-elements {
        .form-rows {
            min-height: 100px;
            padding: 10px 20px;
            position: relative;
            margin: 5px 0;
            border-radius: 10px;

            &:hover {
                background: #f2f4f9;

                .row-handle {
                    display: flex;
                }

                .delete-row-btn {
                    display: block;
                }
            }

            .row-handle {
                cursor: grab;
                background-color: #ddd;
                padding: 5px;
                border-radius: 10px;
                margin-bottom: 5px;
                text-align: center;
                position: absolute;
                left: -10px;
                top: 50%;
                height: 100%;
                transform: translateY(-50%);
                display: none;
                justify-content: center;
                align-items: center;
            }

            .delete-row-btn {
                position: absolute;
                top: calc((100% - 30px) / 2);
                right: -15px;
                padding: 5px 10px;
                background-color: red;
                color: white;
                border: none;
                border-radius: 10px;
                cursor: pointer;
                display: none;

                &:hover {
                    background: #c21807;
                }
            }
        }

        .col-6, .col-4, .col-12 {
            padding-left: 5px;
            padding-right: 5px;
        }
    }
}
</style>
