@props(['pipeline' => null])
<div class="space-y-12">
	<div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 @4xl/main:grid-cols-3">
		<div>
			<h2 class="text-lg font-semibold leading-7">about</h2>
			<p class="mt-1 leading-6 text-gray-600">this information will be displayed publicly so be careful what you share.</p>
		</div>

		<div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 @sm/main:grid-cols-6 @md/main:col-span-2">
			<div class="@sm/main:col-span-4">
				<label for="name" class="block text-sm font-medium leading-6 text-gray-900">name</label>
				<div class="mt-2">
					<div class="flex shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-black @sm/main:max-w-md">
						<input value="{{ old('name', data_get($pipeline, 'name')) }}" type="text" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 px-2.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 @sm/main:text-sm @sm/main:leading-6" placeholder="Deploy to production">
					</div>
				</div>
				@error('name')
					<p class="mt-3 text-sm leading-6 text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="col-span-full">
				<label for="description" class="block text-sm font-medium leading-6 text-gray-900">description</label>
				<div class="mt-2">
					<textarea id="description" name="description" rows="3" class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black @sm/main:text-sm @sm/main:leading-6">{{ old('description', data_get($pipeline, 'description')) }}</textarea>
				</div>
				<p class="mt-3 text-sm leading-6 text-gray-600">write a few sentences about yourself.</p>
				@error('description')
					<p class="mt-3 text-sm leading-6 text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="col-span-full">
				<label for="photo" class="block text-sm font-medium leading-6 text-gray-900">photo</label>
				<div class="mt-2 flex items-center gap-x-3">
					<i class="fa-sharp fa-regular fa-image fa-2xl text-gray-300"></i>
					<button type="button" class="bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">change</button>
				</div>
			</div>

			<div class="col-span-full">
				<label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">cover photo</label>
				<div class="mt-2 flex justify-center border border-dashed border-gray-900/25 px-6 py-10">
					<div class="text-center">
						<i class="fa-sharp fa-regular fa-image fa-2xl text-gray-300"></i>
						<div class="mt-4 flex text-sm leading-6 text-gray-600">
							<label for="file-upload" class="relative cursor-pointer bg-white font-semibold text-black focus-within:outline-none focus-within:ring-2 focus-within:ring-black focus-within:ring-offset-2 hover:text-indigo-500">
								<span>upload a file</span>
								<input id="file-upload" name="file-upload" type="file" class="sr-only">
							</label>
							<p class="pl-1">or drag and drop</p>
						</div>
						<p class="text-xs leading-5 text-gray-600">png, jpg, gif up to 10mb</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 @4xl/main:grid-cols-3">
		<div class="md:flex md:items-center md:justify-between">
			<div class="min-w-0 flex-1">
				<h2 class="text-lg font-semibold leading-7">steps</h2>
				<p class="mt-1 leading-6 text-gray-600">this information will be displayed publicly so be careful what you share.</p>
			</div>
			<div class="mt-4 flex md:ml-4 md:mt-0">
				<button type="button" class="inline-flex items-center bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">new</button>
			</div>
		</div>

		@foreach(old('step', data_get($pipeline, 'steps', [])) as $i => $step)
		<div class="border border-gray-300 border-dashed p-6 space-y-4">
			<div class="@sm/main:col-span-4">
				<label for="steps.{{ $i }}.run_on" class="block text-sm font-medium leading-6 text-gray-900">name</label>
				<div class="mt-2">
					<div class="flex shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-black @sm/main:max-w-md">
						<input value="{{ old('steps.'.$i.'.name', data_get($step, 'name')) }}" type="text" name="steps[{{ $i }}][name]" id="steps.{{ $i }}.name" class="block flex-1 border-0 bg-transparent py-1.5 px-2.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 @sm/main:text-sm @sm/main:leading-6">
					</div>
				</div>
				@error('steps.'.$i.'.name')
					<p class="mt-3 text-sm leading-6 text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 @sm/main:grid-cols-6 @md/main:col-span-2">
				<div class="col-span-full">
					<label for="steps.{{ $i }}.script" class="block text-sm font-medium leading-6 text-gray-900">script</label>
					<div class="mt-2">
						<textarea id="steps.{{ $i }}.script" name="steps[{{ $i }}][script]" rows="3" class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black @sm/main:text-sm @sm/main:leading-6">{{ old('steps.'.$i.'.script', data_get($step, 'script')) }}</textarea>
					</div>
					@error('steps.'.$i.'.script')
						<p class="mt-3 text-sm leading-6 text-red-600">{{ $message }}</p>
					@enderror
				</div>
			</div>

			<div class="@sm/main:col-span-4">
				<label for="steps.{{ $i }}.run_on" class="block text-sm font-medium leading-6 text-gray-900">run on</label>
				<div class="mt-2">
					<div class="flex shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-black @sm/main:max-w-md">
						<select value="{{ old('name', data_get($step, 'name')) }}" name="steps[{{ $i }}][run_on]" id="steps.{{ $i }}.run_on" class="block flex-1 border-0 bg-transparent py-1.5 px-2.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 @sm/main:text-sm @sm/main:leading-6">
							<option>first available agent</option>
							<option>every agent</option>
						</select>
					</div>
				</div>
				@error('steps.'.$i.'.run_on')
					<p class="mt-3 text-sm leading-6 text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="@sm/main:col-span-4">
				<label for="steps.{{ $i }}.agent" class="block text-sm font-medium leading-6 text-gray-900">matching</label>
				<div class="mt-2">
					<div class="flex shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-black @sm/main:max-w-md">
						<select value="{{ old('agent', data_get($step, 'agent')) }}" name="steps[{{ $i }}][agent]" id="steps.{{ $i }}.agent" class="block flex-1 border-0 bg-transparent py-1.5 px-2.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 @sm/main:text-sm @sm/main:leading-6">
							<option>vm006</option>
							<option>vm008</option>
							<option>vm010</option>
						</select>
					</div>
				</div>
				@error('steps.'.$i.'.run_on')
					<p class="mt-3 text-sm leading-6 text-red-600">{{ $message }}</p>
				@enderror
			</div>
		</div>
		@endforeach
	</div>

	<div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 @4xl/main:grid-cols-3">
		<div>
			<h2 class="text-lg font-semibold leading-7">github</h2>
			<p class="mt-1 leading-6 text-gray-600">these settings determine what events will trigger this pipeline, and also how pipeline status updates will be reported back to github.</p>
		</div>

		<div class="max-w-2xl space-y-10 @md/main:col-span-2">
			<fieldset>
				<legend class="text-sm font-semibold leading-6 text-gray-900">triggered by</legend>
				<div class="mt-6 space-y-6">
					<div class="relative flex gap-x-3">
						<div class="flex h-6 items-center">
							<input @checked($pipeline->githubSettings?->trigger_on_push) id="trigger_on_push" name="trigger_on_push" type="checkbox" class="h-4 w-4 border-gray-300 text-black focus:ring-black">
						</div>
						<div class="text-sm leading-6">
							<label for="trigger_on_push" class="font-medium text-gray-900">trigger on push</label>
							<p class="text-gray-500">run this pipeline when code is pushed to github.</p>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
</div>

<div class="mt-6 flex items-center justify-end gap-x-6">
	<button type="button" class="text-sm font-semibold leading-6 text-gray-900">cancel</button>
	<button type="submit" class="bg-black px-3 py-2 text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">save</button>
</div>
