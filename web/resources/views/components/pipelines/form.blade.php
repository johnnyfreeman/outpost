@props(['pipeline' => null])
<div class="space-y-12">
	<div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 @4xl/main:grid-cols-3">
		<div>
			<h2 class="text-lg font-semibold leading-7">details</h2>
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
		<div>
			<h2 class="text-lg font-semibold leading-7">personal information</h2>
			<p class="mt-1 leading-6 text-gray-600">use a permanent address where you can receive mail.</p>
		</div>

		<div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 @sm/main:grid-cols-6 @md/main:col-span-2">
			<div class="@sm/main:col-span-3">
				<label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">first name</label>
				<div class="mt-2">
					<input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black @sm/main:text-sm @sm/main:leading-6">
				</div>
			</div>

			<div class="@sm/main:col-span-3">
				<label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">last name</label>
				<div class="mt-2">
					<input type="text" name="last-name" id="last-name" autocomplete="family-name" class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black @sm/main:text-sm @sm/main:leading-6">
				</div>
			</div>

			<div class="@sm/main:col-span-4">
				<label for="email" class="block text-sm font-medium leading-6 text-gray-900">email address</label>
				<div class="mt-2">
					<input id="email" name="email" type="email" autocomplete="email" class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black @sm/main:text-sm @sm/main:leading-6">
				</div>
			</div>

			<div class="@sm/main:col-span-3">
				<label for="country" class="block text-sm font-medium leading-6 text-gray-900">country</label>
				<div class="mt-2">
					<select id="country" name="country" autocomplete="country-name" class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-black @sm/main:max-w-xs @sm/main:text-sm @sm/main:leading-6">
						<option>united states</option>
						<option>canada</option>
						<option>mexico</option>
					</select>
				</div>
			</div>

			<div class="col-span-full">
				<label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">street address</label>
				<div class="mt-2">
					<input type="text" name="street-address" id="street-address" autocomplete="street-address" class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black @sm/main:text-sm @sm/main:leading-6">
				</div>
			</div>

			<div class="@sm/main:col-span-2 @sm/main:col-start-1">
				<label for="city" class="block text-sm font-medium leading-6 text-gray-900">city</label>
				<div class="mt-2">
					<input type="text" name="city" id="city" autocomplete="address-level2" class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black @sm/main:text-sm @sm/main:leading-6">
				</div>
			</div>

			<div class="@sm/main:col-span-2">
				<label for="region" class="block text-sm font-medium leading-6 text-gray-900">state / province</label>
				<div class="mt-2">
					<input type="text" name="region" id="region" autocomplete="address-level1" class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black @sm/main:text-sm @sm/main:leading-6">
				</div>
			</div>

			<div class="@sm/main:col-span-2">
				<label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">zip / postal code</label>
				<div class="mt-2">
					<input type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black @sm/main:text-sm @sm/main:leading-6">
				</div>
			</div>
		</div>
	</div>

	<div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 @4xl/main:grid-cols-3">
		<div>
			<h2 class="text-lg font-semibold leading-7">notifications</h2>
			<p class="mt-1 leading-6 text-gray-600">we'll always let you know about important changes, but you pick what else you want to hear about.</p>
		</div>

		<div class="max-w-2xl space-y-10 @md/main:col-span-2">
			<fieldset>
				<legend class="text-sm font-semibold leading-6 text-gray-900">by email</legend>
				<div class="mt-6 space-y-6">
					<div class="relative flex gap-x-3">
						<div class="flex h-6 items-center">
							<input id="comments" name="comments" type="checkbox" class="h-4 w-4 border-gray-300 text-black focus:ring-black">
						</div>
						<div class="text-sm leading-6">
							<label for="comments" class="font-medium text-gray-900">comments</label>
							<p class="text-gray-500">get notified when someones posts a comment on a posting.</p>
						</div>
					</div>
					<div class="relative flex gap-x-3">
						<div class="flex h-6 items-center">
							<input id="candidates" name="candidates" type="checkbox" class="h-4 w-4 border-gray-300 text-black focus:ring-black">
						</div>
						<div class="text-sm leading-6">
							<label for="candidates" class="font-medium text-gray-900">candidates</label>
							<p class="text-gray-500">get notified when a candidate applies for a job.</p>
						</div>
					</div>
					<div class="relative flex gap-x-3">
						<div class="flex h-6 items-center">
							<input id="offers" name="offers" type="checkbox" class="h-4 w-4 border-gray-300 text-black focus:ring-black">
						</div>
						<div class="text-sm leading-6">
							<label for="offers" class="font-medium text-gray-900">offers</label>
							<p class="text-gray-500">get notified when a candidate accepts or rejects an offer.</p>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend class="text-sm font-semibold leading-6 text-gray-900">push notifications</legend>
				<p class="mt-1 leading-6 text-gray-600">these are delivered via sms to your mobile phone.</p>
				<div class="mt-6 space-y-6">
					<div class="flex items-center gap-x-3">
						<input id="push-everything" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-black focus:ring-black">
						<label for="push-everything" class="block text-sm font-medium leading-6 text-gray-900">everything</label>
					</div>
					<div class="flex items-center gap-x-3">
						<input id="push-email" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-black focus:ring-black">
						<label for="push-email" class="block text-sm font-medium leading-6 text-gray-900">same as email</label>
					</div>
					<div class="flex items-center gap-x-3">
						<input id="push-nothing" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-black focus:ring-black">
						<label for="push-nothing" class="block text-sm font-medium leading-6 text-gray-900">no push notifications</label>
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
