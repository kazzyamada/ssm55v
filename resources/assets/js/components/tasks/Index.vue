<template>
    <div class="row col-md-12">
       <div class="page-header clearfix">
            <h1>
                <i class="glyphicon glyphicon-align-justify"></i> Tasks
            </h1>

        </div>

        <div class="row">
        <table class="table table-condensed table-striped">
        <thead>
            <tr>
            <th class="text-center"> id </th>
			<th class="text-center"> entry_id </th>
			<th class="text-center"> log </th>
			<th class="text-center"> date </th>
			<th class="text-center"> hours </th>
			<th class="text-center"> create </th>
			<th class="text-center"> update </th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="task in tasks">
				<td class="text-center"> {{ task.id }} </td>
				<td class="text-left"> {{ task.entry_id }}:{{task.title}} </td>
				<td class="text-left"> {{ task.log }} </td>
				<td class="text-center">
					<router-link :to="'/tasks/' + task.id">{{ task.task_day }}</router-link>
				</td>
				<td class="text-right"> {{ task.task_hour }} </td>
				<td class="text-center"> {{ task.created_at }} </td>
				<td class="text-center"> {{ task.updated_at }} </td>
			</tr>
		</tbody>
		</table>
        </div>
	</div>
</template>

<script>
    export default {
        created() {
            this.fetchTasks()
        },
        data() {
            return {
                tasks: []
            }
        },
        methods: {
            fetchTasks() {
                this.$http.get('/api/tasks')
				.then(res => {
                    this.tasks = res.data
                })
				.catch( error => { 
					alert(error)
					console.log(error)
				})
            }
        }
    }
</script>
