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
						<v-text-field
							required
							autofocus
							class="mr-2"
							name="email"
							label="Email"
							prepend-icon="person"
							v-model="login.email"
						></v-text-field>

						<v-text-field
							class="mr-2"
							name="password"
							type="password"
							label="Password"
							prepend-icon="lock"
							v-model="login.password"
						></v-text-field>

						<v-checkbox
							value="1"
							name="remember"
							class="ml-4 pl-2"
							v-model="login.remember"
							label="Remember Me"
						></v-checkbox>
					</v-card-text>

					<v-card-actions>
						<v-btn
							block large
							color="primary"
							@click="authenticate()"
							:loading="processing"
						>
							Login
						</v-btn>
					</v-card-actions>

					<div class="text-xs-center pb-4">
						<router-link to="/forgot-password">Forgot Your Password?</router-link>

						&nbsp; or &nbsp;

						<router-link to="/register">Register</router-link>
					</div>
				</v-form>

			</v-card>
		</v-container>
	</v-container>
</template>


<script>
    import { login } from '../../js/helpers/auth';

    export default {
        name: "login",
        data() {
            return {
                login: {
                    email:    '',
                    password: ''
                },
                error: null,
                processing:   false,
				errorMessage: false,
            };
        },
        methods: {
            authenticate() {
                this.processing = true
                this.$store.dispatch('login');

                login(this.$data.login)
                    .then((res) => {
                        this.processing = false
                        this.$store.commit('loginSuccess', res);
                        this.$router.push({ path: '/sites' });
                    })
                    .catch((error) => {
                        this.processing   = false
						this.errorMessage = error
                        this.$store.commit('loginFailed', { error });
                    });
            }
        },
        computed: {
            authError() {
                return this.$store.getters.authError;
            }
        }
    }
</script>
