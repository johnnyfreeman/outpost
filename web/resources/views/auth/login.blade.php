<x-shell>
	<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
		<div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <a href="{{ route('home') }}" class="flex flex-shrink-0 items-center justify-center h-10 w-auto">
                <i class="fa-sharp fa-regular fa-flag-swallowtail fa-xl"></i>
            </a>
			<h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
		</div>

		<div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
			<a hx-boost="false" href="{{ route('auth.redirect') }}" class="flex items-center justify-center space-x-2 bg-black px-3 h-12 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
				<i class="fa-brands fa-github-alt fa-lg"></i>
				<span>Login with Github</span>
			</a>

			<p class="mt-10 text-center text-sm text-gray-500">
				Not a member?
				<a href="#" class="font-semibold leading-6 text-black">Start a 14 day free trial</a>
			</p>
		</div>
	</div>
</x-shell>
