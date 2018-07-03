<template>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <h3 class="my-0 mr-md-auto font-weight-normal">Simple Image Gallery</h3>
        <nav class="my-2 my-md-0 mr-md-3" v-if="!user">
            <router-link :to="{name: 'login'}">Login</router-link>
        </nav>
        <nav class="my-2 my-md-0 mr-md-3" v-if="user">
            <router-link :to="{name: 'root'}" lass="p-2 text-dark">Home</router-link>
        </nav>
        <nav class="my-2 my-md-0 mr-md-3" v-if="user">
            <router-link :to="{name: 'gallery'}" lass="p-2 text-dark">Gallery</router-link>
        </nav>
        <a class="btn btn-outline-primary" href="#" v-if="!user">Register</a>
        <a class="btn btn-outline-primary" v-if="user" @click="doLogout">Logout</a>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex'
    import swal from 'sweetalert'

    export default {
      name: 'app-header',
      computed: {
        ...mapState(['user'])
      },
      methods: {
        ...mapActions(['logout']),
        doLogout() {
            this.logout()
              .then((result) => {
                this.$router.push({
                  name: 'login'
                })
              })
              .catch((error) => {
                swal('Could not logout.', _.get(error, 'response.data.message'), 'error')
              })
        }
      }
    }
</script>