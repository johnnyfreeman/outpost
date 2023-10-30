<div data-turbo-temporary aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
    <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
        @if([$title, $description] = session('success'))
            <x-notifications.success :title="$title" :description="$description" />
        @endif
    </div>
</div>
