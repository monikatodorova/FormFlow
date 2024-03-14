<template>
    <div class="h-100">
        <div class="page-inside-wrapper pt-4">
          <h1>Form Submissions</h1>
          <div class="submissions-wrapper-box">
  
              <div class="row">
                <div class="col-md-12">
                    <SubmissionsTable :form-id="formId" :status="status"></SubmissionsTable>
                </div>
              </div>
  
          </div>
        </div>
    </div>
</template>

<script>
//   import { useEventBus } from '@/EventBus';
import SubmissionsTable from '@/components/items/SubmissionsTable'
  
export default {
    name: 'FormSubmissions',
    props: ['token'],
    components: {SubmissionsTable},
    data() {
        return {
            status: (this.$route.query.status !== undefined ? this.$route.query.status : "all"),
        }
    },
    computed: {
        formId() {
            return this.$route.params.id;
        },
    },
    mounted() {
    }
  }
  </script>
  
  <style lang="scss" scoped>
  .page-wrapper {
    padding: 1.5rem;
    position: relative;
    min-height: 100%;
  }
  </style>