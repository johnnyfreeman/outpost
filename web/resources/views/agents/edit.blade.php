<x-shell>
	<x-app>
		<h2 class="text-3xl font-bold mt-12">edit agent</h2>

		<form action="{{ route('agents.update', $agent) }}" method="post" class="mt-8">
			@csrf
			<x-agents.form :agent="$agent" />
		</form>
	</x-app>
</x-shell>
