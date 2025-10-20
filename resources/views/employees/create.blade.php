@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Add New Employee</h1>
                        <p class="text-gray-600">Enter employee details to create a new record</p>
                    </div>
                    <button type="submit" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        <i class="fas fa-save mr-2"></i>
                        Save Employee
                    </button>
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

                <!-- Success Message -->
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
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
                    <div id="imagePreview" class="w-24 h-24 bg-gray-200 dark:bg-neutral-700 rounded-full border-2 border-dashed border-gray-300 dark:border-neutral-600 flex items-center justify-center overflow-hidden">
                        <svg id="defaultAvatar" class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <img id="previewImage" class="w-full h-full object-cover hidden" alt="Profile preview">
                    </div>
                    
                    <!-- Remove Image Button -->
                    <button type="button" id="removeImage" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200 hidden">
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
                               value="{{ old('profile_image') }}"
                               name="profile_image" 
                               accept="image/*" 
                               class="hidden"
                               >
                        <button type="button" 
                                onclick="document.getElementById('profile_image').click()" 
                                class="w-full sm:w-auto py-2 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 dark:bg-neutral-800 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Choose Photo
                        </button>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-neutral-400">
                        Max 2MB.
                    </div>
                </div>
            </div>
        </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="empCode" class="label text-sm font-semibold">Employee Code *</label>
                                    <input type="text" id="empCode" name="empCode" 
                                        value="{{ old('empCode') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                        placeholder="130228" required>
                                </div>
                                <!-- <div>
                                    <label for="empId" class="label text-sm font-semibold">Employee ID *</label>
                                    <input type="text" id="empId" name="empId" 
                                        value="{{ old('empId') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                        placeholder="295" required>
                                </div> -->
                            </div>
                            
                            <div>
                                <label for="name" class="label text-sm font-semibold">Full Name *</label>
                                <input type="text" id="name" name="name" 
                                    value="{{ old('name') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                    placeholder="DR. K S MURALI DHARA" required>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="gender" class="label text-sm font-semibold">Gender *</label>
                                    <select id="gender" name="gender" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" required>
                                        <option value="">Select Gender</option>
                                        <option value="MALE" {{ old('gender') == 'MALE' ? 'selected' : '' }}>Male</option>
                                        <option value="FEMALE" {{ old('gender') == 'FEMALE' ? 'selected' : '' }}>Female</option>
                                        <option value="OTHER" {{ old('gender') == 'OTHER' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="category" class="label text-sm font-semibold">Category *</label>
                                    <select id="category" name="category" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" required>
                                        <option value="">Select Category</option>
                                        <option value="General" {{ old('category') == 'General' ? 'selected' : '' }}>General</option>
                                        <option value="OBC" {{ old('category') == 'OBC' ? 'selected' : '' }}>OBC</option>
                                        <option value="SC" {{ old('category') == 'SC' ? 'selected' : '' }}>SC</option>
                                        <option value="ST" {{ old('category') == 'ST' ? 'selected' : '' }}>ST</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="education" class="label text-sm font-semibold">Education</label>
                                <input type="text" id="education" name="education" 
                                    value="{{ old('education') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                    placeholder="M.SC.(PHY,ECO-ENVI), PH.D.(SCIENCE)">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="mobile" class="label text-sm font-semibold">Mobile</label>
                                    <input type="tel" id="mobile" name="mobile" 
                                        value="{{ old('mobile') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                        placeholder="9967533770" pattern="[0-9]{10}">
                                </div>
                                <div>
                                    <label for="email" class="label text-sm font-semibold">Email</label>
                                    <input type="email" id="email" name="email" 
                                        value="{{ old('email') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
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
                                    value="{{ old('dateOfAppointment') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" required>
                            </div>

                            <!-- <div>
                                <label for="designationAtAppointment" class="label text-sm font-semibold">Designation at Appointment *</label>
                                <input type="text" id="designationAtAppointment" name="designationAtAppointment" 
                                    value="{{ old('designationAtAppointment') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                    placeholder="QAO (LAB)" required>
                            </div> -->

                            <div>
                                <label for="designationAtAppointment" class="block text-sm font-medium text-gray-700 mb-1">Designation at Appointment *</label>
                                    <select name="designationAtAppointment" id="designationAtAppointment" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Designation</option>
                                        @foreach($designations as $id => $name)
                                            <option value="{{ $id }}" {{ old('designationAtAppointment') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('designationAtAppointment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>                            

                                <div>
                                <label for="designationAtPresent" class="block text-sm font-medium text-gray-700 mb-1">Current Designation *</label>
                                    <select name="designationAtPresent" id="designationAtPresent" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Designation</option>
                                        @foreach($designations as $id => $name)
                                            <option value="{{ $id }}" {{ old('designationAtPresent') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('designationAtPresent') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                            <!-- <div>
                                <label for="designationAtPresent" class="label text-sm font-semibold">Current Designation *</label>
                                <input type="text" id="designationAtPresent" name="designationAtPresent" 
                                    value="{{ old('designationAtPresent') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                    placeholder="JT. DIRECTOR (LAB)" required>
                            </div> -->

                            <!-- <div>
                                <label for="presentPosting" class="label text-sm font-semibold">Present Posting *</label>
                                <input type="text" id="presentPosting" name="presentPosting" 
                                    value="{{ old('presentPosting') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                    placeholder="MUMBAI" required>
                            </div> -->

                            <div>
                                <label for="presentPosting" class="block text-sm font-medium text-gray-700 mb-1">Present Posting *</label>
                                    <select name="presentPosting" id="presentPosting" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="">Select Present Posting</option>
                                        @foreach($regions as $id => $name)
                                            <option value="{{ $id }}" {{ old('presentPosting') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('presentPosting') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                            <div>
                                <label for="personalFileNo" class="label text-sm font-semibold">Personal File No.</label>
                                <input type="text" id="personalFileNo" name="personalFileNo" 
                                    value="{{ old('personalFileNo') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                    placeholder="206">
                            </div>

                            <div>
                                <label for="officeLandline" class="label text-sm font-semibold">Office Landline</label>
                                <input type="text" id="officeLandline" name="officeLandline" 
                                    value="{{ old('officeLandline') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
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
                                        value="{{ old('dateOfBirth') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" required>
                                </div>
                                <div>
                                    <label for="dateOfRetirement" class="label text-sm font-semibold">Date of Retirement *</label>
                                    <input type="date" id="dateOfRetirement" name="dateOfRetirement" 
                                        value="{{ old('dateOfRetirement') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" required>
                                </div>
                            </div>

                            <div>
                                <label for="homeTown" class="label text-sm font-semibold">Home Town</label>
                                <input type="text" id="homeTown" name="homeTown" 
                                    value="{{ old('homeTown') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                    placeholder="KRISHNA RAJA NAGARA, MYSORE">
                            </div>

                            <div>
                                <label for="residentialAddress" class="label text-sm font-semibold">Residential Address</label>
                                <textarea id="residentialAddress" name="residentialAddress" 
                                    class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" rows="3" placeholder="This is a textarea placeholder" placeholder="Complete residential address" 
                                    rows="3">{{ old('residentialAddress') }}</textarea>
                            </div>

                            <div>
                                <label for="status" class="label text-sm font-semibold">Status *</label>
                                <select id="status" name="status" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" required>
                                    <option value="">Select Status</option>
                                    <option value="EXISTING" {{ old('status') == 'EXISTING' ? 'selected' : '' }}>Active</option>
                                    <option value="RETIRED" {{ old('status') == 'RETIRED' ? 'selected' : '' }}>Retired</option>
                                    <option value="TRANSFERRED" {{ old('status') == 'TRANSFERRED' ? 'selected' : '' }}>Transferred</option>
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
                                <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('office_in_charge') }}" name="office_in_charge" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">Officer In Charge</span>
                                      </label>
                                </div>                                
                                <div>
                                    <label for="homeTown" class="label text-sm font-semibold">Promotee/Transferee</label>
                                    <input type="text" id="homeTown" name="promotee_transferee" 
                                        value="{{ old('promotee_transferee') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                        placeholder="Promotee/Transferee">
                                </div>
                                <div>
                                    <label for="homeTown" class="label text-sm font-semibold">Pension FIle Number</label>
                                    <input type="text" id="homeTown" name="pension_file_no" 
                                        value="{{ old('pension_file_no') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                        placeholder="Pension FIle Number">
                                </div>
                                <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('nps') }}" name="nps" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">NPS</span>
                                      </label>
                                </div>                                
                                <div>
                                    <label for="homeTown" class="label text-sm font-semibold">Increment Month</label>
                                    <input type="text" id="homeTown" name="increment_month" 
                                        value="{{ old('increment_month') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                        placeholder="Increment Month">
                                </div>
                                <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('pwd') }}" name="pwd" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">PWD</span>
                                      </label>
                                </div>
                                <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('probation_period') }}" name="probation_period" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">Probation Period cleared</span>
                                      </label>
                                </div>                                
                                <div>
                                    <label for="homeTown" class="label text-sm font-semibold">Status of Post</label>
                                    <input type="text" id="homeTown" name="status_of_post" 
                                        value="{{ old('status_of_post') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                        placeholder="KRISHNA RAJA NAGARA, MYSORE">
                                </div>
                                <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('department') }}" name="department" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">Department/Section Incharge</span>
                                      </label>
                                </div>                                 
                                <!-- <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('2021_2022') }}" name="2021_2022" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">2021-2022</span>
                                      </label>
                                </div> -->                                
                                <div>
                                    <label for="homeTown" class="label text-sm font-semibold">Seniority Sequence number</label>
                                    <input type="text" id="homeTown" name="seniority_sequence_no" 
                                        value="{{ old('seniority_sequence_no') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                        placeholder="Seniority Sequence number">
                                </div>                                
                                <div>
                                    <label for="homeTown" class="label text-sm font-semibold">Addl section incharge</label>
                                    <textarea type="text" id="homeTown" name="sddlsection_incharge" 
                                        value="{{ old('sddlsection_incharge') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                        placeholder="Addl section incharge"></textarea>
                                </div>                                
                                <!-- <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('2023_2024') }}" name="2023_2024" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">2023-2024 APAR</span>
                                      </label>
                                </div> -->                                  
                                <div>
                                    <label for="homeTown" class="label text-sm font-semibold">Benevolent Member</label>
                                    <input type="text" id="homeTown" name="benevolent_member" 
                                        value="{{ old('benevolent_member') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                        placeholder="Benevolent Member">
                                </div>
                                <div></div>
                                <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('2022_2023') }}" name="2022_2023" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">2022-23 APAR</span>
                                      </label>
                                </div>
                                <!-- <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('increment_individual_selc') }}" name="increment_individual_selc" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">Increment Individual selc</span>
                                      </label>
                                </div> -->
                                <div>
                                    <label for="homeTown" class="label text-sm font-semibold">Office Landline Number</label>
                                    <input type="text" id="homeTown" name="office_landline_number" 
                                        value="{{ old('office_landline_number') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border" 
                                        placeholder="KRISHNA RAJA NAGARA, MYSORE">
                                </div> 
                                <!-- <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('increment_withheld') }}" name="increment_withheld" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">Increment withheld</span>
                                      </label>
                                </div> -->
                                <!-- <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('FR56J_2nd_batch') }}" name="FR56J_2nd_batch" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">FR56J 2nd batch</span>
                                      </label>
                                </div> -->
                                <!-- <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('apar_hod') }}" name="apar_hod" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">Apar HoD</span>
                                      </label>
                                </div>  -->
                                <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('2024_2025') }}" name="2024_2025" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">2024-25 APAR</span>
                                      </label>
                                </div> <div class="mt-5">
                                      <label for="hs-checkbox-in-form" class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="checkbox" value="{{ old('karmayogi_certificate_completed') == 1 ? 'checked' : '' }}" name="karmayogi_certificate_completed" class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-checkbox-in-form sm:text-sm">
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400 font-semibold">Karmayogi Certificate Completed
</span>
                                      </label>
                                </div>                                                             
                            </div>
                        </div>
                    </div>

                <!-- Form Actions -->
               <!--  <div class="flex justify-end gap-3 pt-6 border-t">
                    <a href="{{ route('employees.index') }}" class="btn btn-outline">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Save Employee
                    </button>
                </div> -->
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set max date for retirement date to be after birth date
    const dobInput = document.getElementById('dateOfBirth');
    const retirementInput = document.getElementById('dateOfRetirement');
    
    if (dobInput && retirementInput) {
        dobInput.addEventListener('change', function() {
            retirementInput.min = this.value;
            if (retirementInput.value && retirementInput.value < this.value) {
                retirementInput.value = '';
            }
        });
    }

    // Set max date for appointment date to today
    const appointmentInput = document.getElementById('dateOfAppointment');
    if (appointmentInput) {
        const today = new Date().toISOString().split('T')[0];
        appointmentInput.max = today;
    }

    // Mobile number validation
    const mobileInput = document.getElementById('mobile');
    if (mobileInput) {
        mobileInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
        });
    }
 // Image preview functionality
    const imageInput = document.getElementById('profile_image');
    const preview = document.getElementById('previewImage');
    const defaultAvatar = document.getElementById('defaultAvatar');
    const removeButton = document.getElementById('removeImage');
    const dropArea = document.getElementById('imagePreview');

    // Handle file input change
    imageInput.addEventListener('change', function(e) {
        handleImageSelection(this);
    });

    function handleImageSelection(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                input.value = '';
                return;
            }
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG, PNG, or WEBP)');
                input.value = '';
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                defaultAvatar.classList.add('hidden');
                removeButton.classList.remove('hidden');
            }
            
            reader.readAsDataURL(file);
        }
    }

    // Remove image functionality
    removeButton.addEventListener('click', function() {
        imageInput.value = '';
        preview.src = '';
        preview.classList.add('hidden');
        defaultAvatar.classList.remove('hidden');
        removeButton.classList.add('hidden');
    });

    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        dropArea.classList.add('border-blue-500', 'border-2');
    }

    function unhighlight() {
        dropArea.classList.remove('border-blue-500', 'border-2');
    }

    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length) {
            imageInput.files = files;
            handleImageSelection(imageInput);
        }
    }

    // Click on preview to upload
    dropArea.addEventListener('click', function() {
        imageInput.click();
    });
});

</script>
@endsection