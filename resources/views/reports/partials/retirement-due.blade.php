<div class="space-y-6">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Employees Retiring Soon (Next 2 Years)</div>
        </div>
        <div class="card-content">
            <div class="space-y-3">
                @foreach($reportData['retiringSoon'] as $employee)
                <div class="flex justify-between items-center p-3 border rounded-lg">
                    <div>
                        <p class="font-medium">{{ $employee->name }}</p>
                        <p class="text-sm text-muted-foreground">{{ $employee->designationAtPresent }}</p>
                        <p class="text-xs text-muted-foreground">{{ $employee->presentPosting }}</p>
                    </div>
                    <div class="text-right">
                        <span class="badge badge-outline">{{ $employee->dateOfRetirement->format('d M, Y') }}</span>
                        <p class="text-xs text-muted-foreground mt-1">Retirement Date</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>