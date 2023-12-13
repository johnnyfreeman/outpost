<x-shell>
    <x-app>
        <div class="mt-12 md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="flex items-center space-x-4 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    <x-agents.status :agent="$agent" />
                    <span>{{ $agent->name }}</span>
                </h2>
                <p class="mt-2 leading-6 text-gray-600">{{ $agent->getKey() }}</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0 space-x-1">
                <a href="{{ route('agents.edit', $agent) }}" class="bg-white px-2 py-1 font-semibold text-black shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">edit</a>
            </div>
        </div>

        <h2 class="mt-4 text-lg font-semibold">tokens</h2>
        <div class="mt-2">
            <ul class="flex flex-wrap -mt-2 -ml-2">
                @foreach($agent->tokens as $token)
                <li class="flex items-center space-x-2 border border-dashed border-gray-900/25 whitespace-nowrap px-4 h-12 ml-2 mt-2">
                    <div>{{ $token->name }}</div>
                    <div>{{ $token->last_used_at }}</div>
                </li>
                @endforeach
            </ul>
        </div>
    </x-app>
</x-shell>
