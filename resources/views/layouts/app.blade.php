<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Employee Management System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bundy.net/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        .sidebar-icon, .bell-icon, .settings-icon, .user-icon {
            width: 1rem;
            height: 1rem;
            display: inline-block;
            background-size: cover;
        }
        
        /* You would replace these with actual icon implementations */
        .bell-icon { background-image: url("data:image/svg+xml,..."); }
        .settings-icon { background-image: url("data:image/svg+xml,..."); }
        .user-icon { background-image: url("data:image/svg+xml,..."); }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex w-full bg-background font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex w-full">
        <!-- Sidebar (initially hidden on mobile) -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-50 w-64 bg-card border-r transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
            @include('partials.sidebar')
        </div>

        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/80 lg:hidden" 
             x-cloak
             @click="sidebarOpen = false">
        </div>

        <div class="flex-1 flex flex-col lg:ml-0">
            <!-- Header -->
            <header class="h-16 border-b bg-card flex items-center justify-between px-6 shadow-sm">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-xl font-semibold text-foreground">Employee Management System</h1>
                        <p class="text-sm text-muted-foreground">Comprehensive HR Management Platform</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <button class="p-2 rounded-md hover:bg-muted">
                        <i class="bell-icon"></i>
                    </button>
                    <button class="p-2 rounded-md hover:bg-muted">
                        <i class="settings-icon"></i>
                    </button>
                    <button class="p-2 rounded-md hover:bg-muted">
                        <i class="user-icon"></i>
                    </button>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="flex-1 p-6 bg-muted/30">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- AlpineJS for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>