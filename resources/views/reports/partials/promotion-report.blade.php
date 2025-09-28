<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="card border rounded-lg">
            <div class="p-4 card-content">
                <div class="text-2xl font-bold text-success">{{ $reportData['promotedThisYear'] }}</div>
                <div class="text-sm text-muted-foreground">Promotions This Year</div>
            </div>
        </div>
        <div class="card border rounded-lg">
            <div class="p-4 card-content">
                <div class="text-2xl font-bold text-warning">{{ $reportData['pendingPromotions'] }}</div>
                <div class="text-sm text-muted-foreground">Pending Promotions</div>
            </div>
        </div>
    </div>

    <div class="card border rounded-lg">
        <div class="card-header">
            <div class="card-title">Recently Promoted Employees</div>
        </div>
        <div class="card-content">
            <div class="space-y-3">
                @foreach($reportData['promotedEmployees'] as $promotion)
                <div class="flex justify-between items-center p-3 border rounded-lg">
                    <div>
                        <p class="font-medium">{{ $promotion->employee->name }}</p>
                        <p class="text-sm text-muted-foreground">{{ $promotion->employee->designationAtPresent }}</p>
                    </div>
                    <span class="badge badge-success">Promoted</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>