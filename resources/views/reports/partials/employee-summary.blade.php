<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="card">
            <div class="p-4 card-content">
                <div class="text-2xl font-bold text-primary">{{ $reportData['totalEmployees'] }}</div>
                <div class="text-sm text-muted-foreground">Total Employees</div>
            </div>
        </div>
        <div class="card">
            <div class="p-4 card-content">
                <div class="text-2xl font-bold text-blue-600">{{ $reportData['maleCount'] }}</div>
                <div class="text-sm text-muted-foreground">Male Employees</div>
            </div>
        </div>
        <div class="card">
            <div class="p-4 card-content">
                <div class="text-2xl font-bold text-pink-600">{{ $reportData['femaleCount'] }}</div>
                <div class="text-sm text-muted-foreground">Female Employees</div>
            </div>
        </div>
        <div class="card">
            <div class="p-4 card-content">
                <div class="text-2xl font-bold text-green-600">{{ $reportData['averageAge'] }}</div>
                <div class="text-sm text-muted-foreground">Average Age</div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <div class="card-title">Category Distribution</div>
        </div>
        <div class="card-content">
            <div class="space-y-2">
                @foreach($reportData['categoryDistribution'] as $category => $count)
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ $category }}</span>
                    <span class="badge badge-secondary">{{ $count }} employees</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>