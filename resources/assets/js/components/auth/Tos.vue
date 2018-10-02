<template>
	<v-layout row justify-center>
		<v-dialog v-model="dialog" persistent>

			<v-card>
				<v-card-title primary-title class="headline primary white--text">
					Terms of Service
				</v-card-title>

				<v-card-text>
					Terms of Service here...
				</v-card-text>

				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="primary" flat @click.native="$emit('close')">Close</v-btn>
				</v-card-actions>
			</v-card>

		</v-dialog>
	</v-layout>
</template>


<script>
    export default {
        name: "tos",
		props: [ 'dialog' ]
    }
</script>
