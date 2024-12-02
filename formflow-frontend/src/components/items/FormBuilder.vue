<template>
	<div class="form-builder">
        <div class="row">
            <div class="col-md-8">
                <div class="builder">
                    <BuildForm ref="buildForm" @choose-element-sidebar="showElementsSidebar" @manage-element-sidebar="showManageSidebar" 
                        :fields="currentForm.fields" :currentForm="currentForm" :type="'builder'" :generated="true"></BuildForm>
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
            store
        }
	},
    data() {
        return {
            loaded: false,
            chooseElementSidebar: false,
            manageElementSidebar: false,
        }
    },
    computed: {
        currentForm() {
            return this.store.getCurrentForm;
        },
        projectId() {
            return this.store.getCurrentProject.hashId;
        },
        selectedField() {
            return this.$refs.buildForm.getSelectedField();
        }
    },
    methods: {
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
