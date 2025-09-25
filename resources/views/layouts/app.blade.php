<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Employee Management System') }}</title>

    <!-- Google Fonts (correct URL) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Styles -->
<!--     <style>
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
    </style> -->


    <style>
        :root {
            font-family: 'Inter', system-ui, Avenir, Helvetica, Arial, sans-serif;
            line-height: 1.5;
            font-weight: 400;
            color-scheme: light dark;
            color: rgba(255, 255, 255, 0.87);
            background-color: #242424;
            font-synthesis: none;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            -webkit-text-size-adjust: 100%;
        }

        #root {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem;
            text-align: center;
        }

        .logo {
            height: 6em;
            padding: 1.5em;
            will-change: filter;
            transition: filter 300ms;
        }
        .logo:hover {
            filter: drop-shadow(0 0 2em #646cffaa);
        }
        .logo.react:hover {
            filter: drop-shadow(0 0 2em #61dafbaa);
        }

        @keyframes logo-spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @media (prefers-reduced-motion: no-preference) {
            a:nth-of-type(2) .logo {
                animation: logo-spin infinite 20s linear;
            }
        }

        .card {
            padding: 2em;
        }

        .read-the-docs {
            color: #888;
        }

        /* React component styles */
        a {
            font-weight: 500;
            color: #646cff;
            text-decoration: inherit;
        }
        a:hover {
            color: #535bf2;
        }

        body {
            margin: 0;
            display: flex;
            place-items: center;
            min-width: 320px;
            min-height: 100vh;
        }

        h1 {
            font-size: 3.2em;
            line-height: 1.1;
        }

        button {
            border-radius: 8px;
            border: 1px solid transparent;
            padding: 0.6em 1.2em;
            font-size: 1em;
            font-weight: 500;
            font-family: inherit;
            background-color: #1a1a1a;
            color: white;
            cursor: pointer;
            transition: border-color 0.25s;
        }
        button:hover {
            border-color: #646cff;
        }
        button:focus,
        button:focus-visible {
            outline: 4px auto -webkit-focus-ring-color;
        }

        @media (prefers-color-scheme: light) {
            :root {
                color: #213547;
                background-color: #ffffff;
            }
            a:hover {
                color: #747bff;
            }
            button {
                background-color: #f9f9f9;
                color: #213547;
            }
        }

        /* Additional React-like component styles */
        .flex {
            display: flex;
        }

        .justify-center {
            justify-content: center;
        }

        .items-center {
            align-items: center;
        }

        .space-x-4 > * + * {
            margin-left: 1rem;
        }

        .space-y-4 > * + * {
            margin-top: 1rem;
        }

        .grid {
            display: grid;
        }

        .grid-cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .gap-6 {
            gap: 1.5rem;
        }

        .p-6 {
            padding: 1.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-gray-600 {
            color: #6b7280;
        }

        /* Form styles matching React components */
        .input-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        .input-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .input-field {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background-color: white;
            color: #374151;
            transition: border-color 0.15s ease-in-out;
        }

        .input-field:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .select-field {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background-color: white;
            color: #374151;
        }

        .textarea-field {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background-color: white;
            color: #374151;
            resize: vertical;
            min-height: 100px;
        }
    </style>
<!-- Vite CSS -->
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
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>