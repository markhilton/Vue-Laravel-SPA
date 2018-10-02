<!-- custom table header slot - not as good as original -->
<template slot="headers" slot-scope="props">
	<tr>
		<th v-for="(header, index) in props.headers" :key="header.text"
			role="columnheader" scope="col" 
			:tabindex="index"
			:aria-sort="header.value == pagination.sortBy ? (pagination.descending ? 'descending' : 'ascending') : ''" 
			:class="[
				'column', 
				'text-xs-' + header.align,
				header.visibility,
				header.sortable ? 'sortable' : '',
				header.value == pagination.sortBy ? 'active' : '',
				header.value == pagination.sortBy ? (pagination.descending ? 'desc' : 'asc') : '', 
			]"
			@click="sortBy(header.value, header.sortable)"
		>
			<v-icon aria-hidden="true" small v-if="header.align == 'right' && header.value == pagination.sortBy">
				{{ pagination.descending ? 'arrow_upward' : 'arrow_downward' }}
			</v-icon>
			{{ header.text }}
			<v-icon aria-hidden="true" small v-if="header.align != 'right' && header.value == pagination.sortBy">
				{{ pagination.descending ? 'arrow_upward' : 'arrow_downward' }}
			</v-icon>
		</th>
	</tr>
</template>