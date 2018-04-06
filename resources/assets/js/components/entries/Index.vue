<template>
    <div class="row col-md-12">
       <div class="page-header clearfix">
            <h1>
                <i class="glyphicon glyphicon-align-justify"></i> Entries
            </h1>

        </div>

        <div class="row">
        <table class="table table-condensed table-striped">
        <thead>
            <tr>
            <th class="text-center"> id </th>
			<th class="text-center"> title </th>
			<th class="text-center"> hour </th>
			<th class="text-center"> pre </th>
			<th class="text-center"> estimated </th>
			<th class="text-center"> accepted </th>
			<th class="text-center"> start </th>
			<th class="text-center"> end </th>
			<th class="text-center"> mainte </th>
			<th class="text-center"> status </th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="entry in entries">
				<td class="text-center"> {{ entry.id }} </td>
				<td class="text-center"> {{ entry.title }} </td>
				<td class="text-right"> {{ entry.hour }} </td>
				<td class="text-center"> {{ entry.pre }} </td>
				<td class="text-center">
					<router-link :to="'/entry/' + entry.id">{{ entry.estimated }}</router-link>
				</td>
				<td class="text-center"> {{ entry.accepted }} </td>
				<td class="text-center"> {{ entry.start }} </td>
				<td class="text-center"> {{ entry.end }} </td>
				<td class="text-center"> {{ entry.mainte }} </td>
				<td class="text-left"> {{ entry.status }} </td>
			</tr>
		</tbody>
		</table>
        </div>
	</div>
</template>

<script>
    export default {
        created() {
            this.fetchEntries()
        },
        data() {
            return {
                entries: []
            }
        },
        methods: {
            fetchEntries() {
                this.$http.get('/api/entries')
				.then(res => {
                    this.entries = res.data
                })
				.catch( error => { 
					alert(error)
					console.log(error)
				})
            }
        }
    }
</script>
