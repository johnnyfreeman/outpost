<x-shell>
  <div class="mt-12 md:flex md:items-center md:justify-between">
    <div class="min-w-0 flex-1">
      <h2 class="flex items-center space-x-4 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
        <x-pipelines.status />
        <span>{{ $pipeline->name }}</span>
      </h2>
      <p class="mt-2 leading-6 text-gray-600">{{ $pipeline->description }}</p>
    </div>
    <div class="mt-4 flex md:ml-4 md:mt-0">
      <a href="{{ route('pipelines.edit', $pipeline) }}"
        class="inline-flex items-center bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">edit</a>
    </div>
  </div>

  <nav aria-label="Progress" class="mt-12">
    <ol role="list" class="overflow-hidden">
      <li class="relative pb-10">
        <div class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-black" aria-hidden="true"></div>
        <!-- Complete Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center">
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-white">
              <i class="fa-sharp fa-solid fa-circle-check fa-2xl text-black"></i>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="font-medium">Git checkout</span>
            <span class="mt-1 text-sm text-gray-500">git checkout git@github.com:clinect/api.git</span>
          </span>
        </a>
      </li>
      <li class="relative pb-10">
        <div class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true"></div>
        <!-- Current Step -->
        <a href="#" class="group relative flex items-start" aria-current="step">
          <span class="flex h-9 items-center bg-white" aria-hidden="true">
            <i class="fa-sharp fa-regular fa-circle-dot fa-2xl"></i>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="font-medium text-black">List contents</span>
            <span class="mt-1 text-sm text-gray-500">ls -al</span>
          </span>
        </a>
        <div class="relative border-2 border-gray-300 bg-white text-black p-8 mt-4">
          <table class="w-full">
            <tr><td class="text-gray-400 text-right pr-2 select-none">1</td><td><code>.rw-r--r-- 148 john 27 Oct 23:19 .babelrc</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">2</td><td><code>.rw-r--r-- 258 john 10 Aug 03:19 .editorconfig</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">3</td><td><code>.rw-r--r-- 1.2k john 28 Oct 03:11 .env</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">4</td><td><code>.rw-r--r-- 1.1k john 10 Aug 03:19 .env.example</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">5</td><td><code>.rw-r--r-- 186 john 10 Aug 03:19 .gitattributes</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">6</td><td><code>.rw-r--r-- 243 john 10 Aug 03:19 .gitignore</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">7</td><td><code>drwxr-xr-x - john 10 Aug 03:19 app</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">8</td><td><code>.rwxr-xr-x 1.7k john 10 Aug 03:19 artisan</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">9</td><td><code>drwxr-xr-x - john 10 Aug 03:19 bootstrap</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">10</td><td><code>.rw-r--r-- 1.9k john 27 Oct 21:05 composer.json</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">11</td><td><code>.rw-r--r-- 296k john 27 Oct 21:05 composer.lock</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">12</td><td><code>drwxr-xr-x - john 10 Aug 03:19 config</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">13</td><td><code>drwxr-xr-x - john 10 Aug 03:19 database</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">14</td><td><code>.rw-r--r-- 4.2k john 28 Oct 03:12 docker-compose.yml</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">15</td><td><code>drwxr-xr-x - john 28 Oct 19:45 node_modules</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">16</td><td><code>.rw-r--r-- 89k john 28 Oct 19:45 package-lock.json</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">17</td><td><code>.rw-r--r-- 789 john 28 Oct 19:45 package.json</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">18</td><td><code>.rw-r--r-- 1.0k john 27 Oct 21:07 phpunit.xml</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">19</td><td><code>.rw-r--r-- 106 john 28 Oct 01:26 postcss.config.js</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">20</td><td><code>drwxr-xr-x - john 29 Oct 18:35 pubtrc</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">21</td><td><code>.rw-r--r-- 4.2k john 10 Aug 03:19 README.md</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">22</td><td><code>drwxr-xr-x - john 10 Aug 03:19 resources</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">23</td><td><code>drwxr-xr-x - john 10 Aug 03:19 routes</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">24</td><td><code>drwxr-xr-x - john 10 Aug 03:19 storage</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">25</td><td><code>.rw-r--r-- 673 john 28 Oct 19:52 tailwind.config.js</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">26</td><td><code>drwxr-xr-x - john 10 Aug 03:19 tests</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">27</td><td><code>drwxr-xr-x - john 27 Oct 21:01 vendor</code></td></tr>
            <tr><td class="text-gray-400 text-right pr-2 select-none">28</td><td><code>.rw-r--r-- 342 john 27 Oct 23:13 vite.config.js</code></td></tr>
          </table>
        </div>
      </li>
      <li class="relative pb-10">
        <div class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true"></div>
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span
              class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="font-medium text-gray-500">Business information</span>
            <span class="mt-1 text-sm text-gray-500">Penatibus eu quis ante.</span>
          </span>
        </a>
      </li>
      <li class="relative pb-10">
        <div class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true"></div>
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span
              class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="font-medium text-gray-500">Theme</span>
            <span class="mt-1 text-sm text-gray-500">Faucibus nec enim leo et.</span>
          </span>
        </a>
      </li>
      <li class="relative">
        <!-- Upcoming Step -->
        <a href="#" class="group relative flex items-start">
          <span class="flex h-9 items-center" aria-hidden="true">
            <span
              class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
              <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300"></span>
            </span>
          </span>
          <span class="ml-4 flex min-w-0 flex-col">
            <span class="font-medium text-gray-500">Preview</span>
            <span class="mt-1 text-sm text-gray-500">Iusto et officia maiores porro ad non quas.</span>
          </span>
        </a>
      </li>
    </ol>
  </nav>
</x-shell>