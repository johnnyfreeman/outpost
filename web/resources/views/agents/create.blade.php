<x-shell>
	<x-app>
		<h2 class="text-3xl font-bold mt-12">create a new agent</h2>

		<form action="{{ route('agents.store') }}" method="post" class="mt-8">
			@csrf
			<x-agents.form />
		</form>
	</x-app>
</x-shell>
