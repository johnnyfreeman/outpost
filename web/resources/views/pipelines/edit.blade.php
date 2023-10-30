<x-shell>
	<h2 class="text-3xl font-bold mt-12">edit pipeline</h2>

	<form action="{{ route('pipelines.update', $pipeline) }}" method="post" class="mt-8">
		@csrf
		<x-pipelines.form :pipeline="$pipeline" />
	</form>
</x-shell>