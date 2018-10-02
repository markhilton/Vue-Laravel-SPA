<template>
	<v-container fill-height fluid pa-0>
		<v-container class="text-md-center" style="max-width: 500px">
			<v-card flat>

				<v-form>
					<v-card-title class="justify-center title pt-4 pb-0">
						<v-container class="ma-0 pa-0 text-xs-center">
							<v-icon color="blue-grey darken-2" size="40">
								verified_user
							</v-icon>  
						</v-container>
						
						<v-subheader>Password Reset</v-subheader>
					</v-card-title>


					<v-alert v-if="response" :type="response.result" class="mb-3">
						{{ response.message }}
					</v-alert>


					<v-card-text class="mb-0 pb-0">
						<v-text-field 
							required 
							autofocus
							name="email" 
							type="email"
							class="mr-2"
							prepend-icon="person" 
							:value="email" 
							label="E-Mail"
							:error-messages="errors.email"
						></v-text-field>
					</v-card-text>


					<v-card-actions class="mt-2 mb-2">
						<v-btn block large color="primary" :loading="processing" @click="submit()">
							Email Password Reset Link
						</v-btn>
					</v-card-actions>


					<div class="text-xs-center pb-4">
						<router-link :to="{ name: 'auth.login' }">Login</router-link>
					</div>
				</v-form>
			</v-card>
		</v-container>
	</v-container>
</template>


<script>
export default {
	data () {
		return {
			errors: {
				email: '',
			},
			email: '',
			response: false,
			processing: false,
		}
 	},

	methods: {
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
