@props(['title' => null, 'description' => null])
                <!--
      Notification panel, dynamically insert this into the live region when it needs to be displayed

      Entering: "transform ease-out duration-300 transition"
        From: "translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        To: "translate-y-0 opacity-100 sm:translate-x-0"
      Leaving: "transition ease-in duration-100"
        From: "opacity-100"
        To: "opacity-0"
    -->
<div class="pointer-events-auto w-full max-w-sm overflow-hidden bg-white shadow-lg ring-1 ring-black ring-opacity-5">
    <div class="p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fa-sharp fa-regular fa-circle-check fa-lg text-green-500"></i>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900">{{ $title }}</p>
                <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
            </div>
            <div class="mt-0.5 ml-4 flex flex-shrink-0">
                <button type="button" class="inline-flex bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span class="sr-only">Close</span>
					<i class="fa-sharp fa-regular fa-xmark-large fa-sm"></i>
                </button>
            </div>
        </div>
    </div>
</div>
