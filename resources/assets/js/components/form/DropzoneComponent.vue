<template>
    <vue-dropzone
            ref="dropzoneInput"
            id="dropzone"
            :options="dropzoneOptions"
            v-on:vdropzone-success="uploaded"
            v-on:vdropzone-removed-file="removed"/>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.css'
    import axios from 'axios'
    export default {
        name: "dropzone-component",
        components: {
            'vue-dropzone': vue2Dropzone
        },
        props: ['maxFiles', 'width', 'height', 'remove'],
        data(){
            return {
                dropzoneOptions: {
                    url: '/api/uploadTmp',
                    thumbnailWidth: this.width,
                    thumbnailHeight: this.height,
                    maxFilesize: 20,
                    maxFiles: this.maxFiles,
                    addRemoveLinks: this.remove,
                    dictDefaultMessage: 'Arraste os arquivos ou clique aqui para inserir os arquivos',
                    dictCancelUpload: 'Cancelar Upload',
                    dictRemoveFile: 'Remover',
                },
                imagens: []
            }
        },
        methods:{
            uploaded(file, response) {
                this.imagens.push({
                    nome: response.data,
                    realName: file.name,
                    isFromUrl: false
                });
                this.$emit('uploaded', response.data)
            },
            removed(file, error, xhr){
                let imagem = this.imagens.find(x => x.realName === file.name);
                if(imagem) {
                    axios.delete('/removeTmp/' + imagem.nome);
                    this.$emit('removed', {nome: imagem.nome, isFromUrl: !!imagem.isFromUrl});
                    return;
                }
                this.$emit('removed', {nome: file.name, isFromUrl: file.isFromUrl})
            },
            addFotosFromUrl(url){
                let filename = url.split('/');
                let file = { size: 123, name:  filename[filename.length-1], isFromUrl: true };
                this.$refs.dropzoneInput.manuallyAddFile(file, url);
            },
            addFotosFromArrayOfUrl(array){
                array.forEach(v => this.addFotosFromUrl(v));
            }
        }
    }
</script>

<style>
    .dz-details{
        background-color: gray !important;
    }
    .dropzone .dz-preview .dz-image{
        z-index: 0;
    }
</style>