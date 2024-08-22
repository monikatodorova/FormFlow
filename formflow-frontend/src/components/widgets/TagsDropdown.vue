<template>
	<Dropdown :class="{'tags-dropdown': true,}">
		<template v-slot:toggle>
			<strong>{{ this.mode === 'add' ? 'Add tag' : 'Select tag to filter' }}</strong>
		</template>
		<template v-slot:content>
			<h4>Choose Tag</h4>
			<button @click.prevent="handleTagClick(tag)" v-for="(tag, key) in userTags" :key="key" class="dropdown-link">
				{{ tag.name }}
			</button>
			<p v-if="userTags.length === 0" class="small">No more tags available.</p>
		</template>
	</Dropdown>
</template>

<script>
import Dropdown from "./Dropdown";
import repository from "../../repository/repository";
import { useEventBus } from "@/EventBus";

import { useMainStore } from "@/store";

export default {
    name: "TagsDropdown",
    components: {Dropdown},
    props: ['tags', 'submissionId', 'addTag', 'selectTag', 'mode'],
	setup() {
        const store = useMainStore();
        return {
            store
        }
    },
    created() {
        this.loadTags();
    },
    methods: {
        loadTags() {
			this.store.loadingTags();
            repository.get("/tags")
                .then(response => {
					this.store.updateTags(response.data.tags);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        saveTag(tag) {
            repository.post("/submissions/" + this.submissionId + "/tags", {id: tag.hashId})
                .then(() => {
                    this.addTag(tag);
                })
                .catch(error => {
                    console.log(error);
                })
        },
		handleTagClick(tag) {
            if (this.mode === 'add') {
                this.saveTag(tag);
            } else if (this.mode === 'select') {
				useEventBus().emit('select-tag', tag);
            }
        },
    },
    computed: {
        loaded() {
			return this.store.getTags.loaded;
        },
        userTags() {
			let items = this.store.getTags.items;
            if(!Array.isArray(items)) {
                return [];
            }
            items = items.filter(item => {
                let used = false;
                this.tags.forEach(tag => {
                    if (tag.hashId === item.hashId) used = true;
                });
                return !used;
            })
            return items;
        }
    },
}
</script>

<style lang="scss">
@import "src/scss/variables";

.tags-dropdown {
	display: inline-block;
	vertical-align: middle;
	margin-bottom: 5px;

	.dropdown-toggle {
		padding: 8.7px 15px;
		border-radius: 25px;
		background: $white;
		box-shadow: $box-shadow-color 0 2px 4px;
		user-select: none;
		cursor: pointer;
		color: $dark;

		@extend .animated;

		&:hover {
			box-shadow: $box-shadow-color 0 4px 8px;
			color: $primary;

			strong:after {
				border-color: $primary;
			}
		}

		strong {
			display: block;
			font-weight: 600;
			font-size: 0.9rem;

			&:after {
				content: ' ';
				width: 8px;
				height: 8px;
				display: inline-block;
				vertical-align: middle;
				margin-left: 6px;
				margin-top: -3px;
				border-bottom: 2px solid $border-dark-grey;
				border-right: 2px solid $border-dark-grey;
				transform-origin: center;
				transform: rotate(45deg);
				@extend .animated;
			}
		}
	}
}
</style>