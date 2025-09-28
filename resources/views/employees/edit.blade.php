@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Edit Employee</h1>
                        <p class="text-gray-600">Update employee details</p>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700">
                            <i class="fas fa-save mr-2"></i>
                            Update Employee
                        </button>
                        <a href="{{ route('employees.show', $employee->id) }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-800 hover:border-blue-600 hover:text-blue-600 focus:outline-hidden focus:bg-gray-50">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                    </div>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    There were {{ $errors->count() }} errors with your submission
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

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
                                        <!-- Image Preview -->
                                        <div id="imagePreview" class="w-24 h-24 bg-gray-200 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                                            @if($employee->profile_image)
                                                <img id="previewImage" src="{{ asset('public/storage/' . $employee->profile_image) }}" class="w-full h-full object-cover" alt="Profile preview">
                                                <svg id="defaultAvatar" class="w-12 h-12 text-gray-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            @else
                                                <svg id="defaultAvatar" class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                <img id="previewImage" class="w-full h-full object-cover hidden" alt="Profile preview">
                                            @endif
                                        </div>
                                        
                                        <!-- Remove Image Button -->
                                        <button type="button" id="removeImage" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200 {{ $employee->profile_image ? '' : 'hidden' }}">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <label for="profile_image" class="label text-sm">Profile Photo</label>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <div class="flex-1">
                                            <input type="file" 
                                                   id="profile_image" 
                                                   name="profile_image" 
                                                   accept="image/*" 
                                                   class="hidden">
                                            <button type="button" 
                                                    onclick="document.getElementById('profile_image').click()" 
                                                    class="w-full sm:w-auto py-2 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Change Photo
                                            </button>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Max 2MB.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="empCode" class="label text-sm font-semibold">Employee Code *</label>
                                    <input type="text" id="empCode" name="empCode" 
                                        value="{{ old('empCode', $employee->empCode) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                        placeholder="130228" required>
                                </div>
                                <div>
                                    <label for="empId" class="label text-sm font-semibold">Employee ID *</label>
                                    <input type="text" id="empId" name="empId" 
                                        value="{{ old('empId', $employee->empId) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                        placeholder="295" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="name" class="label text-sm font-semibold">Full Name *</label>
                                <input type="text" id="name" name="name" 
                                    value="{{ old('name', $employee->name) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                    placeholder="DR. K S MURALI DHARA" required>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="gender" class="label text-sm font-semibold">Gender *</label>
                                    <select id="gender" name="gender" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" required>
                                        <option value="">Select Gender</option>
                                        <option value="MALE" {{ old('gender', $employee->gender) == 'MALE' ? 'selected' : '' }}>Male</option>
                                        <option value="FEMALE" {{ old('gender', $employee->gender) == 'FEMALE' ? 'selected' : '' }}>Female</option>
                                        <option value="OTHER" {{ old('gender', $employee->gender) == 'OTHER' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="category" class="label text-sm font-semibold">Category *</label>
                                    <select id="category" name="category" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" required>
                                        <option value="">Select Category</option>
                                        <option value="General" {{ old('category', $employee->category) == 'General' ? 'selected' : '' }}>General</option>
                                        <option value="OBC" {{ old('category', $employee->category) == 'OBC' ? 'selected' : '' }}>OBC</option>
                                        <option value="SC" {{ old('category', $employee->category) == 'SC' ? 'selected' : '' }}>SC</option>
                                        <option value="ST" {{ old('category', $employee->category) == 'ST' ? 'selected' : '' }}>ST</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="education" class="label text-sm font-semibold">Education</label>
                                <input type="text" id="education" name="education" 
                                    value="{{ old('education', $employee->education) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                    placeholder="M.SC.(PHY,ECO-ENVI), PH.D.(SCIENCE)">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="mobile" class="label text-sm font-semibold">Mobile</label>
                                    <input type="tel" id="mobile" name="mobile" 
                                        value="{{ old('mobile', $employee->mobile) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                        placeholder="9967533770" pattern="[0-9]{10}">
                                </div>
                                <div>
                                    <label for="email" class="label text-sm font-semibold">Email</label>
                                    <input type="email" id="email" name="email" 
                                        value="{{ old('email', $employee->email) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                        placeholder="employee@company.com">
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
                                <label for="dateOfAppointment" class="label text-sm font-semibold">Date of Appointment *</label>
                                <input type="date" id="dateOfAppointment" name="dateOfAppointment" 
                                    value="{{ old('dateOfAppointment', $employee->dateOfAppointment->format('Y-m-d')) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" required>
                            </div>

                            <div>
                                <label for="designationAtAppointment" class="label text-sm font-semibold">Designation at Appointment *</label>
                                <input type="text" id="designationAtAppointment" name="designationAtAppointment" 
                                    value="{{ old('designationAtAppointment', $employee->designationAtAppointment) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                    placeholder="QAO (LAB)" required>
                            </div>

                            <div>
                                <label for="designationAtPresent" class="label text-sm font-semibold">Current Designation *</label>
                                <input type="text" id="designationAtPresent" name="designationAtPresent" 
                                    value="{{ old('designationAtPresent', $employee->designationAtPresent) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                    placeholder="JT. DIRECTOR (LAB)" required>
                            </div>

                            <div>
                                <label for="presentPosting" class="label text-sm font-semibold">Present Posting *</label>
                                <input type="text" id="presentPosting" name="presentPosting" 
                                    value="{{ old('presentPosting', $employee->presentPosting) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                    placeholder="MUMBAI" required>
                            </div>

                            <div>
                                <label for="personalFileNo" class="label text-sm font-semibold">Personal File No.</label>
                                <input type="text" id="personalFileNo" name="personalFileNo" 
                                    value="{{ old('personalFileNo', $employee->personalFileNo) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                    placeholder="206">
                            </div>

                            <div>
                                <label for="officeLandline" class="label text-sm font-semibold">Office Landline</label>
                                <input type="text" id="officeLandline" name="officeLandline" 
                                    value="{{ old('officeLandline', $employee->officeLandline) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                    placeholder="02266527524">
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
                                    <label for="dateOfBirth" class="label text-sm font-semibold">Date of Birth *</label>
                                    <input type="date" id="dateOfBirth" name="dateOfBirth" 
                                        value="{{ old('dateOfBirth', $employee->dateOfBirth->format('Y-m-d')) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" required>
                                </div>
                                <div>
                                    <label for="dateOfRetirement" class="label text-sm font-semibold">Date of Retirement *</label>
                                    <input type="date" id="dateOfRetirement" name="dateOfRetirement" 
                                        value="{{ old('dateOfRetirement', $employee->dateOfRetirement->format('Y-m-d')) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" required>
                                </div>
                            </div>

                            <div>
                                <label for="homeTown" class="label text-sm font-semibold">Home Town</label>
                                <input type="text" id="homeTown" name="homeTown" 
                                    value="{{ old('homeTown', $employee->homeTown) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                    placeholder="KRISHNA RAJA NAGARA, MYSORE">
                            </div>

                            <div>
                                <label for="residentialAddress" class="label text-sm font-semibold">Residential Address</label>
                                <textarea id="residentialAddress" name="residentialAddress" 
                                    class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" rows="3" placeholder="Complete residential address">{{ old('residentialAddress', $employee->residentialAddress) }}</textarea>
                            </div>

                            <div>
                                <label for="status" class="label text-sm font-semibold">Status *</label>
                                <select id="status" name="status" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" required>
                                    <option value="">Select Status</option>
                                    <option value="EXISTING" {{ old('status', $employee->status) == 'EXISTING' ? 'selected' : '' }}>Active</option>
                                    <option value="RETIRED" {{ old('status', $employee->status) == 'RETIRED' ? 'selected' : '' }}>Retired</option>
                                    <option value="TRANSFERRED" {{ old('status', $employee->status) == 'TRANSFERRED' ? 'selected' : '' }}>Transferred</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- More Details -->
                <div class="card border rounded-xl">
                    <div class="card-header mb-5">
                        <div class="card-title text-2xl">More Details</div>
                    </div>
                    <div class="card-content space-y-4">
                        <div class="grid grid-cols-3 gap-4">
                            <!-- Checkbox fields -->
                            @php
                                $checkboxFields = [
                                    'office_in_charge' => 'Officer In Charge',
                                    'nps' => 'NPS',
                                    'probation_period' => 'Probation Period cleared',
                                    'department' => 'Department/Section Incharge',
                                    'increment_individual_selc' => 'Increment Individual selc',
                                    'increment_withheld' => 'Increment withheld',
                                    'FR56J_2nd_batch' => 'FR56J 2nd batch',
                                    'apar_hod' => 'Apar HoD',
                                    'karmayogi_certificate_completed' => 'Karmayogi Certificate Completed',
                                    '2021_2022' => '2021-2022',
                                    '2022_2023' => '2022-23 APAR',
                                    '2023_2024' => '2023-2024 APAR',
                                    '2024_2025' => '2024-25 APAR',
                                ];
                            @endphp

                            @foreach($checkboxFields as $field => $label)
                                <div class="mt-5">
                                    <label class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                                        <input type="checkbox" 
                                               name="{{ $field }}" 
                                               value="on" 
                                               {{ old($field, $employee->$field) ? 'checked' : '' }}
                                               class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500">
                                        <span class="text-sm text-gray-500 ms-3 font-semibold">{{ $label }}</span>
                                    </label>
                                </div>
                            @endforeach

                            <!-- Text fields -->
                            @php
                                $textFields = [
                                    'promotee_transferee' => 'Promotee/Transferee',
                                    'pension_file_no' => 'Pension File Number',
                                    'increment_month' => 'Increment Month',
                                    'status_of_post' => 'Status of Post',
                                    'seniority_sequence_no' => 'Seniority Sequence number',
                                    'sddlsection_incharge' => 'Addl section incharge',
                                    'benevolent_member' => 'Benevolent Member',
                                    'office_landline_number' => 'Office Landline Number',
                                ];
                            @endphp

                            @foreach($textFields as $field => $label)
                                <div>
                                    <label for="{{ $field }}" class="label text-sm font-semibold">{{ $label }}</label>
                                    <input type="text" id="{{ $field }}" name="{{ $field }}" 
                                        value="{{ old($field, $employee->$field) }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" 
                                        placeholder="{{ $label }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Include the same JavaScript from create page for image preview and validation
document.addEventListener('DOMContentLoaded', function() {
    // Your existing JavaScript code from create page
    // ... (copy the entire script section from create page)
});
</script>
@endsection