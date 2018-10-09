<template>
	<div>
		<site-create
			:dialog="createSite"
			@reload="getDataFromApi()"
			@close="createSite = false"
		/>

		<site-delete
			:dialog="deleteSite"
			:site_id="site_id"
			@reload="getDataFromApi()"
			@close="deleteSite = false"
		/>

		<v-card>
			<!-- dialog activator button -->
			<v-btn fab dark big bottom right fixed color="red" @click="createSite = true">
				<v-icon dark>add</v-icon>
			</v-btn>

			<v-card-title>
				<v-spacer class="hidden-xs-only"></v-spacer>
				<v-text-field @change="search"
					v-model="search"
					append-icon="search"
					label="Search"
					single-line
					hide-details
				></v-text-field>
			</v-card-title>

			<!-- request error alert -->
			<v-alert v-if="error" :value="true" color="error" icon="new_releases">
				{{ error }}
			</v-alert>

			<!--
				search breaks pagination here
				https://github.com/vuetifyjs/vuetify/issues/1544
			-->
			<v-data-table
				:loading="loading"
				:headers="headers"
				:items="dataItems"
				:total-items="totalItems"
				:pagination.sync="pagination"
				:rows-per-page-items="rowsPerPage"
				class="elevation-1"
			>

				<template slot="headers" slot-scope="props">
					<table-header :props="props" :pagination="pagination" @update="sortBy($event)"></table-header>
				</template>


				<template slot="items" slot-scope="props">
					<td class="text-xs-left">
						<div>{{ props.item.name }}</div>
						<small class="grey--text">{{ props.item.slug }}.{{ user.app.url }}</small>
					</td>


					<td class="text-xs-center">
						<v-tooltip left>
							<v-btn small dark fab slot="activator" :color="statuses[ props.item.status ].color">
								<v-icon>{{ statuses[ props.item.status ].icon }}</v-icon>
							</v-btn>
							<span>{{ statuses[ props.item.status ].name }}</span>
						</v-tooltip>
					</td>


					<td class="text-xs-center hidden-xs-only hidden-sm-only">
						<!-- read only -->
						<v-icon :disabled="props.item.option_naked">verified_user</v-icon>

						<!-- CDN distribution -->
						<v-icon :disabled="props.item.option_naked">wb_cloudy</v-icon>

						<!-- monitoring -->
						<v-icon :disabled="props.item.option_naked">remove_red_eye</v-icon>

						<!-- page speed -->
						<v-icon :disabled="props.item.option_naked">timer</v-icon>

						<!-- monitoring -->
						<v-icon :disabled="props.item.option_naked">check_circle</v-icon>

						<!-- SSL certificate -->
						<v-icon :disabled="props.item.option_naked">lock</v-icon>
					</td>


					<td class="text-xs-left hidden-xs-only">
						<v-btn flat class="pa-0 ma-0">
							<v-icon class="mr-2" v-if="props.item.type == 'Laravel'" color="red">
								fab fa-laravel
							</v-icon>
							<v-icon class="mr-2" v-else-if="props.item.type == 'WordPress'" color="grey">
								fab fa-wordpress
							</v-icon>
							<v-icon class="mr-2" v-else color="grey">
								fa fa-question-circle
							</v-icon>

							<span v-if="props.item.type">
								{{ props.item.type }}
							</span>
							<span v-else>
								<i>unknown</i>
							</span>
						</v-btn>
					</td>


					<td class="text-xs-left hidden-xs-only hidden-sm-only">
						<v-btn flat class="pl-0 ml-0">
							<v-icon class="mr-2" color="indigo">fab fa-php</v-icon>
							<span>{{ props.item.engine }}</span>
						</v-btn>
					</td>


					<td class="text-xs-right">
						<v-menu transition="slide-x-transition" bottom right>
							<v-btn slot="activator" color="dark" flat icon class="mr-0">
								<v-icon>more_vert</v-icon>
							</v-btn>

							<v-list>
								<v-btn block flat depressed href="#" @click="updateItem(props.item._id)">
									<v-icon left>edit</v-icon>
									<v-flex justify-left>Edit</v-flex>
								</v-btn>

								<v-btn flat block :href="'http://' + props.item.slug + '.' + user.app.url" target="_blank">
									<v-icon left>remove_red_eye</v-icon>
									<v-flex justify-left>Visit</v-flex>
								</v-btn>

								<v-divider></v-divider>

								<v-btn flat block color="red" @click="deleteItem(props.item._id)">
									<v-icon left>delete</v-icon>
									<v-flex justify-left>Delete</v-flex>
								</v-btn>
							</v-list>
						</v-menu>
					</td>
				</template>
			</v-data-table>
		</v-card>
	</div>
