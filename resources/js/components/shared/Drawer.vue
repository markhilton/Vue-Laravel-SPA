<template>
    <v-list>
        <div class="text-xs-center ma-4">
            <v-icon size="50">pages</v-icon>
            <h2 class="grey--text">{{ user.app.name }}</h2>
        </div>


        <v-list-tile to="/sites">
            <v-list-tile-action>
                <v-icon>web</v-icon>
            </v-list-tile-action>

            <v-list-tile-content>
                <v-list-tile-title>My Sites</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>


        <v-list-group prepend-icon="account_circle">
            <v-list-tile slot="activator">
                <v-list-tile-title>My Account</v-list-tile-title>
            </v-list-tile>

            <v-list-tile class="ml-5" to="/settings">
                <v-list-tile-action>
                    <v-icon>person</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Profile</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile class="ml-5" to="/teams">
                <v-list-tile-action>
                    <v-icon>people</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Teams</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile class="ml-5" to="/security">
                <v-list-tile-action>
                    <v-icon>security</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Security</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile class="ml-5" to="/subscriptions">
                <v-list-tile-action>
                    <v-icon>local_atm</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Subscriptions</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile class="ml-5" to="/billing">
                <v-list-tile-action>
                    <v-icon>credit_card</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Payment Methods</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>


            <v-list-tile class="ml-5" to="/invoices">
                <v-list-tile-action>
                    <v-icon>local_library</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Invoices</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list-group>




        <!-- developers accounts only -->
        <v-list-group prepend-icon="dashboard">
            <v-list-tile slot="activator">
                <v-list-tile-title>Admin Panel</v-list-tile-title>
            </v-list-tile>

            <v-list-tile class="ml-5" to="/users">
                <v-list-tile-action>
                    <v-icon>group</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Users</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile class="ml-5" to="/announcements">
                <v-list-tile-action>
                    <v-icon>record_voice_over</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Announcements</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile class="ml-5" to="/metrics">
                <v-list-tile-action>
                    <v-icon>trending_up</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Metrics</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list-group>

        <v-list-tile to="/support">
            <v-list-tile-action>
                <v-icon>mail</v-icon>
            </v-list-tile-action>

            <v-list-tile-content>
                <v-list-tile-title>Contact Support</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
    </v-list>
</template>

<script>
	export default {
        name: 'drawer',
        props: ['user'],

		data () {
			return {
			}
		},

        mounted() {
        }
	}
</script>
