<x-shell>
	<x-app>
		<div class="mt-12 md:flex md:items-center md:justify-between">
			<div class="min-w-0 flex-1">
				<h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">agents</h2>
			</div>
			<div class="mt-4 flex md:ml-4 md:mt-0">
				<a href="{{ route('agents.create') }}" class="inline-flex items-center bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">new</a>
			</div>
		</div>


		@if($agents->isEmpty())
		<div class="mt-8 border border-dashed border-gray-900/25 p-8">
			<h2 class="text-lg font-semibold leading-7 text-black">create your first agent</h2>
			<p class="mt-1 leading-6 text-gray-600">get started by selecting a template or start from an empty agent.</p>
			<ul role="list" class="mt-6 divide-y divide-gray-200 border-b border-t border-gray-200">
				<li>
					<div class="group relative flex items-start space-x-3 py-6">
						<div class="flex-shrink-0">
							<span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-black">
								<i class="fa-brands fa-github-alt fa-lg text-white"></i>
							</span>
						</div>
						<div class="min-w-0 flex-1">
							<div class="font-medium text-black">
								<a href="{{ route('agents.create') }}">
									<span class="absolute inset-0" aria-hidden="true"></span>
									github agent
								</a>
							</div>
							<p class="text-gray-500">i think the kids call these memes these days.</p>
						</div>
						<div class="flex-shrink-0 self-center">
							<i class="fa-sharp fa-regular fa-chevron-right fa-sm text-gray-400 group-hover:text-gray-500"></i>
						</div>
					</div>
				</li>
				<li>
					<div class="group relative flex items-start space-x-3 py-6">
						<div class="flex-shrink-0">
							<span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-black">
								<i class="fa-brands fa-gitlab fa-lg text-white"></i>
							</span>
						</div>
						<div class="min-w-0 flex-1">
							<div class="font-medium text-black">
								<a href="{{ route('agents.create') }}">
									<span class="absolute inset-0" aria-hidden="true"></span>
									gitlab agent
								</a>
							</div>
							<p class="text-sm text-gray-500">something really expensive that will ultimately get cancelled.</p>
						</div>
						<div class="flex-shrink-0 self-center">
							<i class="fa-sharp fa-regular fa-chevron-right fa-sm text-gray-400 group-hover:text-gray-500"></i>
						</div>
					</div>
				</li>
				<li>
					<div class="group relative flex items-start space-x-3 py-6">
						<div class="flex-shrink-0">
							<span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-black">
								<i class="fa-sharp fa-regular fa-timer fa-lg text-white"></i>
							</span>
						</div>
						<div class="min-w-0 flex-1">
							<div class="font-medium text-black">
								<a href="{{ route('agents.create') }}">
									<span class="absolute inset-0" aria-hidden="true"></span>
									cron-based agent
								</a>
							</div>
							<p class="text-sm text-gray-500">like a conference all about you that no one will care about.</p>
						</div>
						<div class="flex-shrink-0 self-center">
							<i class="fa-sharp fa-regular fa-chevron-right fa-sm text-gray-400 group-hover:text-gray-500"></i>
						</div>
					</div>
				</li>
			</ul>
			<div class="mt-6 flex">
				<a href="{{ route('agents.create') }}" class="font-medium text-black underline">
					or start from an empty agent
					<span aria-hidden="true"> &rarr;</span>
				</a>
			</div>
		</div>
		@else
		<ul role="list" class="mt-8 divide-y divide-gray-200">
			@foreach($agents as $agent)
			<li class="relative flex items-center space-x-4 py-6">
				<div class="min-w-0 flex-auto">
					<div class="flex items-center gap-x-3">
						<x-agents.status :agent="$agent" />
						<h2 class="min-w-0 font-semibold leading-6 text-black">
							<a href="{{ route('agents.show', $agent) }}" class="flex gap-x-2">
								<span class="truncate">{{ $agent->name }}</span>
								<span class="absolute inset-0"></span>
							</a>
						</h2>
					</div>
					<div class="mt-1 flex items-center gap-x-2.5 text-sm leading-5 text-gray-500">
						<p class="whitespace-nowrap">{{ $agent->getKey() }}</p>
						<svg viewBox="0 0 2 2" class="h-0.5 w-0.5 flex-none fill-gray-300">
							<circle cx="1" cy="1" r="1" />
						</svg>
						<p class="whitespace-nowrap">Created {{ $agent->created_at->diffForHumans() }}</p>
					</div>
				</div>

				@if($agent->isOnline())
					<div class="flex-none py-1 px-2 text-xs font-medium ring-1 ring-inset text-green-700 bg-green-400/10 ring-green-400/20">online</div>
				@endif

				<i class="fa-sharp fa-regular fa-chevron-right fa-sm text-gray-400 group-hover:text-gray-500"></i>
			</li>
			@endforeach
		</ul>
		@endif
	</x-app>
</x-shell>
