<template>
	<v-layout row justify-center>
		<v-dialog v-model="dialog" persistent max-width="500px">

			<v-card>
				<v-card-title primary-title class="headline primary white--text">
					Deploy New Site
				</v-card-title>


				<!-- request error alert -->
				<v-alert v-if="error" :value="true" color="error" icon="new_releases">
					{{ error }}
				</v-alert>


				<v-card-text>
					<v-container grid-list-md>
						<v-layout wrap>
							<v-flex xs12>
								<v-text-field
									required
									ref="txt"
									label="Site name"
									v-model="site.name"
									:error-messages="errors.name"
								></v-text-field>
							</v-flex>

							<v-flex xs12 sm12>
								<v-carousel
									id="site-type"
									light
									hide-delimiters
									v-model="carouselIndex"
									:cycle="false"
								>
									<v-carousel-item v-for="(item, i) in types" :key="i" class="text-xs-center">
										<v-icon color="grey darken-2" size="65">
											fab fa-{{ item.icon }}
										</v-icon>
										<p class="ma-1 dark--text">
											{{ types[ i ].name }}
										</p>
									</v-carousel-item>
								</v-carousel>
							</v-flex>
						</v-layout>
					</v-container>
				</v-card-text>

				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="blue darken-1" flat @click.native="close()">Cancel</v-btn>
					<v-btn color="info" @click.native="deploy()">Deploy</v-btn>
				</v-card-actions>
			</v-card>

		</v-dialog>
	</v-layout>
</template>

<script>
    export default {
		name: 'site-create',
        props: ['dialog'],

    	data () {
    		return {
    			error:  false,
    			errors: [{
    				name: ''
    			}],
    			carouselIndex: null,
    			site: {
    				name: '',
    				type: ''
    			},
    			types: [{
    				name: "WordPress",
    				icon: "wordpress",
    			}, {
    				name: "Laravel",
    				icon: "laravel",
    			}]
    		}
    	},

    	methods: {
    		close() {
                // reset form
				this.site.name = ''
    			this.$emit('close')
    		},

    		deploy() {
    			this.site.type = this.types[ this.carouselIndex ].name

    			axios.post('/api/sites', this.site).then(response => {
    				let data = response.data

    				if (data.status == 'OK') {
    					this.close()
    					this.$emit('reload', true)
    				} else {
    					if (typeof data.response == 'string') {
    						this.error = data.response
    					} else {
    						this.errors = data.response
    					}
    				}
    			}).catch(errors => {
    				this.error = 'Whoops! Sorry, an unexpected error has occurred...'
    			});
    		},
    	}
    }
</script>

<style scoped>
    .v-carousel {
        height: auto !important;
        min-height: 8em;
        box-shadow: none !important;
    }
    .block {
    	.v-input__slot { display: block !important }
    }
</style>
