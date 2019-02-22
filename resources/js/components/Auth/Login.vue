<template>
    <b-card>
        <div slot="header">
            Login
        </div>

        <div slot="content">
            <p>Blah</p>
        </div>
    </b-card>
</template>

<script lang='ts'>
    import Vue from 'vue';
    import Component from 'vue-class-component';

    @Component
    export default class LoginComponent extends Vue {
        email : string = '';
        password : string = '';
        remember : boolean = false;

        login() : void {
            console.log('Logging In');
        }
    }
</script>