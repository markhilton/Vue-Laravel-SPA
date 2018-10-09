<template>
    <v-app>
        <!-- toolbar only for authenticated users -->
		<toolbar v-if="isLoggedIn()" />

        <!-- <Header/> -->
        <v-content>
            <router-view></router-view>
        </v-content>
    </v-app>
</template>

<script>
    import Toolbar from './shared/Toolbar';

    export default {
        name: 'app',

        components: { Toolbar },

        data () {
			return {
				userData: {},
				authenticated: false,
			}
		},

		methods: {
			isLoggedIn() {
                return this.$store.getters.isLoggedIn
			}
		}
    }
</script>
