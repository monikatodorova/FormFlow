<template>
    <div>
        <Dropdown v-if="projects.loaded" class="projects-dropdown" position="right">
            <template v-slot:toggle>
                <div class="projects-dropdown-toggle">
                    <p v-if="currentProject.loaded">{{ currentProject.name }}</p>
                </div>
            </template>
            <template v-slot:content>
                <p>my projects</p>
                <hr class="d-lg-none">
				<ul>
                    <li v-for="(item, key) in projects.items" :key="key" @click="changeCurrentProject(item)">
                        {{ item.name }}
                    </li>
                </ul>
                <router-link to="/projects/new" class="dropdown-link">Create Project</router-link>
                <router-link to="/projects" class="dropdown-link">Manage Projects</router-link>
            </template>
        </Dropdown>

        <div class="profile-link loading-link" v-if="!projects.loaded">
            <span class="spinner-border"></span>
        </div>
    </div>
</template>

<script>
import repository from "@/repository/repository";
import Dropdown from "@/components/widgets/Dropdown";
import { useEventBus } from "@/EventBus";

export default {
    name: "ProjectsDropdown",
    components: {Dropdown},
    data() {
        return {}
    },
    created() {
        useEventBus().on('reloadCurrentProject', () => {
            this.loadCurrentProject();
        });

        useEventBus().on('reloadProjects', () => {
            this.loadProjects();
        })
    },
    computed: {
        projects() {
            return this.$store.getters.projects;
        },
        currentProject() {
            return this.$store.getters.currentProject;
        },
    },
    methods: {
        loadProjects() {
            repository.get("/projects")
                .then(response => {
                    this.$store.commit("updateProjects", response.data.projects);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        loadCurrentProject() {
            repository.get("/me")
                .then(response => {
                    this.$store.commit("updateCurrentProject", response.data.user.default_project)
                })
        },
        changeCurrentProject(project) {
            this.$store.commit("updateCurrentProject", project);
            repository.post("/default-project", { projectId: project.hashId })
                .then(response => {
                    console.log(response);
                })
        },
    },
}
</script>

<style lang="scss" scoped>

</style>