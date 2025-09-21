@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Export Data</h1>
            <p class="text-muted-foreground">Export employee data in various formats</p>
        </div>
        <div class="flex gap-2">
            <button type="button" onclick="openScheduleModal()" class="btn btn-outline">
                <i class="settings-icon mr-2"></i>
                Schedule Export
            </button>
            <button type="button" onclick="openEmailModal()" class="btn btn-outline">
                <i class="mail-icon mr-2"></i>
                Email Report
            </button>
        </div>
    </div>

    <form action="{{ route('export.process') }}" method="POST" id="exportForm">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Export Configuration -->
            <div class="lg:col-span-2 card">
                <div class="card-header">
                    <div class="card-title">Export Configuration</div>
                </div>
                <div class="card-content space-y-6">
                    <!-- Export Format -->
                    <div>
                        <label class="text-base font-medium">Export Format</label>
                        <div class="grid grid-cols-3 gap-3 mt-2">
                            @foreach($exportFormats as $format)
                            <div
                                class="p-4 border rounded-lg cursor-pointer transition-colors {{ $exportFormat === $format['value'] ? 'border-primary bg-primary/5' : 'border-border hover:bg-muted/50' }}"
                                onclick="setExportFormat('{{ $format['value'] }}')"
                            >
                                <i class="{{ $format['icon'] }} h-6 w-6 mb-2 text-primary"></i>
                                <p class="text-sm font-medium">{{ $format['label'] }}</p>
                            </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="format" id="exportFormat" value="{{ $exportFormat }}">
                    </div>

                    <!-- Export Type -->
                    <div>
                        <label for="export-type" class="label">Report Type</label>
                        <select name="type" id="export-type" class="select" onchange="this.form.submit()">
                            @foreach($exportTypes as $type)
                            <option value="{{ $type['value'] }}" {{ $exportType === $type['value'] ? 'selected' : '' }}>
                                {{ $type['label'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filters -->
                    <div>
                        <label class="text-base font-medium mb-3 block">Data Filters</label>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="filter-gender" class="label">Gender</label>
                                <select name="gender" id="filter-gender" class="select" onchange="this.form.submit()">
                                    <option value="all" {{ $filterGender === 'all' ? 'selected' : '' }}>All Genders</option>
                                    <option value="MALE" {{ $filterGender === 'MALE' ? 'selected' : '' }}>Male</option>
                                    <option value="FEMALE" {{ $filterGender === 'FEMALE' ? 'selected' : '' }}>Female</option>
                                    <option value="OTHER" {{ $filterGender === 'OTHER' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div>
                                <label for="filter-category" class="label">Category</label>
                                <select name="category" id="filter-category" class="select" onchange="this.form.submit()">
                                    <option value="all" {{ $filterCategory === 'all' ? 'selected' : '' }}>All Categories</option>
                                    <option value="General" {{ $filterCategory === 'General' ? 'selected' : '' }}>General</option>
                                    <option value="OBC" {{ $filterCategory === 'OBC' ? 'selected' : '' }}>OBC</option>
                                    <option value="SC" {{ $filterCategory === 'SC' ? 'selected' : '' }}>SC</option>
                                    <option value="ST" {{ $filterCategory === 'ST' ? 'selected' : '' }}>ST</option>
                                </select>
                            </div>

                            <div>
                                <label for="filter-department" class="label">Department</label>
                                <select name="department" id="filter-department" class="select" onchange="this.form.submit()">
                                    <option value="all" {{ $filterDepartment === 'all' ? 'selected' : '' }}>All Departments</option>
                                    <option value="MUMBAI" {{ $filterDepartment === 'MUMBAI' ? 'selected' : '' }}>Mumbai</option>
                                    <option value="DELHI" {{ $filterDepartment === 'DELHI' ? 'selected' : '' }}>Delhi</option>
                                    <option value="KOLKATA" {{ $filterDepartment === 'KOLKATA' ? 'selected' : '' }}>Kolkata</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Field Selection -->
                    <div>
                        <label class="text-base font-medium mb-3 block">Select Fields to Export</label>
                        <div class="grid grid-cols-2 gap-3 max-h-64 overflow-y-auto border rounded-lg p-4">
                            @foreach($availableFields as $field)
                            <div class="flex items-center space-x-2">
                                <input
                                    type="checkbox"
                                    id="field-{{ $field['id'] }}"
                                    name="fields[]"
                                    value="{{ $field['id'] }}"
                                    {{ in_array($field['id'], $selectedFields) ? 'checked' : '' }}
                                    onchange="this.form.submit()"
                                    class="checkbox"
                                >
                                <label for="field-{{ $field['id'] }}" class="text-sm font-normal">
                                    {{ $field['label'] }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Summary -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Export Summary</div>
                </div>
                <div class="card-content space-y-4">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium">Format:</span>
                            <span class="badge badge-secondary">
                                {{ collect($exportFormats)->firstWhere('value', $exportFormat)['label'] }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium">Records:</span>
                            <span class="badge badge-outline">{{ $employeeCount }} employees</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium">Fields:</span>
                            <span class="badge badge-outline">{{ count($selectedFields) }} fields</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium">Estimated Size:</span>
                            <span class="badge badge-outline">
                                {{ round(($employeeCount * count($selectedFields) * 0.1)) }} KB
                            </span>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h4 class="font-medium text-sm mb-2">Selected Fields:</h4>
                        <div class="flex flex-wrap gap-1">
                            @foreach(array_slice($selectedFields, 0, 6) as $fieldId)
                                @php $field = collect($availableFields)->firstWhere('id', $fieldId); @endphp
                                <span class="badge badge-secondary text-xs">
                                    {{ $field['label'] ?? $fieldId }}
                                </span>
                            @endforeach
                            @if(count($selectedFields) > 6)
                                <span class="badge badge-secondary text-xs">
                                    +{{ count($selectedFields) - 6 }} more
                                </span>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="w-full btn btn-primary btn-lg">
                        <i class="download-icon mr-2"></i>
                        Export Data
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Recent Exports -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Recent Exports</div>
        </div>
        <div class="card-content">
            <div class="space-y-3">
                @foreach([
                    ['name' => 'All Employees Report', 'date' => '2025-01-08', 'format' => 'Excel', 'size' => '2.4 MB'],
                    ['name' => 'Promotion Report Q4', 'date' => '2025-01-05', 'format' => 'PDF', 'size' => '1.8 MB'],
                    ['name' => 'Department Wise Analysis', 'date' => '2025-01-03', 'format' => 'CSV', 'size' => '850 KB'],
                ] as $export)
                <div class="flex items-center justify-between p-3 border rounded-lg">
                    <div class="flex items-center gap-3">
                        <i class="file-text-icon h-5 w-5 text-muted-foreground"></i>
                        <div>
                            <p class="font-medium text-sm">{{ $export['name'] }}</p>
                            <p class="text-xs text-muted-foreground">
                                {{ $export['date'] }} • {{ $export['format'] }} • {{ $export['size'] }}
                            </p>
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-sm">
                        <i class="download-icon h-4 w-4"></i>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modals would be implemented here for email and schedule functionality -->

@push('scripts')
<script>
    function setExportFormat(format) {
        document.getElementById('exportFormat').value = format;
        document.getElementById('exportForm').submit();
    }

    function openEmailModal() {
        // Implement email modal
        alert('Email report functionality would open a modal here.');
    }

    function openScheduleModal() {
        // Implement schedule modal
        alert('Schedule export functionality would open a modal here.');
    }
</script>
@endpush

@push('styles')
<style>
.file-spreadsheet-icon, .file-text-icon, .table-icon, .download-icon, 
.settings-icon, .mail-icon {
    width: 1rem;
    height: 1rem;
    display: inline-block;
    background-size: cover;
}

.file-spreadsheet-icon { background-image: url("data:image/svg+xml,..."); }
.file-text-icon { background-image: url("data:image/svg+xml,..."); }
.table-icon { background-image: url("data:image/svg+xml,..."); }
.download-icon { background-image: url("data:image/svg+xml,..."); }
.settings-icon { background-image: url("data:image/svg+xml,..."); }
.mail-icon { background-image: url("data:image/svg+xml,..."); }
</style>
@endpush
@endsection