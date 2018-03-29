<template>
    <div v-html="require(`./../../../images/sidebar/${icon}.svg`)"></div>
</template>

<script>
    export default {
        name: 'side-bar-icon',
        props: ['icon']
    }
</script>