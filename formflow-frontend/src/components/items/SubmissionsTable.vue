<template>
    <div class="submissions-table-wrapper">

        <div class="row align-items-center mb-3" v-if="!loaded || items.length > 0">
			<div class="col-12 col-md-6 p-0" v-if="loaded">
                <h4 class="mb-0">{{ capitalizeFirstLetter(status) }} Submissions</h4>
			</div>
            <div class="col-12 col-md-6" v-if="loaded">
                <div class="submissions-filter">
                    <div class="select-wrapper">
                        <select v-model="status" class="form-control submissions-select" style="padding: 10px 15px;">
                            <option value="all" selected>All Submissions</option>
                            <option value="new">New Submissions</option>
                            <option value="seen">Seen Submissions</option>
                        </select>
                    </div>
                    <button @click="exportSubmissions" class="btn btn-primary d-block btn-export" style="margin-left: 10px; border-radius: 0.375rem;">Export submissions</button>
                </div>
            </div>
		
        
            <!-- Submissions Table -->
            <div :class="{'submissions-table': true, 'empty-table': meta.totalSubmissions < 10, 'loading': !loaded}" ref="submissionsTable">

                <table class="table">

                    <thead>
                    <tr>
                        <th>Submission</th>
                        <th scope="col" v-for="(field) in formFields" :key="field">{{ capitalizeFirstLetter(field) }}</th>
                        <th>Submitted On</th>
                    </tr>
                    </thead>

                    <tbody>

                    <tr v-if="!loaded" class="loading-tr">
                        <td>Loading effect entry</td>
                        <td>Loading effect</td>
                        <td>Loading</td>
                    </tr>
                    <tr v-if="!loaded" class="loading-tr">
                        <td>Loading effect entry</td>
                        <td>Loading effect</td>
                        <td>Loading</td>
                    </tr>

                    <tr v-for="(submission) in items" :key="submission.hashId" :class="{ 'new': submission.status !== 'seen' }">
                        <td>
                            <router-link :to="'/submissions/' + submission.hashId" class="submission-name" :title="submission.name" @click="updateSubmissionStatus(submission.hashId, 'seen')">
                                <span :class="{'submission-avatar': true, 'text-light': submission.avatar.text === 'light', 'text-dark': submission.avatar.text === 'dark'}" :style="{backgroundColor: submission.avatar.color}">{{ submission.avatar.credentials }}</span>
                                <strong>{{ submission.name }}</strong>
                            </router-link>
                        </td>
                        <td v-for="(field) in formFields" :key="field" :title="submission.fields[field]">
                            {{ submission.fields[field] }}
                        </td>
                        <td class="submission-date">
                            {{ this.formattedDate(submission.created_at) }}
                        </td>
                    </tr>

                    </tbody>

                </table>
            </div>

            <!-- Load more & total results -->
            <div class="submissions-results d-flex align-items-center mt-2" v-if="loaded" style="justify-content: space-between;">
                <div :class="{'load-more': true, 'd-none': meta.next === null}">
                    <span v-if="!meta.loading" class="toggler" @click.prevent="loadMore">Load more</span>
                    <span v-if="meta.loading" class="spinner-border"></span>
                </div>
                <p class="small m-0">Showing {{ items.length }} out of {{ meta.totalSubmissions }} submissions</p>
                <div class="submissions-filter m-0">
                    <span>Submissions per page</span>
                    <select v-model="perPage" class="form-control">
                        <option value="20" selected>20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="all">All</option>
                    </select>
                </div>
            </div>
        </div>

		<!-- No Submissions Found -->
		<div class="submissions-no" v-if="loaded && meta.totalSubmissions === 0">
			<p v-if="this.formType === 'default'"><b>Connect your website form</b> to start receiving submissions.<br>You currently do not have submissions for this form. </p>
			<p v-if="this.formType === 'builder' || this.formType === 'ai'">
                <b>Build and share your website form</b> to start receiving submissions.<br>You currently do not have submissions for this form. 
            </p>
		</div>

    </div>
</template>

<script>
import { useEventBus } from '@/EventBus'
import repository from '@/repository/repository'
import { useMainStore } from '@/store';
import dayjs from 'dayjs';

