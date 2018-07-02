<template>
    <div>
        <app-header></app-header>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import AppHeader from './components/Header'

    export default {
      name: 'app-container',
      components: {
        AppHeader
      }
    }
</script>