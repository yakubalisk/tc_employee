<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR System</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .sidebar-transition {
            transition: width 0.3s ease;
        }
        .active-nav {
            background-color: rgb(240 249 255);
            color: rgb(0 123 255);
            font-weight: 500;
        }
        .hover-nav:hover {
            background-color: rgba(240, 249, 255, 0.5);
        }
    </style>
</head>
<body class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar-transition bg-white border-r border-gray-200 overflow-hidden flex flex-col">
        <div class="flex-1 overflow-y-auto">
            <div class="p-4">
                <!-- Logo/Header -->
                <div class="flex items-center gap-2 px-2 py-3">
                    <i data-lucide="building-2" class="h-5 w-5 text-blue-600"></i>
                    <span class="font-semibold text-blue-600 whitespace-nowrap">HR System</span>
                </div>

                <!-- Navigation Menu -->
                <nav class="mt-6">
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ url('/') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover-nav {{ request()->is('/') ? 'active-nav' : '' }}">
                                <i data-lucide="home" class="h-4 w-4"></i>
                                <span class="whitespace-nowrap">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover-nav {{ request()->is('employees') ? 'active-nav' : '' }}">
                                <i data-lucide="users" class="h-4 w-4"></i>
                                <span class="whitespace-nowrap">All Employees</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('employees.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover-nav {{ request()->is('employees/create') ? 'active-nav' : '' }}">
                                <i data-lucide="user-plus" class="h-4 w-4"></i>
                                <span class="whitespace-nowrap">Add Employee</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/reports') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover-nav {{ request()->is('reports') ? 'active-nav' : '' }}">
                                <i data-lucide="file-text" class="h-4 w-4"></i>
                                <span class="whitespace-nowrap">Reports</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/analytics') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover-nav {{ request()->is('analytics') ? 'active-nav' : '' }}">
                                <i data-lucide="bar-chart-3" class="h-4 w-4"></i>
                                <span class="whitespace-nowrap">Analytics</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/promotions') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover-nav {{ request()->is('promotions') ? 'active-nav' : '' }}">
                                <i data-lucide="trending-up" class="h-4 w-4"></i>
                                <span class="whitespace-nowrap">Promotions</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/transfers') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover-nav {{ request()->is('transfers') ? 'active-nav' : '' }}">
                                <i data-lucide="calendar" class="h-4 w-4"></i>
                                <span class="whitespace-nowrap">Transfers</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/export') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 hover-nav {{ request()->is('export') ? 'active-nav' : '' }}">
                                <i data-lucide="download" class="h-4 w-4"></i>
                                <span class="whitespace-nowrap">Export Data</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </aside>



    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Toggle sidebar collapse (optional functionality)
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const isCollapsed = sidebar.classList.contains('w-16');
            
            if (isCollapsed) {
                sidebar.classList.remove('w-16');
                sidebar.classList.add('w-64');
                // Show all text spans
                document.querySelectorAll('nav span').forEach(span => {
                    span.classList.remove('hidden');
                });
            } else {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-16');
                // Hide all text spans
                document.querySelectorAll('nav span').forEach(span => {
                    span.classList.add('hidden');
                });
            }
        }

        // Optional: Add collapse button if needed
        document.addEventListener('DOMContentLoaded', function() {
            // You can add a collapse button in your header if desired
        });
    </script>
</body>
</html>