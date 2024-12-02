<template>
    <div>
        <h4>Form Statistics</h4>
        <div class="row md-smaller-margin">
            <div class="col-6 col-xl-3">
                <div :class="{'stats-box small-box': true, 'loading': !loaded}">
                    <img src="@/assets/icons/submissions-today.svg" class="icon" alt="Total Submission">
                    <strong>{{ this.distribution.today }}</strong>
                    <span>Submissions Today</span>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div :class="{'stats-box small-box': true, 'loading': !loaded}">
                    <img src="@/assets/icons/submissions-week.svg" class="icon">
                    <strong>{{ this.distribution.week }}</strong>
                    <span>Last 7 days</span>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div :class="{'stats-box small-box': true, 'loading': !loaded}">
                    <img src="@/assets/icons/submissions-month.svg" class="icon">
                    <strong>{{ this.distribution.month }}</strong>
                    <span>Last 30 days</span>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div :class="{'stats-box small-box': true, 'loading': !loaded}">
                    <img src="@/assets/icons/submissions-total.svg" class="icon">
                    <strong>{{ this.distribution.total }}</strong>
                    <span>Total Submission</span>
                </div>
            </div>
        </div>

        <div :class="{ 'stats-box chart-box mt-3': true, loading: !loaded }">
            <component :is="chartTypeComponent" :data="chartData" :options="chartOptions" height="400" />
        </div>

    </div>
  </template>
  
  <script>
  import { useEventBus } from '@/EventBus'
  import repository from "@/repository/repository";
  import { useMainStore } from '@/store';
  import { Line, Bar } from 'vue-chartjs'
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, PointElement, LineElement, CategoryScale, LinearScale } from 'chart.js'
  
  ChartJS.register(Title, Tooltip, Legend, BarElement, PointElement, LineElement, CategoryScale, LinearScale)
  
  export default {
    name: 'FormAnalytics',
    components: { Line, Bar },
    props: {
        formLink: String,
        chartType: {
            type: String,
            default: 'line',
        },
    },
    setup() {
        const store = useMainStore();
        return {
            store
        }
    },
    data() {
        return {
            leadStatus: (this.$route.query.status !== undefined ? this.$route.query.status : "all"),
            form: {
                name: null,
                secret: null,
                color: {
                    background: null,
                    isDarkText: null,
                },
            },
            distribution: {
                new: 0,
                seen: 0,
                today: 0,
                oldToday: 0,
                week: 0,
                oldWeek: 0,
                month: 0,
                oldMonth: 0,
                total: 0,
                oldTotal: 0,
                loaded: false,
            },
            daily: [],
            loaded: false,
        }
    },
    created: function() {
        this.loadSubmissionsDistribution();

        useEventBus().on('reloadFormSubmissions', () => {
            this.loadFormSubmissions(this.status, this.perPage, true);
        });
    },
    methods: {
        loadSubmissionsDistribution(reload = false) {
            if(!this.projectId) return;
            if(reload) {
                this.distribution.loaded = false;
                this.loaded = false;
            }
            this.distribution.oldToday = this.distribution.today;
            this.distribution.oldWeek = this.distribution.week;
            this.distribution.oldMonth = this.distribution.month;
            this.distribution.oldTotal = this.distribution.total;
            repository.get("/projects/" + this.projectId + "/forms/" + this.formId + "/statistics")
                .then(response => {
                    if (response) {
                        this.distribution.total = response.data.total;
                        this.distribution.new = response.data.new;
                        this.distribution.seen = response.data.seen;
                        this.distribution.today = response.data.today;
                        this.distribution.week = response.data.week;
                        this.distribution.month = response.data.month;
                        this.distribution.loaded = true;
                        this.daily = response.data.daily;
                        this.form.name = response.data.form.name;
                        this.form.color.background = response.data.form.color.color;
                        this.form.color.isDarkText = response.data.form.color.text === "dark";
                        this.loaded = true;
                        // this.count();
                    }
                })
                .catch(() => {
                    console.log("Failed loading submission statistics");
                })
        },
        count() {
            if(this.loaded && this.distribution.total > 0) {
                this.$refs.todaySubmissions.start();
                this.$refs.weeklySubmissions.start();
                this.$refs.monthlySubmissions.start();
                this.$refs.totalSubmissions.start();
            }
        },
        prepareDaily(submissions) {
            if (submissions.length === 0) return [];
            return Object.keys(submissions).map(key => submissions[key]);
        },
    },
    computed: {
        formId() {
            return this.$route.params.id;
        },
        projectId() {
            return this.store.getCurrentProject.hashId;
        },
        chartTypeComponent() {
            return this.chartType === 'bar' ? Bar : Line; // Dynamically select chart component
        },
        chartData() {
            return {
                labels: this.categories,
                datasets: [
                {
                    label: 'Submissions',
                    backgroundColor: this.form.color.background || '#f87979',
                    borderColor: this.form.color.background || '#f87979',
                    fill: this.chartType !== 'line',
                    data: this.prepareDaily(this.daily),
                },
                ],
            };
        },
        chartOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            color: "#aaa",
                        },
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.formattedValue;
                            },
                        },
                    },
                },
                elements: {
                    line: {
                        tension: 0.4, // Smooth curve for line chart
                    },
                },
            };
        },
        categories() {
            if (this.daily.length === 0) return [];
            return Object.keys(this.daily);
        },
    }
  }
  </script>