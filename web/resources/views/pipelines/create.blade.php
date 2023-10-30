<x-shell>
	<h2 class="text-3xl font-bold mt-12">create a new pipeline</h2>

	<form action="{{ route('pipelines.store') }}" method="post" class="mt-8">
		@csrf
		<x-pipelines.form />
	</form>
</x-shell>