<template>
    <div class="forms page-wrapper form-options">
        <div>
            <div class="heading">
                <h2>Your form has been created</h2>
                <p>Complete the process by building your form using the form builder or AI, <br>or continue with your own code</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="builder option-box" @click="buildForm('builder')">
                        <svg class="icon" width="50px" height="50px" viewBox="0 0 48 48" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 11.25C6 8.35051 8.3505 6 11.25 6H36.75C39.6495 6 42 8.3505 42 11.25V24.0436C41.2196 23.544 40.3823 23.1255 39.5 22.7999V11.25C39.5 9.73122 38.2688 8.5 36.75 8.5H11.25C9.73122 8.5 8.5 9.73122 8.5 11.25V36.75C8.5 38.2688 9.73122 39.5 11.25 39.5H22.7999C23.1255 40.3823 23.544 41.2196 24.0436 42H11.25C8.35051 42 6 39.6495 6 36.75V11.25Z" class="icon-path"/>
                            <path d="M10 21.5C10 19.0147 12.0147 17 14.5 17C16.9853 17 19 19.0147 19 21.5C19 23.9853 16.9853 26 14.5 26C12.0147 26 10 23.9853 10 21.5ZM14.5 19.5C13.3954 19.5 12.5 20.3954 12.5 21.5C12.5 22.6046 13.3954 23.5 14.5 23.5C15.6046 23.5 16.5 22.6046 16.5 21.5C16.5 20.3954 15.6046 19.5 14.5 19.5Z" class="icon-path"/>
                            <path d="M14.5 29C12.0147 29 10 31.0147 10 33.5C10 35.9853 12.0147 38 14.5 38C16.9853 38 19 35.9853 19 33.5C19 31.0147 16.9853 29 14.5 29ZM12.5 33.5C12.5 32.3954 13.3954 31.5 14.5 31.5C15.6046 31.5 16.5 32.3954 16.5 33.5C16.5 34.6046 15.6046 35.5 14.5 35.5C13.3954 35.5 12.5 34.6046 12.5 33.5Z" class="icon-path"/>
                            <path d="M21.0012 20.25C21.0012 19.5596 21.5609 19 22.2512 19H36.75C37.4404 19 38 19.5596 38 20.25C38 20.9404 37.4404 21.5 36.75 21.5H22.2512C21.5609 21.5 21.0012 20.9404 21.0012 20.25Z" class="icon-path"/>
                            <path d="M11.2632 11.0952C10.5728 11.0952 10.0132 11.6549 10.0132 12.3452C10.0132 13.0356 10.5728 13.5952 11.2632 13.5952H36.7298C37.4202 13.5952 37.9798 13.0356 37.9798 12.3452C37.9798 11.6549 37.4202 11.0952 36.7298 11.0952H11.2632Z" class="icon-path"/>
                            <path d="M46 35C46 41.0751 41.0751 46 35 46C28.9249 46 24 41.0751 24 35C24 28.9249 28.9249 24 35 24C41.0751 24 46 28.9249 46 35ZM36 28C36 27.4477 35.5523 27 35 27C34.4477 27 34 27.4477 34 28V34H28C27.4477 34 27 34.4477 27 35C27 35.5523 27.4477 36 28 36H34V42C34 42.5523 34.4477 43 35 43C35.5523 43 36 42.5523 36 42V36H42C42.5523 36 43 35.5523 43 35C43 34.4477 42.5523 34 42 34H36V28Z" class="icon-path"/>
                        </svg>
                        <h4>Form Builder</h4>
                        <p>Build and customize your forms without any coding knowldge required.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="code option-box" @click="buildForm('default')">
                        <svg class="icon" width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 8L3 11.6923L7 16M17 8L21 11.6923L17 16M14 4L10 20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h4>Custom Code</h4>
                        <p>Start accepting submissions from your custom coded form instantly.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ai option-box" @click="buildForm('ai')">
                        <svg class="icon" fill="#000000" width="50px" height="50px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.5 9.625l-0.906 2.906-0.875-2.906-2.906-0.906 2.906-0.875 0.875-2.938 0.906 2.938 2.906 0.875zM14.563 8.031l-0.438 1.469-0.5-1.469-1.438-0.469 1.438-0.438 0.5-1.438 0.438 1.438 1.438 0.438zM0.281 24l17.906-17.375c0.125-0.156 0.313-0.25 0.531-0.25 0.281-0.031 0.563 0.063 0.781 0.281 0.094 0.063 0.219 0.188 0.406 0.344 0.344 0.313 0.719 0.688 1 1.063 0.125 0.188 0.188 0.344 0.188 0.5 0.031 0.313-0.063 0.594-0.25 0.781l-17.906 17.438c-0.156 0.156-0.344 0.219-0.563 0.25-0.281 0.031-0.563-0.063-0.781-0.281-0.094-0.094-0.219-0.188-0.406-0.375-0.344-0.281-0.719-0.656-0.969-1.063-0.125-0.188-0.188-0.375-0.219-0.531-0.031-0.313 0.063-0.563 0.281-0.781zM14.656 11.375l1.313 1.344 4.156-4.031-1.313-1.375zM5.938 13.156l-0.406 1.438-0.438-1.438-1.438-0.469 1.438-0.438 0.438-1.469 0.406 1.469 1.5 0.438zM20.5 12.063l0.469 1.469 1.438 0.438-1.438 0.469-0.469 1.438-0.469-1.438-1.438-0.469 1.438-0.438z"></path>
                        </svg>
                        <h4>AI Form</h4>
                        <p>Enter a prompt to specify the form fields and get the form created by AI.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>  
import { useEventBus } from "@/EventBus";
import repository from "@/repository/repository";
import { useMainStore } from '@/store';

    export default {
        name: 'FormOptions',
        props: ['token'],
        setup() {
            const store = useMainStore();
            return {
                store
            }
        },
        computed: {
            projectId() {
                return this.store.getCurrentProject.hashId;
            },
            formId() {
                return this.$route.params.id;
            }
        },
        methods: {
            buildForm(type) {
                repository.put("/projects/" + this.projectId + "/forms/" + this.formId, {
                form_type: type
            })
                .then(() => {
                    useEventBus().emit("reloadForms");
                    this.$router.replace("/forms/" + this.formId);
                })
                .catch(error => {
                    console.error(error);
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
@import "../../scss/variables";

    .form-options {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .form-options .heading {
        text-align: center;
        margin-bottom: 50px;
    }
    .form-options .heading h2 {
        font-weight: bold;
    }
    .form-options .option-box {
        background: #fff;
        border: 1px solid #f2f4f9;
        border-radius: 10px;
        padding: 40px;
        text-align: center;
    }
    .form-options .option-box:hover {
        background: #f2f4f9;
        cursor: pointer;
    }
    .icon {
        width: 50px;
        margin-bottom: 20px;
    }
    .icon-path {
        fill: #212121;
        transition: fill 0.2s ease;
    }

    .builder {
        &:hover {
            .icon path {
                fill: $primary;
            }
        }
    }

    .ai {
        &:hover {
            .icon {
                fill: $primary;
            }
        }
    }

    .code {
        &:hover {
            .icon path {
                stroke: $primary;
            }
        }
    }
</style>
    