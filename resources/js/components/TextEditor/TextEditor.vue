<template>
    <ckeditor :editor="editor" ::value="modelValue"
              @input="$emit('update:modelValue', $event)" :config="editorConfig" ></ckeditor>
</template>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import {UploadAdapter} from "./UploadAdapter";

export default {
    name: "TextEditor",
    props: ['modelValue'],
    emits: ['update:modelValue'],
    data() {
        return {
            editor: ClassicEditor,
            editorConfig: {
                height: 500,
                mediaEmbed: {
                    previewsInData:true
                },
                extraPlugins: [function (editor) {editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                    // Configure the URL to the upload script in your back-end here!
                    return new UploadAdapter( loader, appUrl + '/api/upload-image' );
                };}]
            }
        }
    }
}
</script>

<style scoped>

</style>
