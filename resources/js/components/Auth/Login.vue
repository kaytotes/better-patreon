<template>
    <div class="card card-default">
        <div class="card-header">Login</div>

        <div class="card-body">
            
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import Component from 'vue-class-component';

    @Component
    export default class LoginComponent extends Vue {
        created() : void {
            console.log('Created');
        }

        mounted() : void {
            console.log('Mounted');
        }
    }
</script>