<template>
  <div class="page-wrapper">

    <h4>Project Statistics</h4>
    <div class="row">
      <div class="col-md-3">
        <div class="statistic-box">
          <h2>0</h2>
          <p>Submissions Today</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="statistic-box">
          <h2>0</h2>
          <p>Submissions Today</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="statistic-box">
          <h2>0</h2>
          <p>Submissions Today</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="statistic-box">
          <h2>0</h2>
          <p>Submissions Today</p>
        </div>
      </div>
    </div>

    <h4>Your Forms</h4>
    <div class="row">

      <!-- Loading effect -->
      <div class="col-md-4 col-lg-4 col-xl-3" v-if="!forms.loaded">
        <FormBox></FormBox>
      </div>

      <div class="col-md-4 col-lg-4 col-xl-3" v-for="(form, key) in forms.items" :key="key">
        <FormBox :form="form"></FormBox>
      </div>

    </div>
  </div>
</template>

<script>
import repository from '@/repository/repository';
import { useEventBus } from '@/EventBus';
import FormBox from "@/components/items/FormBox";

export default {
  name: 'HomeView',
  components: {FormBox},
  data() {
    return {
      submissions: {
        total: 0,
        week: 0,
        month: 0,
        day: 0,
      },
      daily: [],
      loaded: false,
    }
  },
  created() {
    useEventBus().emit('reloadCurrentProject');
    useEventBus().emit('reloadProjects');

    this.loadStatistics(this.currentProject.hashId);

    useEventBus().on('reloadStatistics', () => {
      this.loadStatistics(this.currentProject.hashId);
    })
  },
  methods: {
    loadStatistics(projectId) {
      this.loaded = false;
      if (!projectId) return;
      repository.get("/projects/" + projectId + "/statistics")
        .then(response => {
          this.submissions = response.data.submissions;
          this.daily = response.data.daily;
          this.loaded = true;
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
  computed: {
      currentProject() {
        useEventBus().emit('reloadCurrentProject');
        return this.$store.getters.currentProject;
      },
      forms() {
        return this.$store.getters.forms;
      }
  },
  watch: {
      "$store.getters.currentProject.hashId"(val) {
          this.loadStatistics(val);
      }
  },
}
</script>

<style lang="scss">
@import "src/scss/variables";

.page-wrapper {
	padding: 1.5rem;
	position: relative;
    min-height: 100%;

    @include smartphone {
        padding: 0.75rem;
    }

    &.background-grey {
        background: lighten($background-grey, 1%);
    }

	h1 {
		font-weight: 600;
		font-size: 1.25rem;
		color: $dark;
		margin: 0 0 1rem 0;
	}
}

.page-inside-wrapper {
    padding: 0 1.5rem 0 0;
    // background: lighten($background-grey, 1%);

    @include smartphone {
        padding: 0 0.75rem;
    }
}

</style>
