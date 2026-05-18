<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      dir="rtl" 
      x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
      x-init="$watch('darkMode', value => localStorage.setItem('theme', value ? 'dark' : 'light'))"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --color-primary: {{ session('tenant')?->primary_color ?? '#1e3a8a' }};
            --color-secondary: {{ session('tenant')?->secondary_color ?? '#ffffff' }};
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200">
    <div class="flex h-screen" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 right-0 z-50 w-64 bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700 transition-transform lg:translate-x-0 lg:static"
               :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'">
            <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-700">
                @if(session('tenant')?->logo_path)
                    <img src="{{ asset(session('tenant')->logo_path) }}" alt="Logo" class="h-8 w-auto">
                @else
                    <span class="text-xl font-bold text-primary">{{ session('tenant')->name ?? 'Portal' }}</span>
                @endif
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('tenant.dashboard') }}" class="flex items-center p-2 rounded-md hover:bg-primary/10 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-white">
                    <span>{{ __('Dashboard') }}</span>
                </a>
                <a href="{{ route('meetings.index') }}" class="flex items-center p-2 rounded-md hover:bg-primary/10 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-white">
                    <span>{{ __('Meetings') }}</span>
                </a>
                <a href="{{ route('resolutions.index') }}" class="flex items-center p-2 rounded-md hover:bg-primary/10 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-white">
                    <span>{{ __('Resolutions') }}</span>
                </a>
                <a href="{{ route('tasks.index') }}" class="flex items-center p-2 rounded-md hover:bg-primary/10 text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-white">
                    <span>{{ __('Execution Tasks') }}</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-4 lg:px-8">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-600 dark:text-gray-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
                
                <div class="flex items-center space-x-reverse space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="p-2 rounded-full text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors">
                        <template x-if="!darkMode">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </template>
                        <template x-if="darkMode">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 18v1m9-9h1M3 12h1m15.364 6.364l.707.707M6.343 6.343l.707.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </template>
                    </button>

                    <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 lg:p-8 bg-gray-50 dark:bg-gray-900">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-md">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-md">{{ session('error') }}</div>
                @endif
                @if(session('warning'))
                    <div class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 text-yellow-700 dark:text-yellow-300 rounded-md">{{ session('warning') }}</div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
