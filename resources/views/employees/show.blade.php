@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Employee Details</h1>
                    <p class="text-gray-600">View complete employee information</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('employees.edit', $employee->id) }}" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Employee
                    </a>
                    <a href="{{ route('employees.index') }}" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-800 hover:border-blue-600 hover:text-blue-600 focus:outline-hidden focus:bg-gray-50">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Personal Information -->
                <div class="card border rounded-xl">
                    <div class="card-header mb-5">
                        <div class="card-title text-2xl">Personal Information</div>
                    </div>
                    <div class="card-content space-y-4">
                        <div class="flex flex-col sm:flex-row gap-6 items-start sm:items-center">
                            <div class="flex-shrink-0">
                                <div class="relative">
                                    @if($employee->profile_image)
                                        <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200">
                                            <img src="{{ asset('public/storage/' . $employee->profile_image) }}" 
                                                 alt="{{ $employee->name }}"
                                                 class="h-full w-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center">
                                            <span class="text-lg font-medium text-blue-800">
                                                {{ substr($employee->name, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $employee->name }}</h3>
                                <p class="text-gray-600">{{ $employee->email }}</p>
                                <p class="text-sm text-gray-500">Employee Code: {{ $employee->empCode }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">Employee Code</label>
                                <p class="text-gray-900">{{ $employee->empCode }}</p>
                            </div>
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">Employee ID</label>
                                <p class="text-gray-900">{{ $employee->empId }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Full Name</label>
                            <p class="text-gray-900">{{ $employee->name }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">Gender</label>
                                <p class="text-gray-900">{{ $employee->gender }}</p>
                            </div>
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">Category</label>
                                <p class="text-gray-900">{{ $employee->category }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Education</label>
                            <p class="text-gray-900">{{ $employee->education ?? 'N/A' }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">Mobile</label>
                                <p class="text-gray-900">{{ $employee->mobile ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">Email</label>
                                <p class="text-gray-900">{{ $employee->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Official Information -->
                <div class="card border rounded-xl">
                    <div class="card-header mb-5">
                        <div class="card-title text-2xl">Official Information</div>
                    </div>
                    <div class="card-content space-y-4">
                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Date of Appointment</label>
                            <p class="text-gray-900">{{ $employee->dateOfAppointment->format('d M, Y') }}</p>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Designation at Appointment</label>
                            <p class="text-gray-900">{{ $employee->designationAtAppointment }}</p>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Current Designation</label>
                            <p class="text-gray-900">{{ $employee->designationatappointment->name }}</p>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Present Posting</label>
                            <p class="text-gray-900">{{ $employee->designationatpresent->name }}</p>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Personal File No.</label>
                            <p class="text-gray-900">{{ $employee->personalFileNo ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Office Landline</label>
                            <p class="text-gray-900">{{ $employee->officeLandline ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Additional Details -->
                <div class="card border rounded-xl">
                    <div class="card-header mb-5">
                        <div class="card-title text-2xl">Additional Details</div>
                    </div>
                    <div class="card-content space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">Date of Birth</label>
                                <p class="text-gray-900">{{ $employee->dateOfBirth->format('d M, Y') }}</p>
                            </div>
                            <div>
                                <label class="label text-sm font-semibold text-gray-500">Date of Retirement</label>
                                <p class="text-gray-900">{{ $employee->dateOfRetirement->format('d M, Y') }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Age</label>
                            <p class="text-gray-900">{{ $employee->age }} years</p>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Home Town</label>
                            <p class="text-gray-900">{{ $employee->homeTown ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Residential Address</label>
                            <p class="text-gray-900 whitespace-pre-line">{{ $employee->residentialAddress ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($employee->status === 'EXISTING') bg-green-100 text-green-800
                                @elseif($employee->status === 'RETIRED') bg-gray-100 text-gray-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $employee->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- More Details -->
            <div class="card border rounded-xl">
                <div class="card-header mb-5">
                    <div class="card-title text-2xl">More Details</div>
                </div>
                <div class="card-content">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @php
                            $checkboxFields = [
                                'office_in_charge' => 'Officer In Charge',
                                'nps' => 'NPS',
                                'probation_period' => 'Probation Period Cleared',
                                'department' => 'Department/Section Incharge',
                                'increment_individual_selc' => 'Increment Individual Selection',
                                'increment_withheld' => 'Increment Withheld',
                                'FR56J_2nd_batch' => 'FR56J 2nd Batch',
                                'apar_hod' => 'APAR HoD',
                                'karmayogi_certificate_completed' => 'Karmayogi Certificate Completed',
                                '2021_2022' => '2021-2022 APAR',
                                '2022_2023' => '2022-2023 APAR',
                                '2023_2024' => '2023-2024 APAR',
                                '2024_2025' => '2024-2025 APAR',
                            ];
                        @endphp

                        @foreach($checkboxFields as $field => $label)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" 
                                           {{ $employee->$field ? 'checked' : '' }} 
                                           disabled
                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                </div>
                                <label class="ms-2 text-sm font-medium text-gray-900">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                        @php
                            $textFields = [
                                'promotee_transferee' => 'Promotee/Transferee',
                                'pension_file_no' => 'Pension File Number',
                                'increment_month' => 'Increment Month',
                                'status_of_post' => 'Status of Post',
                                'seniority_sequence_no' => 'Seniority Sequence Number',
                                'sddlsection_incharge' => 'Additional Section Incharge',
                                'benevolent_member' => 'Benevolent Member',
                                'office_landline_number' => 'Office Landline Number',
                            ];
                        @endphp

                        @foreach($textFields as $field => $label)
                            @if($employee->$field)
                                <div>
                                    <label class="label text-sm font-semibold text-gray-500">{{ $label }}</label>
                                    <p class="text-gray-900">{{ $employee->$field }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- APAR Grading Section -->
<div class="card border rounded-xl">
    <div class="card-header mb-5">
        <div class="card-title text-2xl">APAR Grading History</div>
    </div>
    <div class="card-content">
        @if($employee->aparGradings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grading Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reporting Marks</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reviewing Marks</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Consideration</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employee->aparGradings as $apar)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $apar->from_month }} {{ $apar->from_year }} - {{ $apar->to_month }} {{ $apar->to_year }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $apar->grading_type }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $apar->reporting_marks ?? 'N/A' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $apar->reviewing_marks ?? 'N/A' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $apar->consideration ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $apar->consideration ? 'TRUE' : 'FALSE' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No APAR records found for this employee.</p>
        @endif
    </div>
</div>            


<!-- Financial Upgradation Section -->
<div class="card border rounded-xl">
    <div class="card-header mb-5">
        <div class="card-title text-2xl">Financial Upgradation History</div>
    </div>
    <div class="card-content">
        @if($employee->financialUpgradations->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Promotion Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Existing Designation</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Upgraded Designation</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Existing Scale</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Upgraded Scale</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pay Fixed</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Financial Upgradation</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employee->financialUpgradations as $finance)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $finance->promotion_date }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $finance->existing_designation }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $finance->upgraded_designation }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $finance->existing_scale }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $finance->upgraded_scale }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $finance->pay_fixed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $finance->pay_fixed ? 'YES' : 'NO' }}
                                </span>
                            </td>                            
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $finance->financial_upgradation_type ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $finance->financial_upgradation_type }} 
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No Financial Upgradation records found for this employee.</p>
        @endif
    </div>
</div>


<!-- MOM Section -->
<div class="card border rounded-xl">
    <div class="card-header mb-5">
    </div>
    <div class="card-content">
        <div class="card-title text-2xl">Mode of Recruitment History</div>
        @if($employee->mom->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <!-- <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th> -->
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Designation</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seniority No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Entry</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Office Order</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pay Fixation</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employee->mom as $record)
                                                            <tr>
                                        <!-- <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->PromotionID }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $record->employee->name }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $record->employee->empId }} | Code: {{ $record->employee->empCode }}</div>
                                </div>
                            </td> -->
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $record->Designation }}</div>
                                                <div class="text-sm text-gray-500">{{ $record->Designation_ }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->Seniority_Number }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $record->formattedDateOfEntry }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($record->Office_Order_No, 30) }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $record->Method_of_Recruitment }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $record->Pay_Fixation == 'Yes' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $record->Pay_Fixation }}
                                            </span>
                                        </td>
                                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No MOM records found for this employee.</p>
        @endif
    </div>
</div>

            <!-- Timestamps -->
            <div class="card border rounded-xl">
                <div class="card-header mb-5">
                    <div class="card-title text-2xl">System Information</div>
                </div>
                <div class="card-content">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Created At</label>
                            <p class="text-gray-900">{{ $employee->created_at->format('d M, Y h:i A') }}</p>
                        </div>
                        <div>
                            <label class="label text-sm font-semibold text-gray-500">Last Updated</label>
                            <p class="text-gray-900">{{ $employee->updated_at->format('d M, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection