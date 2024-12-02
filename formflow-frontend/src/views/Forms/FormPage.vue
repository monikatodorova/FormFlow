<template>
    <div class="container">
        <div class="preview-form">
            <div class="form-elements" v-if="loaded">
                <form :action="formAction" method="POST" >
                    <div v-for="(row, rowIndex) in this.form.fields.rows" :key="rowIndex" class="columns">
                        <FormRowPreview :columns="row.columns"></FormRowPreview>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import repository from "@/repository/repository";
import FormRowPreview from '@/components/items/preview/FormRowPreview.vue';

export default {
    components: {FormRowPreview},
    data() {
        return {
            form: null,
            loaded: false,
        }
    },
    computed: {
      formId() {
          return this.$route.params.id;
      },
      formAction() {
        return 'http://localhost/FormFlow/formflow-landing/f/' + this.formId;
      }
    },
    methods: {
      loadForm() {
          repository.get("/forms/" + this.formId + '/preview')
          .then(response => {
              this.form = response.data;
              this.loaded = true;
          })
      }
    },
    created: function () {
        this.loadForm();
    },
}
</script>

<style lang="scss">
.preview-form {
    display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 100px;
}
</style>