<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full font-mono text-black">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>command-post</title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Source+Code+Pro&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jetbrains-mono@1.0.6/css/jetbrains-mono.min.css">
    <link rel="stylesheet" href="https://kit.fontawesome.com/49a7a85d82.css" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full">
    <nav class="bg-white shadow">
        <div class="px-4 sm:px-6 md:px-8">
            <div class="">
                <div class="relative flex h-16 justify-between">
                    <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>
                            <!--
            Icon when menu is closed.

            Menu open: "hidden", Menu closed: "block"
          -->
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!--
            Icon when menu is open.

            Menu open: "block", Menu closed: "hidden"
          -->
                            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                        <a href="{{ route('home') }}" class="flex flex-shrink-0 items-center">
                            <i class="fa-sharp fa-regular fa-flag-swallowtail fa-xl"></i>
                        </a>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <!-- Current: "border-indigo-500 text-gray-900", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
                            <a href="{{ route('pipelines.index') }}" class="inline-flex items-center border-b-2 border-black px-1 pt-1 text-sm font-medium text-gray-900">Pipelines</a>
                            <a href="{{ url('api/agents') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">Agents</a>
                        </div>
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                        <button type="button" class="relative rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>

                        <!-- Profile dropdown -->
                        <div class="hidden relative ml-3">
                            <div>
                                <button type="button" class="relative flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                </button>
                            </div>

                            <!--
            Dropdown menu, show/hide based on menu state.

            Entering: "transition ease-out duration-200"
              From: "transform opacity-0 scale-95"
              To: "transform opacity-100 scale-100"
            Leaving: "transition ease-in duration-75"
              From: "transform opacity-100 scale-100"
              To: "transform opacity-0 scale-95"
          -->
                            <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <!-- Active: "bg-gray-100", Not Active: "" -->
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="sm:hidden" id="mobile-menu">
                <div class="space-y-1 pb-4 pt-2">
                    <!-- Current: "bg-indigo-50 border-indigo-500 text-indigo-700", Default: "border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700" -->
                    <a href="{{ route('pipelines.index') }}" class="block border-l-4 border-indigo-500 bg-indigo-50 py-2 pl-3 pr-4 text-base font-medium text-indigo-700">Dashboard</a>
                    <a href="#" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">Team</a>
                    <a href="#" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">Projects</a>
                    <a href="#" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">Calendar</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="px-4 sm:px-6 md:px-8">
        <div class="@container/main max-w-3xl mx-auto">
            <div>{{ $slot }}</div>


            <footer class="">
                <div class="py-8 md:flex md:items-center md:justify-between">
                    <div class="flex justify-center space-x-6 md:order-2">
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">GitHub</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    <div class="mt-8 md:order-1 md:mt-0">
                        <p class="text-center text-xs leading-5 text-gray-500">&copy; 2023 john freeman. all rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{--
        <div class="relative z-10" role="dialog" aria-modal="true">
            <!--
        Background backdrop, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100"
          To: "opacity-0"
      -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto p-4 sm:p-6 md:p-20">
                <!--
          Command palette, show/hide based on modal state.

          Entering: "ease-out duration-300"
            From: "opacity-0 scale-95"
            To: "opacity-100 scale-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100 scale-100"
            To: "opacity-0 scale-95"
        -->
                <div class="mx-auto max-w-3xl transform divide-y divide-gray-100 overflow-hidden bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
                    <div class="relative">
                        <i class="fa-sharp fa-regular fa-magnifying-glass pointer-events-none absolute left-4 top-3.5 text-gray-400"></i>
                        <input type="text" class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-800 placeholder:text-gray-400 focus:ring-0 sm:text-sm" placeholder="Search..." role="combobox" aria-expanded="false" aria-controls="options">
                    </div>

                    <div class="flex transform-gpu divide-x divide-gray-100">
                        <!-- Preview Visible: "sm:h-96" -->
                        <div class="max-h-96 min-w-0 flex-auto scroll-py-4 overflow-y-auto px-6 py-4 sm:h-96">
                            <!-- Default state, show/hide based on command palette state. -->
                            <h2 class="mb-4 mt-2 text-xs font-semibold text-gray-500">Recent searches</h2>
                            <ul class="-mx-2 text-sm text-gray-700" id="recent" role="listbox">
                                <!-- Active: "bg-gray-100 text-black" -->
                                <li class="group flex cursor-default select-none items-center p-2" id="recent-1" role="option" tabindex="-1">
                                    <img src="https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-none rounded-full">
                                    <span class="ml-3 flex-auto truncate">Floyd Miles</span>
                                    <!-- Not Active: "hidden" -->
                                    <svg class="ml-3 hidden h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                </li>
                            </ul>

                            <!-- Results, show/hide based on command palette state. -->
                            <ul class="-mx-2 text-sm text-gray-700" id="options" role="listbox">
                                <!-- Active: "bg-gray-100 text-black" -->
                                <li class="group flex cursor-default select-none items-center p-2" id="option-1" role="option" tabindex="-1">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-none rounded-full">
                                    <span class="ml-3 flex-auto truncate">Tom Cook</span>
                                    <!-- Not Active: "hidden" -->
                                    <svg class="ml-3 hidden h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                </li>
                                <li class="group flex cursor-default select-none items-center p-2" id="option-2" role="option" tabindex="-1">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-none rounded-full">
                                    <span class="ml-3 flex-auto truncate">Courtney Henry</span>
                                    <svg class="ml-3 hidden h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                </li>
                                <li class="group flex cursor-default select-none items-center p-2" id="option-3" role="option" tabindex="-1">
                                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-none rounded-full">
                                    <span class="ml-3 flex-auto truncate">Dries Vincent</span>
                                    <svg class="ml-3 hidden h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                </li>
                                <li class="group flex cursor-default select-none items-center p-2" id="option-4" role="option" tabindex="-1">
                                    <img src="https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-none rounded-full">
                                    <span class="ml-3 flex-auto truncate">Kristin Watson</span>
                                    <svg class="ml-3 hidden h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                </li>
                                <li class="group flex cursor-default select-none items-center p-2" id="option-5" role="option" tabindex="-1">
                                    <img src="https://images.unsplash.com/photo-1517070208541-6ddc4d3efbcb?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-none rounded-full">
                                    <span class="ml-3 flex-auto truncate">Jeffrey Webb</span>
                                    <svg class="ml-3 hidden h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                </li>
                            </ul>
                        </div>

                        <!-- Active item side-panel, show/hide based on active state -->
                        <div class="hidden h-96 w-1/2 flex-none flex-col divide-y divide-gray-100 overflow-y-auto sm:flex">
                            <div class="flex-none p-6 text-center">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="mx-auto h-16 w-16 rounded-full">
                                <h2 class="mt-3 font-semibold text-black">Tom Cook</h2>
                                <p class="text-sm leading-6 text-gray-500">Director, Product Development</p>
                            </div>
                            <div class="flex flex-auto flex-col justify-between p-6">
                                <dl class="grid grid-cols-1 gap-x-6 gap-y-3 text-sm text-gray-700">
                                    <dt class="col-end-1 font-semibold text-black">Phone</dt>
                                    <dd>881-460-8515</dd>
                                    <dt class="col-end-1 font-semibold text-black">URL</dt>
                                    <dd class="truncate"><a href="https://example.com" class="text-gray-700 underline">https://example.com</a></dd>
                                    <dt class="col-end-1 font-semibold text-black">Email</dt>
                                    <dd class="truncate"><a href="#" class="text-gray-700 underline">tomcook@example.com</a></dd>
                                </dl>
                                <button type="button" class="mt-6 w-full bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">Send message</button>
                            </div>
                        </div>
                    </div>

                    <!-- Empty state, show/hide based on command palette state -->
                    <div class="px-6 py-14 text-center text-sm sm:px-14">
                        <i class="fa-2xl fa-sharp fa-regular fa-check-double mx-auto text-gray-400"></i>
                        <p class="mt-4 font-semibold text-black">No tasks found</p>
                        <p class="mt-2 text-gray-500">We couldn’t find anything matching that term. Please try again.</p>
                    </div>

                    <div class="flex flex-wrap items-center bg-gray-50 px-4 py-2.5 text-xs text-gray-700">Type <kbd class="mx-1 flex h-5 w-5 items-center justify-center rounded border border-gray-400 bg-white font-semibold text-black sm:mx-2">#</kbd> <span class="sm:hidden">for projects,</span><span class="hidden sm:inline">to access projects,</span> <kbd class="mx-1 flex h-5 w-5 items-center justify-center border border-gray-400 bg-white font-semibold text-black sm:mx-2">&gt;</kbd> for users, and <kbd class="mx-1 flex h-5 w-5 items-center justify-center border border-gray-400 bg-white font-semibold text-black sm:mx-2">?</kbd> for help.</div>
                </div>
            </div>
        </div>
    --}}

    <x-notifications />
</body>

</html>