export default {
    name: "SubmissionsTable",
    props: ['formId'],
    setup() {
        const store = useMainStore();
        return {
            store
        }
    },
    data() {
        return {
            items: [],
            perPage: 20,
            status: 'all',
            loaded: false,
            meta: {
                next: null,
                totalSubmissions: null,
                loading: false,
            }
        }
    },
    methods: {
        loadFormSubmissions(status, perPage, clear = false, scroll = false) {
            if(clear) this.items = [];
            this.loaded = false;
            if(this.formId && !this.projectId) return;
            let endpoint = '/projects/' + this.projectId + '/forms/' + this.formId + '/submissions'; 
            repository.get(endpoint + "?status=" + this.status + "&perPage=" + this.perPage)
                .then(response => {
                    this.loaded = true;
					this.items.push(...response.data.items);
					this.meta.next = response.data.cursor;
					this.meta.totalSubmissions = response.data.total;
                    if(scroll) {
                        this.$nextTick(() => {
                            window.scrollTo(0, 1000);
                        });
                    }
                })
                .catch(() => {
                    console.log("error");
                })
        },
        loadMore() {
			if(this.formId && !this.projectId) return;
			if (this.meta.loading) return;
			this.meta.loading = true;
			let submissionsEndpoint = (this.formId ? '/projects/' + this.projectId + '/forms/' + this.formId + '/submissions' : 'submissions');
			repository.get(submissionsEndpoint + "?status=" + this.status + "&perPage=" + this.perPage + (this.formId ? "&form=" + this.formId : "") + (this.meta.next ? "&cursor=" + this.meta.next : ""))
				.then(response => {
					this.meta.loading = false;
					this.items.push(...response.data.items);
					this.meta.next = response.data.cursor;
					this.meta.totalSubmissions = response.data.total;
				})
                .catch(() => {
                })
		},
        capitalizeFirstLetter(str) {
			return str.toLowerCase().charAt(0).toUpperCase() + str.slice(1);
		},
        updateSubmissionStatus(id, status) {
			this.items.filter(item => item.hashId === id)[0].status = status;
		},
        formattedDate(submitedOn) {
            return dayjs(submitedOn).format('MMMM D, YYYY, h:mm A');
        },
        exportSubmissions() {
        let endpoint = '/forms/' + this.formId + '/submissions/export'
        repository.get(endpoint)
            .then(response => {
                const blob = new Blob([response.data], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = window.URL.createObjectURL(blob);
                link.href = url;
                link.setAttribute('download', 'submissions.csv');
                document.body.appendChild(link);
                link.click();
                link.parentNode.removeChild(link);
                window.URL.revokeObjectURL(url);
            })
            .catch(error => {
                console.error('Error exporting submissions:', error);
            });
        },
        
    },
    created() {
        this.loadFormSubmissions(this.status, this.perPage, true);

        useEventBus().on('reloadFormSubmissions', () => {
            this.loadFormSubmissions(this.status, this.perPage, true);
        });
    },
    computed: {
        projectId() {
            return this.store.getCurrentProject.hashId;
        },
        formType() {
            return this.store.getCurrentForm.type;
        },
        formFields() {
            let fields = [];
            this.items.forEach(submission => {
                Object.keys(submission.fields).forEach(fieldKey => {
                    if(!fields.includes(fieldKey)) {
                        fields.push(fieldKey);
                    }
                })
            })
            return fields;
		}
    },
    mounted() {
        useEventBus().emit('reloadProjects');
        useEventBus().emit('reloadCurrentProject');
    },
    watch: {
		status(newStatus) {
			this.loadFormSubmissions(newStatus, this.perPage, true);
		},
		perPage(newPerPage) {
			this.loadFormSubmissions(this.status, newPerPage, true, true);
		},
		items(val) {
			if (this.loaded && val.length <= 0 && this.meta.next) {
				this.loadMore();
			}
		},
		formId() {
			this.loadFormSubmissions(this.status, this.perPage, true);
		},
		projectId: function (newValue, oldValue) {
            if(oldValue === null && newValue !== null && this.formId) {
                this.loadFormSubmissions(this.status, this.perPage, true);
            } else {
                if (this.$route.path !== "/") this.$router.replace("/");
            }
		},
	}
}
</script>

<style lang="scss" scoped>
@import "src/scss/variables";

.submissions-filter {
    position: relative;
}

.select-wrapper {
    position: relative;
}

.submissions-select {
    padding-right: 30px;
    width: 100%;
}

.select-wrapper::after {
    display: inline-block;
    vertical-align: middle;
    width: 6px;
    height: 6px;
    transform-origin: center;
    transform: rotate(45deg);
    border-bottom: 2px solid #0E122E;
    border-right: 2px solid #0E122E;
    content: " ";
    margin-left: auto;
    margin-top: -2px;
    opacity: 0.25;
    right: 10px;
    top: 50%;
    position: absolute;
    pointer-events: none;
}


.submissions-table-wrapper {
	padding: 0 1.5rem 0 1.5rem;

	@include smartphone {
		padding: 0.75rem;
	}

    h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: $dark;
        margin: 1rem 0;
    }
}

.submissions-filter {
    display: flex;
    align-items: center;
    justify-content: flex-end;

    @include smartphone {
        justify-content: flex-start;
    }

    .form-control {
        padding: 0.5rem;
        height: auto;
        margin-left: 0.5rem;
        width: auto;
        box-shadow: none;
        border: 1px solid $border-dark-grey;
    }

    span {
        flex-shrink: 0;
        color: $dark;
        font-size: 0.9rem;
    }
}

