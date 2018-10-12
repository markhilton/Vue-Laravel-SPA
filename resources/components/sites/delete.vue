<template>
	<v-layout row justify-center>
		<v-dialog v-model="dialog" persistent max-width="500px">

			<v-card>
				<v-card-title primary-title class="headline red white--text">
					Delete Site
				</v-card-title>

				<v-card-text>
					<v-container grid-list-md>
						<v-layout wrap>
							<p>Confirm site destruction by typing <b>DELETE</b> below</p>

							<v-flex xs12>
								<v-text-field v-model="text" label="Confirm" required :error-messages="error"></v-text-field>
							</v-flex>
						</v-layout>
					</v-container>
				</v-card-text>

				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="blue darken-1" flat @click.native="cancel()">Cancel</v-btn>
					<v-btn color="blue darken-1" flat @click.native="destroy()">Delete</v-btn>
				</v-card-actions>
			</v-card>

		</v-dialog>


		<v-snackbar
			v-model="snackbar"
			top="top"
			multi-line="multi-line"
			:timeout="6000"
			>

			The requested site has been deleted!

			<v-btn color="pink" flat @click="snackbar = false">
				Close
			</v-btn>
		</v-snackbar>
	</v-layout>
</template>

<script>
    export default {
		name: 'site-delete',
        props: ['site_id', 'dialog'],

		data () {
			return {
				snackbar: false,
				text:     '',
				error:    '',
			}
		},

		methods: {
			cancel() {
				// reset form
    			Object.assign(this.$data, this.$options.data.call(this))
    			this.$emit('close')
			},

			destroy() {
				if (this.text != 'DELETE') {
					this.error = "To confirm site destruction, you have to type in a word DELETE"
					return false
				}

				axios.delete('/api/sites/' + this.site_id).then(response => {
					let data = response.data

					if (data.status == 'OK') {
						this.cancel();
						this.$emit('reload', true)
						this.snackbar = true
					} else {
						this.error = data.response
					}

				}).catch(errors => {
					this.error = 'Whoops! Sorry, an unexpected error has occurred...'
				});
			}
		}
	}
</script>
