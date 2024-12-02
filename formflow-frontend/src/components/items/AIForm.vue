<template>
	<div class="form-builder">
        <div class="row">
            <div class="col-md-8">
                <div class="builder">
                    <div class="ai-section">
                    <h4>AI-Generated Form</h4>
                    <div class="prompt-message" v-if="generatedByAI">
                        "{{ this.currentForm.prompt ? this.currentForm.prompt : this.formDescription  }}"
                    </div>
                    <p v-if="!generatedByAI">Describe the type of form you need, and we'll generate it for you.</p>
                    <div class="ai-input-elements">
                        <input
                            :disabled="generatedByAI"
                            v-if="!generatedByAI"
                            v-model="formDescription"
                            type="text"
                            placeholder="Eg: A contact form with fields for name, email, and a message."
                            class="form-control form-field ai-input"
                        />
                        <button
                            v-if="!generatedByAI"
                            class="btn btn-primary ai-button"
                            @click="callGenerateFormWithAI"
                            :disabled="loading"
                        >
                            {{ loading ? "Generating..." : "Generate Form" }}
                        </button>
                    </div>
                </div>
                <div>
                    <BuildForm ref="buildForm" @choose-element-sidebar="showElementsSidebar" @manage-element-sidebar="showManageSidebar" 
                        :fields="currentForm.fields" :currentForm="currentForm" :type="'ai'" :generated="generatedByAI"></BuildForm>
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sidebar">
                    <button class="btn btn-primary save-form" @click="updateForm" v-if="!chooseElementSidebar && !manageElementSidebar" style="padding: 15px 20px; width: 100%; margin-bottom: 20px;">Save form</button>
                    <ShareForm :form-id="formId" v-if="!chooseElementSidebar && !manageElementSidebar"></ShareForm>
                    <ElementSidebar v-if="chooseElementSidebar" @hide-element-sidebar="hideElementsSidebar" @field-selected="addFieldToActiveColumn"></ElementSidebar>
                    <ManageSidebar v-if="manageElementSidebar" @hide-manage-sidebar="hideManageSidebar" @field-update="updateField" @field-delete="deleteField" :selectedField="selectedField"></ManageSidebar>
                </div>
            </div>
        </div>
	</div>
</template>

<script>
import ShareForm from './ShareForm.vue';
import BuildForm from './builder/BuildForm.vue';    
import ElementSidebar from './builder/ElementSidebar.vue';
import ManageSidebar from './builder/ManageSidebar.vue';
import repository from "@/repository/repository"; 
import { useMainStore } from '@/store';

export default {
    name: 'FormBuilder',
    props: ['formId'],
    components: {ShareForm, BuildForm, ElementSidebar, ManageSidebar},
    setup() {
        const store = useMainStore();
        return {
            store,
        }
	},
    data() {
        return {
            loaded: false,
            chooseElementSidebar: false,
            manageElementSidebar: false,
            formDescription: "",
            loading: false,
            fields: null,
            byAi: false,
        }
    },
    computed: {
        currentForm() {
            console.log(this.store.getCurrentForm);
            return this.store.getCurrentForm;
        },
        projectId() {
            return this.store.getCurrentProject.hashId;
        },
        selectedField() {
            return this.$refs.buildForm.getSelectedField();
        },
        generatedByAI() {
            if (!this.byAi) {
                return this.currentForm.type === 'ai' && this.currentForm.fields !== null;
            }
            return this.byAi;
        },
        promptMessage() {
            if (!this.byAi && this.currentForm.type === 'ai' && this.currentForm.fields !== null && this.currentForm.prompt !== null) {
                return this.currentForm.prompt;
            }
            return this.formDescription;
        }
    },
    methods: {
        updateBuilderFields() {
            this.$refs.buildForm.updateFields(this.fields);
        },
        async callGenerateFormWithAI() {
            try {
                await this.generateFormWithAI();
                this.updateBuilderFields();
                this.byAi = true;
            } catch (error) {
                console.error("Error generating form:", error);
            }
        },
        async generateFormWithAI() {
            if (!this.formDescription) {
                alert("Please enter a form description.");
                return;
            }

            this.loading = true;

            try {
                await repository.post("/projects/" + this.projectId + "/forms/" + this.formId + "/generate-form", {
                    description: this.formDescription,
                })
                    .then(response => {
                        this.fields = response.data.fields;
                        this.currentForm.fields = JSON.parse(response.data.fields);
                        this.currentForm.prompt = this.formDescription;
                        this.currentForm.form_type = 'ai';
                        this.store.updateCurrentForm(this.currentForm);
                    })
                    .catch(error => {
                        let message = error.response.data.message;
                        this.error = message + " Please try again.";
                    })
            } catch (error) {
                alert("Failed to generate the form. Please try again.");
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        updateForm() {
            this.error = false;

            repository.put("/projects/" + this.projectId + "/forms/" + this.formId, {
                fields: this.$refs.buildForm.getFields()
            })
                .then(response => {
                    if (response) {
                        this.currentForm.fields = this.$refs.buildForm.getFields();
                        this.store.updateCurrentForm(this.currentForm);
                    }
                })
                .catch(error => {
                    let message = error.response.data.message;
                    this.error = message + " Please try again.";
                })
        },
        showElementsSidebar() {
            this.chooseElementSidebar = true;
            this.manageElementSidebar = false;
        },
        hideElementsSidebar() {
            this.chooseElementSidebar = false;
        },
        showManageSidebar() {
            this.manageElementSidebar = true;
            this.chooseElementSidebar = false;
        },
        hideManageSidebar() {
            this.manageElementSidebar = false;
        },
        addFieldToActiveColumn(field) {
            this.$refs.buildForm.addFieldToColumn(field);
            this.hideElementsSidebar();
        },
        updateField(field) {
            this.manageElementSidebar = false;
            this.$refs.buildForm.updateField(field);
        },
        deleteField() {
            this.$refs.buildForm.deleteField();
        },
    }
}

</script>

<style scoped lang="scss">
.ai-section {
    border: 1px solid #eee;
    padding: 40px;
    margin-bottom: 20px;
    border-radius: 15px;

    .ai-input-elements {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .ai-input {
        height: 50px;
        width: 75%;
    }

    .ai-button {
        height: 50px;
    }

    .prompt-message {
        border: 1px solid #eee;
        background: #eee;
        padding: 15px;
        border-radius: 15px;
    }
}
.form-builder {
    .builder {
        overflow-y: scroll;
        // max-height: 580px;
    }
    .sidebar {
        overflow-y: auto;
        // max-height: 580px;
    }
}
</style>
