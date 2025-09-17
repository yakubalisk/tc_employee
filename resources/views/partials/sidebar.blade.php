<aside class="h-full w-64 bg-card border-r">
    <div class="flex items-center justify-between p-4 border-b">
        <h2 class="text-lg font-semibold">Navigation</h2>
        <button @click="sidebarOpen = false" class="lg:hidden">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    
    <nav class="p-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 p-2 rounded-md hover:bg-muted {{ request()->routeIs('dashboard') ? 'bg-muted' : '' }}">
            <i class="dashboard-icon"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('employees.index') }}" class="flex items-center gap-2 p-2 rounded-md hover:bg-muted {{ request()->routeIs('employees.*') ? 'bg-muted' : '' }}">
            <i class="users-icon"></i>
            <span>Employees</span>
        </a>
        
        <a href="{{ route('departments.index') }}" class="flex items-center gap-2 p-2 rounded-md hover:bg-muted {{ request()->routeIs('departments.*') ? 'bg-muted' : '' }}">
            <i class="building-icon"></i>
            <span>Departments</span>
        </a>
        
        <a href="{{ route('reports.index') }}" class="flex items-center gap-2 p-2 rounded-md hover:bg-muted {{ request()->routeIs('reports.*') ? 'bg-muted' : '' }}">
            <i class="file-text-icon"></i>
            <span>Reports</span>
        </a>
        
        <a href="{{ route('settings.index') }}" class="flex items-center gap-2 p-2 rounded-md hover:bg-muted {{ request()->routeIs('settings.*') ? 'bg-muted' : '' }}">
            <i class="settings-icon"></i>
            <span>Settings</span>
        </a>
    </nav>
</aside>