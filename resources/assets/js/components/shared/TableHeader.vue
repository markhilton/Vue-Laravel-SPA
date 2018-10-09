<!-- custom table header slot -->
<template>
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
			@click="$emit('update', { sortable: header.sortable, sortBy: header.value, descending: pagination.descending })"
		>
			<v-icon aria-hidden="true" small v-if="header.align == 'right' && header.value == pagination.sortBy">
				{{ pagination.descending == 'true' ? 'arrow_upward' : 'arrow_downward' }}
			</v-icon>

            {{ header.text }}

            <v-icon aria-hidden="true" small v-if="header.align != 'right' && header.value == pagination.sortBy">
				{{ pagination.descending == 'true' ? 'arrow_upward' : 'arrow_downward' }}
			</v-icon>
		</th>
	</tr>
</template>

<script>
	export default {
		name: 'table-header',
        props: ['props', 'pagination']
	}
</script>
