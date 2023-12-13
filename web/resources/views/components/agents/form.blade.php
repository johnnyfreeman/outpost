@props(['agent' => null])
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
						<input value="{{ old('name', data_get($agent, 'name')) }}" type="text" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 px-2.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 @sm/main:text-sm @sm/main:leading-6" placeholder="Deploy to production">
					</div>
				</div>
				@error('name')
					<p class="mt-3 text-sm leading-6 text-red-600">{{ $message }}</p>
				@enderror
			</div>
		</div>
	</div>

	<div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 @4xl/main:grid-cols-3">
		<div class="md:flex md:items-center md:justify-between">
			<div class="min-w-0 flex-1">
				<h2 class="text-lg font-semibold leading-7">tokens</h2>
				<p class="mt-1 leading-6 text-gray-600">this information will be displayed publicly so be careful what you share.</p>
			</div>
			<div class="mt-4 flex md:ml-4 md:mt-0">
				<button type="button" class="inline-flex items-center bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">new</button>
			</div>
		</div>

		@foreach(old('token', data_get($agent, 'tokens', [])) as $token)
		<div class="border border-gray-300 border-dashed p-6 space-y-4">
			<div class="@sm/main:col-span-4">
				<label for="name" class="block text-sm font-medium leading-6 text-gray-900">name</label>
				<div class="mt-2">
					<div class="flex shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-black @sm/main:max-w-md">
						<input value="{{ old('name', data_get($token, 'name')) }}" type="text" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 px-2.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 @sm/main:text-sm @sm/main:leading-6">
					</div>
				</div>
				@error('name')
					<p class="mt-3 text-sm leading-6 text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 @sm/main:grid-cols-6 @md/main:col-span-2">
				<div class="col-span-full">
					<label for="script" class="block text-sm font-medium leading-6 text-gray-900">script</label>
					<div class="mt-2">
						<textarea id="script" name="script" rows="3" class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black @sm/main:text-sm @sm/main:leading-6">{{ old('script', data_get($token, 'script')) }}</textarea>
					</div>
					@error('description')
						<p class="mt-3 text-sm leading-6 text-red-600">{{ $message }}</p>
					@enderror
				</div>
			</div>

			<div class="@sm/main:col-span-4">
				<label for="name" class="block text-sm font-medium leading-6 text-gray-900">run on</label>
				<div class="mt-2">
					<div class="flex shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-black @sm/main:max-w-md">
						<select value="{{ old('name', data_get($token, 'name')) }}" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 px-2.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 @sm/main:text-sm @sm/main:leading-6">
							<option>first available agent</option>
							<option>every agent</option>
						</select>
					</div>
				</div>
				@error('name')
					<p class="mt-3 text-sm leading-6 text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="@sm/main:col-span-4">
				<label for="agent" class="block text-sm font-medium leading-6 text-gray-900">matching</label>
				<div class="mt-2">
					<div class="flex shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-black @sm/main:max-w-md">
						<select value="{{ old('agent', data_get($token, 'agent')) }}" name="agent" id="agent" class="block flex-1 border-0 bg-transparent py-1.5 px-2.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 @sm/main:text-sm @sm/main:leading-6">
							<option>vm006</option>
							<option>vm008</option>
							<option>vm010</option>
						</select>
					</div>
				</div>
				@error('name')
					<p class="mt-3 text-sm leading-6 text-red-600">{{ $message }}</p>
				@enderror
			</div>
		</div>
		@endforeach
	</div>
</div>

<div class="mt-6 flex items-center justify-end gap-x-6">
	<button type="button" class="text-sm font-semibold leading-6 text-gray-900">cancel</button>
	<button type="submit" class="bg-black px-3 py-2 text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">save</button>
</div>
