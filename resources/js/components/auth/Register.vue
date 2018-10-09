<template>
	<v-container fill-height pa-0>
		<v-container style="max-width: 500px">
			<v-card flat>

				<v-form>
					<div v-if="errorMessage">
						<v-alert
							v-if="errorMessage"
							:value="true"
							type="error"
							icon="warning"
							class="mb-3 text-md-center"
						>
							Provided username or password is invalid!
						</v-alert>
					</div>
					<div v-else>
						<v-card-title class="justify-center hidden-sm-only">
							<v-icon color="blue-grey darken-2" size="47">
								account_circle
							</v-icon>
						</v-card-title>
					</div>


					<v-card-text class="mb-0 pb-0">
						<v-layout row wrap>
							<v-flex xs12 sm6>
								<v-text-field
									autofocus
									required
									class="mr-2"
									label="Name"
									prepend-icon="person"
									v-model="register.name"
									:error-messages="errors.name"
								></v-text-field>
							</v-flex>
							<v-flex xs12 sm6>
								<v-text-field
									required
									class="mr-2"
									label="Email"
									prepend-icon="email"
									v-model="register.email"
									:error-messages="errors.email"
								></v-text-field>
							</v-flex>
							<v-flex xs12 sm6>
								<v-text-field
									required
									class="mr-2"
									type="password"
									label="Password"
									prepend-icon="lock"
									v-model="register.password"
									:error-messages="errors.password"
								></v-text-field>
							</v-flex>
							<v-flex xs12 sm6>
								<v-text-field
									required
									class="mr-2"
									type="password"
									label="Confirm password"
									prepend-icon="lock"
									v-model="register.confirm"
									:error-messages="errors.password"
								></v-text-field>
							</v-flex>
						</v-layout>

						<v-checkbox
							value="1"
							name="remember"
							class="ml-4 pl-2"
							v-model="register.tos"
							:error-messages="errors.tos"
						>
							<template slot="label">
								Accept &nbsp; <a href="#" @click.prevent="dialog=true">Terms of Service</a>
							</template>
						</v-checkbox>
					</v-card-text>

					<v-card-actions>
						<v-btn
							block large
							color="primary"
							@click.prevent="submit()"
							:loading="processing"
						>
							Register
						</v-btn>
					</v-card-actions>

					<div class="text-xs-center pb-4">
						Already have an account?
						<router-link to="/login">Login</router-link>
					</div>
				</v-form>

			</v-card>

			<!-- terms of service dialog -->
			<tos :dialog="dialog" @close="close()" />
		</v-container>
	</v-container>
</template>


<script>
	import tos from './Tos';

    export default {
        name: "register",
		components: { tos },
        data() {
            return {
                register: {
                },
                errors: {
				},
				dialog: false,
                processing: false,
				errorMessage: false,
            };
        },
        methods: {
            submit() {
                this.processing = true
                axios.post('/api/auth/register', this.register)
                    .then(response => {
                        this.processing = false
						// sweet alert confirmation
                        // this.$router.push({ path: '/login' });
                    })
                    .catch(error => {
                        this.processing = false
						this.errors = error.data.error
                    });
            },
			close() {
				this.dialog = false
			}
        }
    }
</script>
