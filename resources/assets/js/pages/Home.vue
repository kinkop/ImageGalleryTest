<template>
    <div>
        <div class="row">
            <div class="col-md-12 bg-white" style="padding: 20px;">
                <h5>Disk Usage Overview</h5>
                <hr />
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <td width="20%">
                            Total size:
                        </td>
                        <td>{{ totalSize | toMb }}MB ({{ totalSize | comma }}B)</td>
                    </tr>
                    <tr>
                        <td>
                            No of files:
                        </td>
                        <td>
                            {{ totalFiles }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12 bg-white" style="padding: 20px;">
                <h5>Disk Usage Compositions</h5>
                <hr />
                <table class="table" style="border-top: none;">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>No of files</th>
                        <th>Size</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr
                                v-for="(mimeType, index) in mimeTypes"
                                :key="index.toString()"
                        >
                            <td>
                                {{ mimeType.name }}
                            </td>
                            <td>
                                {{ mimeType.files }}
                            </td>
                            <td>
                                {{ mimeType.size | toMb }}MB ({{  mimeType.size | comma }}0KB)
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions} from 'vuex'
    import numeral from 'numeral'

    export default {
      name: 'home',
      data() {
        return {
          imageData: null,
          totalSize: 0,
          totalFiles: 0,
          mimeTypes: []
        }
      },
      methods: {
        ...mapActions(['getImageUploads'])
      },
      created() {
        this.getImageUploads()
          .then((response) => {
            this.imageData = response.data
          })
          .catch((err) => {

          })
      },
      watch: {
        imageData: {
          handler: function (newValue) {
            if (this.imageData) {
              this.totalSize = this.imageData.meta.summary.overview.size
              this.totalFiles = this.imageData.meta.summary.overview.files
              this.mimeTypes = this.imageData.meta.summary.composition
            }
          },
          deep: true
        }
      },
      filters: {
        toMb(value) {
          if (value > 0) {
            value = value / 1024 / 1024
            return numeral(value).format('0,0.00')
          }

          return value;

        },
        comma(value) {
          return numeral(value).format('0,0.00')
        }
      }
    }
</script>

<style scoped type="text/css">
    table thead th {
        border-top: none !important;
    }
</style>