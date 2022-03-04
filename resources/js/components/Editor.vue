<template>
    <div id="editorjs"></div>
</template>

<script>
import EditorJS from "@editorjs/editorjs";
import Header from "@editorjs/header";
import Image from "@editorjs/image"
import List from "@editorjs/list";
import InitiateTool from "../plugins/editorjs/InitiateTool"
import EmptyTool from "../plugins/editorjs/EmptyTool"
export default {
    name: 'Editor',
    data() {
        return {
            defaultMarkup: { },
            editorInstance: null
        };
    },
    props: {
        article: Object,
        readonly: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        init() {
           this.editorInstance = new EditorJS({
                holderId: "editorjs",
                tools: {
                    header: {
                        class: Header,
                        shortcut: "CMD+SHIFT+H",
                        placeholder: "Main heading"
                    },
                    list: {
                        class: List
                    },
                    init: this.article?EmptyTool:InitiateTool,
                    image: {
                        class: Image,
                        config: {
                            uploader: {
                                /**
                                 * Upload file to the server and return an uploaded image data
                                 * @param {File} file - file selected from the device or pasted by drag-n-drop
                                 * @return {Promise.<{success, file: {url}}>}
                                 */
                                uploadByFile(file){
                                    let formData = new FormData();
                                    formData.append('image', file)
                                    return axios.post('/api/storage/images/uploadByFile', formData, {
                                        headers: {
                                            'Content-Type': 'multipart/form-data'
                                        }
                                    }).then((response) => response);
                                },
                            },
                            endpoints: {
                                byUrl: '/api/storage/images/uploadByURL',
                            }
                        }
                    }
                },
                data: this.article? this.article.body : this.defaultMarkup,
                readOnly: this.readonly,
                onReady: () => this.$emit('editorReady', this.editorInstance)
            });
        }
    },
    mounted: function() {
        this.init();
        console.log('Editor mounted', this.article, this.readonly);
    },

};
</script>

<style scoped>

</style>
