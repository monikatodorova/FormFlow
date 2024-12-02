<template>
	<div class="share">
        <div class="share-box">
            <h4>Publish form</h4>
            <p>Use the link below to preview and share your form.</p>
            <div class="link">
                <input type="text" readonly :value="previewLink" class="preview-link" />
                <div v-if="!linkCoppied" style="height: 21px; width: 100%;"></div>
                <small v-if="linkCoppied">Link successfully coppied to clipboard.</small>
            </div>
            <div class="preview-buttons">
                <button class="btn btn-primary preview-button" @click="viewForm">View form</button>
                <button class="btn btn-secondary preview-button" @click="copyPreviewLink">Copy link</button>
            </div>
        </div>
        <div class="share-box">
            <h4>Embed form</h4>
            <p>Use the code below to embed the form directly on your website.</p>
            <div class="link">
                <input type="text" readonly :value="embedCode" class="embed-link" />
            </div>
            <div v-if="!codeCoppied" style="height: 21px; width: 100%;"></div>
            <small v-if="codeCoppied">Code successfully coppied to clipboard.</small>
            <div class="preview-buttons">
                <button class="btn btn-secondary preview-button" @click="copyEmbedCode">Copy value</button>
            </div>
        </div>
	</div>
</template>

<script>

export default {
    props: ['formId'],
    data() {
        return {
            loaded: false,
            codeCoppied: false,
            linkCoppied: false,
        }
    },
    computed: {
        previewLink() {
            return `http://localhost:8080/forms/${this.formId}/preview`;
        },
        embedCode() {
            const embedUrl = `http://localhost:8080/forms/${this.formId}/preview`;
            return `<iframe src="${embedUrl}" width="100%" height="600px" frameborder="0" scrolling="auto"></iframe>`;
        }
    },
    methods: {
        viewForm() {
            const previewUrl = `http://localhost:8080/forms/${this.formId}/preview`;
            window.open(previewUrl, '_blank');
        },
        copyEmbedCode() {
            const embedInput = this.$el.querySelector('.share-box .embed-link');
            embedInput.select();
            document.execCommand('copy');
            this.codeCoppied = true;

            setTimeout(() => {
                this.codeCoppied = false;
            }, 5000);
        },
        copyPreviewLink() {
            const embedInput = this.$el.querySelector('.share-box .preview-link');
            embedInput.select();
            document.execCommand('copy');
            this.linkCoppied = true;

            setTimeout(() => {
                this.linkCoppied = false;
            }, 5000);
        },
    },
}

</script>

<style scoped lang="scss">
.share-box {
    background: #fefefe;
    border: 1px solid #eee;
    border-radius: 15px;
    padding: 10px 25px 20px 25px;
    margin-bottom: 20px;

    .preview-link, .embed-link {
        background: #eee;
        height: 50px;
        padding: 10px;
        width: 100%;
        border: 1px solid #eee;
        border-radius: 8px;
    }

    .preview-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;

        .preview-button {
            width: 100%;
            margin-top: 10px;
        }
    }
    
    h4 {
        font-size: 15px;
        font-weight: 600;
    }

    p {
        font-size: 12px;
        margin-bottom: 5px;
    }

    small {
        font-size: 10px;
        margin: 0;
    }
}
</style>
