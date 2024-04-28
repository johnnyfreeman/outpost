<x-shell>
    <x-app>
        <div class="mt-12 md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="flex items-center space-x-4 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    <x-pipelines.status :event="$pipeline->latestEvent" />
                    <span>{{ $pipeline->name }}</span>
                </h2>
                <p class="mt-2 leading-6 text-gray-600">{{ $pipeline->description }}</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0 space-x-1">
                <form action="{{ route('pipelines.run', $pipeline) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                        <span class="sr-only">play</span>
                        <i class="fa-sharp fa-regular fa-play"></i>
                    </button>
                </form>
                <a href="{{ route('pipelines.edit', $pipeline) }}" class="bg-white px-2 py-1 font-semibold text-black shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">edit</a>
            </div>
        </div>

        <h2 class="mt-4 text-lg font-semibold">Steps</h2>
        <div class="mt-2">
            <ul class="flex flex-wrap -mt-2 -ml-2">
                @foreach($pipeline->steps as $step)
                <li class="flex items-center space-x-2 border border-dashed border-gray-900/25 whitespace-nowrap px-4 h-12 ml-2 mt-2">
                    <div>{{ $step->name }}</div>
                    <form action="{{ route('pipelines.steps.run', ['pipeline' => $pipeline, 'step' => $step]) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                            <span class="sr-only">play</span>
                            <i class="fa-sharp fa-regular fa-play"></i>
                        </button>
                    </form>
                </li>
                @endforeach
            </ul>
        </div>

        <h2 class="mt-4 text-lg font-semibold">Jobs</h2>
        <ul class="mt-2 space-y-4">
            @foreach($events as $event)
            <li class="border border-gray-900/2">
                <div class="flex items-center space-x-2 border-b border-gray-900/2 p-6 text-sm text-gray-800">
                    <x-pipelines.status :event="$event" />
                    <span>{{ $event->getKey() }}</span>
                    <x-link :href="$event->url">{{ $event->description }}</x-link>
                </div>

                <div class="divide-y divide-gray-900/2">
                    @foreach($event->jobs as $job)
                        <details class="space-y-2 p-6" {{ $loop->parent->first ? 'open' : '' }}>
                            <summary class="flex items-center justify-between space-x-4 select-none">
                                <div>
                                    <h3 class="font-semibold">
                                        {{ $job->step->name }}
                                    </h3>

                                    @if(is_null($job->agent_id))
                                        <span class="bg-gray-100 text-gray-900">waiting</span>
                                        <span>for {{ $job->created_at->diffForHumans() }}</span>
                                    @elseif(!$job->isComplete())
                                        <span class="bg-blue-100 text-blue-900">processing</span>
                                        <span>on <x-link :href="route('agents.show', $job->agent)">{{ $job->agent->name }}</x-link></span>
                                        <span>for {{ $job->reserved_at->diffForHumans() }}</span>
                                    @elseif($job->isSuccess())
                                        <span class="bg-green-100 text-green-900">succeeded</span>
                                        <span>on <x-link :href="route('agents.show', $job->agent)">{{ $job->agent->name }}</x-link></span>
                                        <span>after {{ $job->started_at->diffForHumans($job->finished_at, \Carbon\CarbonInterface::DIFF_ABSOLUTE) }}</span>
                                    @else
                                        <span class="bg-red-100 text-red-900">failed</span>
                                        <span>on <x-link :href="route('agents.show', $job->agent)">{{ $job->agent->name }}</x-link></span>
                                        <span>after {{ $job->started_at->diffForHumans($job->finished_at, \Carbon\CarbonInterface::DIFF_ABSOLUTE) }}</span>
                                    @endif
                                </div>

                                <div class="text-gray-400"><i class="fa-sharp fa-regular fa-chevron-down"></i></div>
                            </summary>

                            <pre class="bg-gray-900 text-white p-6 overflow-x-scroll leading-7 rounded-md">{{ highlight($job->output, 'cargo') }}</pre>
                        </details>
                    @endforeach
                </div>
            </li>
            @endforeach
        </ul>

        <div class="mt-4">
            {{ $events->links() }}
        </div>
    </x-app>
</x-shell>
