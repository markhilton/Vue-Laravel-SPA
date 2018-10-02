<template>
    <v-container>
        {{ welcome }}
    </v-container>
</template>

<script>
export default {
    name: 'dashboard',
    computed: {
        welcome() {
            return this.$store.getters.welcome
        }
    }
}
</script>