.submissions-table {
    width: calc(100% + 3rem);
    margin: 0 -1.5rem;
	padding: 0 1.5rem;
    overflow-y: scroll;
    overflow-x: scroll;
    height: calc(100svh - 11.7rem - 65px);

    &.empty-table {
        height: auto;
    }

    &.loading {
        overflow: hidden;

        .table {
            border-collapse: separate;
            border-spacing: 1rem;

            thead {
                box-shadow: none;

                tr {
                    th {
                        color: transparent;
                        background: rgba($background-grey, 0.85);
                        border-radius: $box-border-radius;
                        user-select: none;
                        pointer-events: none;

                        &:nth-child(n+2) {
                            background: none;
                            transform: none;
                        }
                    }
                }
            }

            tbody {
                tr {
                    background: none !important;
                    border: none;

                    &:hover {
                        background: none !important;
                    }

                    td {
                        color: transparent;
                        user-select: none;
                        pointer-events: none;
                    }

                    &.loading-tr {
                        width: 100%;

                        td {
                            color: transparent;
                            background: rgba($background-grey, 0.5);
                            border-radius: $box-border-radius;
                            user-select: none;
                            pointer-events: none;
                            transform: translateX(0.5rem);
                            height: 0.5rem;
                            padding: 0.5rem;
                        }
                    }
                }
            }

            .submission-name {
                color: inherit;

                .submission-avatar {
                    opacity: 0;
                }
            }
        }
    }

	@include smartphone {
		width: calc(100% + 1.5rem);
		margin: 0 -0.75rem;
		padding: 0 0.75rem;
	}
    

	.table {
        min-width: fit-content;
        margin: 0 -1.5rem;

        @include smartphone {
            margin: 0 -0.75rem;
        }

        thead {
            position: sticky;
            top: 0;
            background: $white;
            border-top: none;
            left: 0;
            box-shadow: rgba($dark, 0.05) 0 0.15rem 0.25rem;

            tr {
                border-top: none;
                border-bottom: none;

                th {
                    border-top: none;
                    border-bottom: none;
                    font-size: 1rem;
                    font-weight: 600;
                    padding: 1rem;
                    width: 200px;

                    &:first-child {
                        padding-left: 1.5rem;

                        @include smartphone {
                            padding-left: 0.75rem;
                        }
                    }

                    &:last-child {
                        padding-right: 1.5rem;

                        @include smartphone {
                            padding-left: 0.75rem;
                        }
                    }
                }
            }
        }

		tbody {
            overflow-x: auto;
            border-top: none;

            tr {
                border-top: 1px solid rgba($dark, 0.05);
                @extend .animated;

                &.new {
                    td {
                        background: lighten($primary, 52%);
                    }
                }

                &:hover {
                    td {
                        background: lighten($background-grey, 0%) !important;
                    }
                }

                td {
                    padding: 1rem 1rem;
                    font-size: 0.9rem;
                    color: $dark;
                    border: none;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    vertical-align: middle;
                    word-wrap: break-word;
                    max-width: 250px;

                    &:first-child {
                        padding-left: 1.5rem;

                        @include smartphone {
                            padding-left: 0.75rem;
                        }
                    }

                    &:last-child {
                        padding-right: 1.5rem;

                        @include smartphone {
                            padding-left: 0.75rem;
                        }
                    }
                }
            }
		}

        .submission-name {
            display: flex;
            align-items: center;
            width: 180px;
            text-decoration: none;
            color: $dark;

            &:hover {
                color: $primary;

                .submission-avatar {
                    box-shadow: rgba($primary, 1) 0 0 0 0.15rem;
                }

                strong {
                    text-decoration: underline;
                }
            }

            .submission-avatar {
                width: 2.5rem;
                height: 2.5rem;
                flex-shrink: 0;
                border-radius: 50%;
                line-height: 2.5rem;
                text-transform: uppercase;
                font-weight: bold;
                font-size: 0.8rem;
                text-align: center;
                margin-right: 0.5rem;
            }

            strong {
                font-weight: 600;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }
	}
}


.submissions-results {
    .load-more {
        transition: 0.5s ease all;
        user-select: none;
        width: 6rem;
        margin-right: 1rem;

        span.toggler {
            cursor: pointer;
            font-weight: 600;
            color: $dark;
            font-size: 0.9rem;

            &:hover {
                color: $primary;

                &:after {
                    border-color: $primary;
                }
            }

            &:after {
                content: ' ';
                display: inline-block;
                vertical-align: middle;
                width: 8px;
                height: 8px;
                margin-top: -5px;
                margin-left: 5px;
                border-bottom: 2px solid $dark;
                border-right: 2px solid $dark;
                transform-origin: center;
                transform: rotate(45deg);
            }
        }

        span.spinner-border {
            width: 20px;
            height: 20px;
            border-width: 3px;
            border-color: $border-darker-grey;
            border-right-color: transparent;
        }

        @include smartphone {
            padding-top: 5px;
            padding-bottom: 15px;
        }
    }

    p.small {
        line-height: 21px;
    }
}
</style>