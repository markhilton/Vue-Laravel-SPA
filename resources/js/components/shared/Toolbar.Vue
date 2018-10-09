<template>
	<div>
		<!-- navigation drawer -->
		<v-navigation-drawer v-model="drawer" app temporary>
			<drawer></drawer>
		</v-navigation-drawer>


		<!-- top toolbar -->
		<v-toolbar dark color="primary" app>
			<v-toolbar-side-icon @click.stop="drawer=!drawer"></v-toolbar-side-icon>
			<v-toolbar-title>My Sites</v-toolbar-title>

			<v-spacer></v-spacer>

			<!-- user notifications badge -->
			<v-btn icon @click.stop="openNotificationsDrawer()">
				<v-badge :color="notificationsCount ? 'orange' : 'green'">
					<span slot="badge">{{ notificationsCount }}</span>
					<v-icon v-if="notificationsCount">notifications_active</v-icon>
					<v-icon v-else>notifications</v-icon>
				</v-badge>
			</v-btn>


			<!-- main menu with ml-3 - margin, left, size 3 -->
			<v-menu class="ml-4">
				<!-- user profile avatar -->
				<v-avatar slot="activator" size="32" class="mr-2">
					<v-img :src="currentUser.photo_url" :alt="currentUser.name" />
				</v-avatar>

				<!-- drop down menu -->
				<v-card light>
					<v-list>
						<v-list-tile avatar>
							<v-list-tile-avatar @click="$emit('settings')">
								<v-img :src="currentUser.photo_url" :alt="currentUser.name" />
							</v-list-tile-avatar>


							<!-- user account profile -->
							<v-list-tile-content>
								<v-list-tile-title>{{ currentUser.name }}</v-list-tile-title>
								<v-list-tile-sub-title>
									{{ currentUser.type }}
								</v-list-tile-sub-title>
							</v-list-tile-content>


							<!-- account impersonator -->
							<v-list-tile-action v-if="impersonator">
								<v-tooltip bottom>
									<v-btn fab small dark slot="activator" color="primary" href="/spark/kiosk/users/stop-impersonating">
										<v-icon>exit_to_app</v-icon>
									</v-btn>
									<span>Stop impersonating username</span>
								</v-tooltip>
							</v-list-tile-action>
						</v-list-tile>
					</v-list>


					<v-divider></v-divider>


					<!-- Logout -->
					<v-divider></v-divider>
					<v-btn block small color="error" @click.prevent="logout">Logout</v-btn>
				</v-card>
			</v-menu>
		</v-toolbar>
	</div>
</template>

<script>
	import Drawer from './Drawer';

	export default {
		name: 'toolbar',

		components: { Drawer },

		data () {
			return {
				drawer: null,
				notificationsCount: 3,
				impersonator: false
			}
		},

		methods: {
            logout() {
                this.$store.commit('logout');
                this.$router.push('/login');
            }
        },

        computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
        }

	}
</script>