</template>

<script>
	import SiteCreate from './create';
	import SiteUpdate from './update';
	import SiteDelete from './delete';
	import TableHeader from '../shared/TableHeader';

	export default {
		name: 'sites',
		components: { SiteCreate, SiteUpdate, SiteDelete, TableHeader },
		data () {
			return {
				site_id: null,
				createSite: false,
				deleteSite: false,
				snackbar:    false, // https://vuetifyjs.com/en/components/snackbars
				search:      '',
				error:       false,
				statuses: {
					active: {
						name: 'active',
						color: 'primary',
						icon: 'user'
					},
					pending: {
						name: 'active',
						color: 'primary',
						icon: 'user'
					},
				},
				loading:     true,
				totalItems:  0,
				dataItems:   [],
				rowsPerPage: [ 5, 10, 25, 100 ],
				pagination:  {
					'sortBy': 'created_at',
					'descending': true,
				},
				headers: [{
					text:     'Name',
					value:    'name',
					align:    'left',
					sortable: true,
				},
				{
					text:     'Status',
					value:    'status',
					align:    'center',
					sortable: true,
				},
				{
					text:     'Services',
					value:    'services',
					align:    'center',
					sortable: false,
					visibility: 'hidden-xs-only hidden-sm-only'
				},
				{
					text:     'Type',
					value:    'type',
					align:    'left',
					sortable: true,
					visibility: 'hidden-xs-only'
				},
				{
					text:     'Engine',
					value:    'engine',
					align:    'left',
					sortable: true,
					visibility: 'hidden-xs-only hidden-sm-only'
				},
				{
					text:     'Actions',
					value:    '',
					align:    'right',
					sortable: false
				}]
			}
		},
		watch: {
			pagination: {
				handler() {
					this.getDataFromApi().then(data => {
						this.dataItems  = data.items
						this.totalItems = data.total
					})
				},
				deep: true
			},

			search(filter) {
				this.pagination.page   = 1
				this.pagination.search = filter
				this.getdataItems()
			}
		},
		methods: {
			sortBy(event) {
				if (event.sortable) {
					this.pagination.sortBy = event.sortBy
					this.pagination.descending = !event.descending
				}
			},

			getDataDefault() {
				this.pagination = {
					'sortBy': 'created_at',
					'descending': true,
				}
				this.getDataFromApi()
			},

			getDataFromApi() {
				this.loading = true

				return new Promise((resolve, reject) => {
					const { sortBy, descending, page, rowsPerPage } = this.pagination

					let items = this.getdataItems()
					// const total = items.length
				})
			},

			getdataItems() {
				var self = this
				var url  = '/api/sites'

				self.loading = true

				axios.get(url, {
					params: self.pagination
				})
				.then(response => {
					let data = response.data

					self.dataItems  = data.items
					self.totalItems = data.total
					self.loading    = false
					self.error      = false
				})
				.catch(errors => {
					self.loading = false
					self.error   = 'Whoops! Sorry, an unexpected error has occurred...'
				});
			},

			createItem() {
				this.$eventBus.$emit('site-create')
			},

			updateItem(site_id) {
				this.$eventBus.$emit('site-update', site_id)
			},

			deleteItem(site_id) {
				this.site_id = site_id
				this.deleteSite = true
			}
		},
		computed: {
            user() {
                return this.$store.getters.currentUser
            }
        }
	}
</script>
