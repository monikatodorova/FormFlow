<template>
    <div class="tags-wrapper">
        <TagWidget v-for="(tag, index) in tags" :key="index" :data="tag" :submission-id="submissionId" :delete-tag="deleteTag" :mode="mode"/>
		<TagsDropdown :tags="tags" :submission-id="submissionId" :add-tag="addTag" :select-tag="selectTag" :mode="mode"></TagsDropdown>
    </div>
</template>

<script>
import TagWidget from "@/components/widgets/TagWidget";
import TagsDropdown from "@/components/widgets/TagsDropdown";

export default {
    name: "TagsWidget",
    components: {TagsDropdown, TagWidget},
    props: ['tags', 'submissionId', 'addTag', 'deleteTag', 'selectTag', 'mode'],
}
</script>