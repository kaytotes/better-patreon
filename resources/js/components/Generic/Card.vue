<template>
    <div class="card card-default">
        <div class="card-header" v-if="hasHeader">
            <slot name="header"></slot>
        </div>

        <div class="card-body">
            <slot name="content"></slot>
        </div>

        <div class="card-footer">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import Component from 'vue-class-component';

    @Component
    export default class BCard extends Vue {
        /**
         * Whether the card has content in the Header slot.
         */
        get hasHeader() : boolean {
            return !!this.$slots.header;
        }

        /**
         * Whether card body content has been provided.
         */
        get hasContent() : boolean {
            return !!this.$slots.content;
        }

        /**
         * Whether a footer is required.
         */
        get hasFooter() : boolean {
            return !!this.$slots.footer;
        }
    }
</script>