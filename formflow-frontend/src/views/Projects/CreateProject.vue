<template>
    <div class="projects page-wrapper">
      <h2>Create project page</h2>
      <ProjectForm></ProjectForm>
    </div>
  </template>
  
  <script>
import ProjectForm from '@/components/forms/ProjectForm.vue';

  export default {
    name: 'ProjectsView',
    props: ['token'],
    components: {ProjectForm},
    computed: {
        projects() {
            this.$root.$emit('reloadProjects');
            return this.$store.getters.projects;
        },
        currentProject() {
            return this.$store.getters.currentProject;
        }
    }
  }
  </script>
  