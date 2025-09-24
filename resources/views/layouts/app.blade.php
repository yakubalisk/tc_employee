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


        <!-- Custom Styles for React-like Components -->
    <style>
        /* Custom component classes */
        .btn {
            @apply inline-flex items-center px-4 py-2 border border-transparent rounded-md font-medium text-xs uppercase tracking-widest transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2;
        }
        
        .btn-primary {
            @apply bg-primary-500 text-white hover:bg-primary-600 focus:ring-primary-500;
        }
        
        .btn-success {
            @apply bg-success-500 text-white hover:bg-success-600 focus:ring-success-500;
        }
        
        .btn-danger {
            @apply bg-danger-500 text-white hover:bg-danger-600 focus:ring-danger-500;
        }
        
        .btn-outline {
            @apply border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-gray-500;
        }
        
        .btn-ghost {
            @apply text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:ring-gray-500;
        }
        
        .btn-sm {
            @apply px-3 py-1.5 text-sm;
        }
        
        .btn-lg {
            @apply px-6 py-3 text-base;
        }
        
        .card {
            @apply bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200;
        }
        
        .card-header {
            @apply px-6 py-4 border-b border-gray-200;
        }
        
        .card-title {
            @apply text-lg font-semibold text-gray-900;
        }
        
        .card-content {
            @apply p-6;
        }
        
        .input {
            @apply block w-full rounded-md border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none;
        }
        
        .textarea {
            @apply block w-full rounded-md border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none;
        }
        
        .select {
            @apply block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none;
        }
        
        .badge {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
        }
        
        .badge-primary {
            @apply bg-primary-100 text-primary-800;
        }
        
        .badge-secondary {
            @apply bg-gray-100 text-gray-800;
        }
        
        .badge-success {
            @apply bg-success-100 text-success-800;
        }
        
        .badge-warning {
            @apply bg-yellow-100 text-yellow-800;
        }
        
        .badge-danger {
            @apply bg-danger-100 text-danger-800;
        }
        
        .badge-outline {
            @apply border border-gray-300 text-gray-700 bg-transparent;
        }
        
        .table {
            @apply min-w-full divide-y divide-gray-200;
        }
        
        .table thead {
            @apply bg-gray-50;
        }
        
        .table th {
            @apply px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider;
        }
        
        .table td {
            @apply px-6 py-4 whitespace-nowrap text-sm text-gray-900;
        }
        
        .table tbody tr {
            @apply hover:bg-gray-50;
        }
        
        .table tbody tr:nth-child(even) {
            @apply bg-gray-50;
        }
        
        .label {
            @apply block text-sm font-medium text-gray-700 mb-1;
        }
        
        .modal {
            @apply fixed inset-0 z-50 overflow-y-auto;
        }
        
        .modal-backdrop {
            @apply fixed inset-0 bg-gray-600 bg-opacity-75;
        }
        
        .modal-content {
            @apply relative bg-white rounded-lg shadow-xl max-w-md mx-auto my-8;
        }
        
        /* React-like spacing */
        .space-y-6 > * + * {
            margin-top: 1.5rem;
        }
        
        .space-y-4 > * + * {
            margin-top: 1rem;
        }
        
        .space-y-3 > * + * {
            margin-top: 0.75rem;
        }
        
        .space-y-2 > * + * {
            margin-top: 0.5rem;
        }
        
        /* Grid system */
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        
        .grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
        
        @media (min-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            
            .md\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
            
            .md\:grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }
        
        @media (min-width: 1024px) {
            .lg\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            
            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
    </style>

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