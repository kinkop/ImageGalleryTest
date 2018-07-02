<template>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <h5 class="my-0 mr-md-auto font-weight-normal">Simple Image Gallery</h5>
        <nav class="my-2 my-md-0 mr-md-3" v-if="!user">
            <router-link :to="{name: 'login'}">Login</router-link>
        </nav>
        <nav class="my-2 my-md-0 mr-md-3" v-if="user">
            <a class="p-2 text-dark" href="#">Home</a>
        </nav>
        <nav class="my-2 my-md-0 mr-md-3" v-if="user">
            <a class="p-2 text-dark" href="#">Gallery</a>
        </nav>
        <a class="btn btn-outline-primary" href="#" v-if="!user">Register</a>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import { isAuthenticated } from '../auth'

    export default {
      name: 'app-header',
      computed: {
        ...mapState(['user'])
      },
    }
</script>