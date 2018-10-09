<template>
	<v-container fill-height fluid pa-0>
		<v-container class="text-md-center" style="max-width: 500px">
			<v-card flat>

				<v-form>
					<input type="hidden" name="token" :value="token">

					<v-card-title class="justify-center title pt-4 pb-0">
						<v-container class="ma-0 pa-0 text-xs-center">
							<v-icon color="blue-grey darken-2" size="40">
								verified_user
							</v-icon>  
						</v-container>
						
						<v-subheader>Password Reset</v-subheader>
					</v-card-title>


					<v-card-text class="mt-0 pt-0 mb-0 pb-0">
						<v-text-field 
							required 
							autofocus
							name="email" 
							type="email"
							class="mr-2"
							prepend-icon="person" 
							:value="email" 
							label="'E-Mail"
							error="true"
							:error-messages="errors.email"
						></v-text-field>

						<v-text-field 
							required 
							type="password"
							name="password" 
							class="mr-2"
							prepend-icon="lock" 
							label="Password"						
							:error-messages="errors.password"
						></v-text-field>

						<v-text-field 
							required 
							type="password"
							name="password_confirmation" 
							class="mr-2"
							prepend-icon="lock" 
							label="Confirm Password"
							:error-messages="errors.password"
						></v-text-field>
					</v-card-text>

					<v-card-actions class="mt-2 mb-2">
						<v-btn block large color="primary" :loading="processing" @click="submit()">
							Reset Password
						</v-btn>
					</v-card-actions>
				</v-form>

				<div class="text-xs-center pb-4">
					<router-link :to="{ name: 'auth.login' }">Login</router-link>				
				</div>

			</v-card>
		</v-container>
	</v-container>
</template>


<script>
export default {
	name: 'login',

	data () {
		return {
			token: '',
			email: '',
			errors: {
				email: '',
				password: '',
			},
			checkbox:   null,
			processing: false,
		}
 	},

	methods: {
		check() {
			this.checked = !this.checked;
		},

		submit() {
			processing = true

			axios.post('/site', this.site).then(response => {
				let data = response.data

				if (data.status == 'OK') {
					this.cancel()
					this.$emit('reload', true)
				} else {
					console.dir(data.response)
					
					if (typeof data.response == 'string') {
						this.error = data.response
					} else {
						this.errors = data.response
					}
				}
			}).catch(errors => {
				this.error = 'Whoops! Sorry, an unexpected error has occurred...'
			});
		}
	}
}
</script>
