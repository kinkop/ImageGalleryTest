<template>
    <div>
        <div class="row">
            <div class="col-md-12 bg-white" style="padding: 20px;">
                <h5>Gallery</h5>
                <hr />
                <vue-dropzone
                        id="dropzone"
                        ref="myVueDropzone"
                        :options="dropzoneOptions"
                        @vdropzone-upload-progress="onUploadProgress"
                        @vdropzone-error="onFileError"
                        @vdropzone-success="onUploadSuccess"
                        @vdropzone-file-added-manually="onFileManuallyAdded"
                ></vue-dropzone>
                <div id="customdropzone" class=" dropzone"></div>
            </div>
        </div>
    </div>
</template>

<script>
  import vue2Dropzone from 'vue2-dropzone'
  import 'vue2-dropzone/dist/vue2Dropzone.min.css'
  import { mapActions} from 'vuex'
  import lightbox2 from 'lightbox2'
  import 'lightbox2/dist/css/lightbox.min.css'

  export default {
     name: 'gallery',
     components: {
       vueDropzone: vue2Dropzone
     },
    data() {
      return {
        dropzoneOptions: {
          url: '/api/image-upload',
          thumbnailWidth: 300,
          thumbnailHeight: 300,
          maxFilesize: 10,
          acceptedFiles: 'image/jpeg,image/png',
          resizeMethod: 'crop',
          dictDefaultMessage: '<i class="fa fa-cloud-upload fa-4x"></i><br/>Drop files here or click to choose files...',
          previewsContainer: '#customdropzone',
          previewTemplate: this.template(),
          headers: {
            'Authorization': 'Bearer ' + this.$store.state.user.access_token
          },
          chunking: true
        },
        dropzoneFiles: {}
      }
    },
    methods: {
      ...mapActions(['getImageUploads', 'deleteImageUpload']),
      template: function () {
        return `
           <div class="dz-preview dz-image-preview">
              <div class="dz-details">
                <a class="btn btn-primary image-show" data-lightbox="roadtrip"><span class="fa fa-search-plus"></span></a>
                <button class="btn btn-danger remove-file"><span class="fa fa-trash-o"></span></button>
                <button class="btn btn-danger remove-file-error" style="display: none;" data-dz-remove><span class="fa fa-trash-o"></span></button>
              </div>

               <div class="thumbnail">
                   <img data-dz-thumbnail />
               </div>

               <div class="custom-progress">
                    0%
                </div>

              <div class="error">
                    <i class="fa fa-exclamation-triangle fa-4x" style="font-size:48px;color:red"></i>
                    <p style="color:red" class="error-text"></p>
                </div>
            </div>
        `;
      },
      onUploadProgress(file, progress, bytesSent) {
        const preview = $(file.previewElement)
        $('.custom-progress', preview).text(progress + '%')
      },
      onFileError(file, message) {
        const preview = $(file.previewElement)
        $('.dz-details .btn-primary', preview).remove();
        $('.error .error-text', preview).text(message);
        $('.error', preview).show();
        $('img', preview).remove();
        $('.custom-progress', preview).remove();
        $('.dz-details', preview).show();
        $('.remove-file-error', preview).show();
        $('.remove-file', preview).hide();

      },
      onUploadSuccess(file, response) {
        const preview = $(file.previewElement)
        $('.thumbnail', preview).show();
        $('.custom-progress', preview).remove();
        $('.dz-details', preview).show();
        $('.image-show', preview).attr('href', response.data.file_url);
        file.id = response.data.id
        file.file_url = response.data.file_url
        $('.remove-file', preview).attr('data-id', file.id);
        this.dropzoneFiles[file.id] = file

        this.$nextTick(() => {
          this.triggerRemoveFile()
        })
      },
      onFileManuallyAdded(file) {
        const preview = $(file.previewElement)
        $('.thumbnail', preview).show();
        $('.custom-progress', preview).remove();
        $('.dz-details', preview).show();
        $('.image-show', preview).attr('href', file.file_url);
        $('.remove-file', preview).attr('data-id', file.id);

        this.dropzoneFiles[file.id] = file
        this.$nextTick(() => {
          this.triggerRemoveFile()
        })
      },

      triggerRemoveFile(){
        $('.remove-file').unbind('click')
        $('.remove-file').bind('click', (e) => {
          let id = $(e.target).closest('.remove-file').data('id')
          this.$refs.myVueDropzone.removeFile(this.dropzoneFiles[id])
          this.deleteImageUpload(id)
        })
      }
    },
    created() {
      this.getImageUploads()
        .then((response) => {
          //console.log(response)
          response.data.data.forEach(item => {
            let file = {
              id: item.id,
              name: item.filename,
              size: item.size,
              file_url: item.file_url
            }

            this.$refs.myVueDropzone.manuallyAddFile(
              file,
              item.file_url
            )
          })
        })
    }
   }
</script>


<style>
    .dz-preview {
        width: 300px !important;
        height: 300px !important;
        border: 1px solid #cccccc;
    }
     .dz-preview .dz-details {
        background-color: rgba(105, 109, 113, 0.6) !important;
        text-align: center !important;
        height: 300px !important;
        display: none;
    }

    .dz-preview .error {
        text-align: center;
        margin-top: 100px;
        display: none;
    }

    .dz-preview .thumbnail {
        display: none;
    }

    .dz-preview .custom-progress {
        text-align: center !important;
        line-height: 300px !important;
        font-size: 1.6em !important;
    }
</style>