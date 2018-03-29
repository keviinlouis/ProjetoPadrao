<template>
    <picture-input
            ref="pictureInput"
            @change="onChanged"
            buttonClass="btn btn-enviar-foto"
            @remove="onRemoved"
            :removable="this.removeFoto"
            removeButtonClass="btn red btn-remover-foto"
            :height="height_imagem?height_imagem:400"
            :width="width_imagem?width_imagem:400"
            accept="image/jpeg,image/png"
            size="20"
            :zIndex="0"
            radius="20"
            :customStrings="{
              upload: '<p>Seu broswer não suporta o upload de imagens.</p>',
              drag: 'Arraste uma imagem ou <br>clique aqui para selecionar um arquivo',
              tap: 'Tap here to select a photo <br>from your gallery',
              change: 'Mudar foto',
              remove: 'Remover foto',
              select: 'Selecionar uma foto',
              selected: '<p>Arquivo selecionado!</p>',
              fileSize: 'Este arquivo é muito grande',
              fileType: 'O tipo desse aquivo não é permitido',
              aspect: 'Paisagem/Retrato'
            }">
    </picture-input>
</template>

<script>
    import axios from 'axios';
    import PictureInput from 'vue-picture-input'

    export default {
        name: "upload-foto-component",
        components: {
            'picture-input': PictureInput
        },
        props: ['loadImage', 'keyOfParent', 'removeFoto', 'height_imagem', 'width_imagem'],
        data() {
            return {
                image: null,
                nameTmp: null
            }
        },
        methods: {
            onChanged() {
                if (this.image) {
                    this.onRemoved()
                }
                if (this.$refs.pictureInput.file) {
                    this.image = this.$refs.pictureInput.file;
                    this.upload()
                } else {
                    console.log("Old browser. No support for Filereader API");
                }
            },
            onRemoved() {
                let removeNameTmp = this.nameTmp;
                this.clearImage();
                if (!removeNameTmp || removeNameTmp === '') {
                    return;
                }
                return new Promise((resolve, reject) => axios
                    .delete('/removeTmp/' + removeNameTmp)
                    .then((response) => {
                        if (response.data.success) {
                            resolve();
                            return true;
                        }
                        reject()
                    })
                    .catch(err => {
                        console.log(err)
                    })
                );
            },
            clearImage() {
                this.image = null;
                this.nameTmp = null;

            },
            upload() {
                if (!this.image) {
                    console.log('Imagem vazia');
                    return;
                }
                const formData = new FormData();
                formData.append('file', this.image);
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                };
                return new Promise((resolve, reject) => {
                    axios.post('/uploadTmp', formData, config).then(response => {
                        if (response.data.success) {
                            this.nameTmp = response.data.data;

                            resolve(response.data.data);
                            return true;
                        }
                        reject(response.data.data)

                    }).catch(err => {
                        reject(err)
                    });
                });
            }
        },
        watch: {
            nameTmp(val, oldval) {
                this.$emit('imageUpdated', {nome: val, key: this.keyOfParent});
            },
            loadImage(val, oldVal) {
                console.log(val, oldVal);
                if (val === this.nameTmp && val !== '' && !val) {
                    return;
                }
                this.$refs.pictureInput.preloadImage(val);
            }
        },
        mounted(){

        }
    }
</script>

<style>
    .btn-enviar-foto {
        padding: 9px
    }

    .btn-remover-foto {
        padding: 9px
    }
</style>