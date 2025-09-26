@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <form action="{{ route('employees.store') }}" method="POST">
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
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="empCode" class="label text-sm">Employee Code *</label>
                                    <input type="text" id="empCode" name="empCode" 
                                        value="{{ old('empCode') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
                                        placeholder="130228" required>
                                </div>
                                <div>
                                    <label for="empId" class="label text-sm">Employee ID *</label>
                                    <input type="text" id="empId" name="empId" 
                                        value="{{ old('empId') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
                                        placeholder="295" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="name" class="label text-sm">Full Name *</label>
                                <input type="text" id="name" name="name" 
                                    value="{{ old('name') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
                                    placeholder="DR. K S MURALI DHARA" required>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="gender" class="label text-sm">Gender *</label>
                                    <select id="gender" name="gender" class="py-3 px-4 pe-9 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" required>
                                        <option value="">Select Gender</option>
                                        <option value="MALE" {{ old('gender') == 'MALE' ? 'selected' : '' }}>Male</option>
                                        <option value="FEMALE" {{ old('gender') == 'FEMALE' ? 'selected' : '' }}>Female</option>
                                        <option value="OTHER" {{ old('gender') == 'OTHER' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="category" class="label text-sm">Category *</label>
                                    <select id="category" name="category" class="py-3 px-4 pe-9 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" required>
                                        <option value="">Select Category</option>
                                        <option value="General" {{ old('category') == 'General' ? 'selected' : '' }}>General</option>
                                        <option value="OBC" {{ old('category') == 'OBC' ? 'selected' : '' }}>OBC</option>
                                        <option value="SC" {{ old('category') == 'SC' ? 'selected' : '' }}>SC</option>
                                        <option value="ST" {{ old('category') == 'ST' ? 'selected' : '' }}>ST</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="education" class="label text-sm">Education</label>
                                <input type="text" id="education" name="education" 
                                    value="{{ old('education') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
                                    placeholder="M.SC.(PHY,ECO-ENVI), PH.D.(SCIENCE)">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="mobile" class="label text-sm">Mobile</label>
                                    <input type="tel" id="mobile" name="mobile" 
                                        value="{{ old('mobile') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
                                        placeholder="9967533770" pattern="[0-9]{10}">
                                </div>
                                <div>
                                    <label for="email" class="label text-sm">Email</label>
                                    <input type="email" id="email" name="email" 
                                        value="{{ old('email') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
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
                                <label for="dateOfAppointment" class="label text-sm">Date of Appointment *</label>
                                <input type="date" id="dateOfAppointment" name="dateOfAppointment" 
                                    value="{{ old('dateOfAppointment') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" required>
                            </div>

                            <div>
                                <label for="designationAtAppointment" class="label text-sm">Designation at Appointment *</label>
                                <input type="text" id="designationAtAppointment" name="designationAtAppointment" 
                                    value="{{ old('designationAtAppointment') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
                                    placeholder="QAO (LAB)" required>
                            </div>

                            <div>
                                <label for="designationAtPresent" class="label text-sm">Current Designation *</label>
                                <input type="text" id="designationAtPresent" name="designationAtPresent" 
                                    value="{{ old('designationAtPresent') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
                                    placeholder="JT. DIRECTOR (LAB)" required>
                            </div>

                            <div>
                                <label for="presentPosting" class="label text-sm">Present Posting *</label>
                                <input type="text" id="presentPosting" name="presentPosting" 
                                    value="{{ old('presentPosting') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
                                    placeholder="MUMBAI" required>
                            </div>

                            <div>
                                <label for="personalFileNo" class="label text-sm">Personal File No.</label>
                                <input type="text" id="personalFileNo" name="personalFileNo" 
                                    value="{{ old('personalFileNo') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
                                    placeholder="206">
                            </div>

                            <div>
                                <label for="officeLandline" class="label text-sm">Office Landline</label>
                                <input type="text" id="officeLandline" name="officeLandline" 
                                    value="{{ old('officeLandline') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
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
                                    <label for="dateOfBirth" class="label text-sm">Date of Birth *</label>
                                    <input type="date" id="dateOfBirth" name="dateOfBirth" 
                                        value="{{ old('dateOfBirth') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" required>
                                </div>
                                <div>
                                    <label for="dateOfRetirement" class="label text-sm">Date of Retirement *</label>
                                    <input type="date" id="dateOfRetirement" name="dateOfRetirement" 
                                        value="{{ old('dateOfRetirement') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" required>
                                </div>
                            </div>

                            <div>
                                <label for="homeTown" class="label text-sm">Home Town</label>
                                <input type="text" id="homeTown" name="homeTown" 
                                    value="{{ old('homeTown') }}" class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" 
                                    placeholder="KRISHNA RAJA NAGARA, MYSORE">
                            </div>

                            <div>
                                <label for="residentialAddress" class="label text-sm">Residential Address</label>
                                <textarea id="residentialAddress" name="residentialAddress" 
                                    class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="This is a textarea placeholder" placeholder="Complete residential address" 
                                    rows="3">{{ old('residentialAddress') }}</textarea>
                            </div>

                            <div>
                                <label for="status" class="label text-sm">Status *</label>
                                <select id="status" name="status" class="py-3 px-4 pe-9 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600" required>
                                    <option value="">Select Status</option>
                                    <option value="EXISTING" {{ old('status') == 'EXISTING' ? 'selected' : '' }}>Active</option>
                                    <option value="RETIRED" {{ old('status') == 'RETIRED' ? 'selected' : '' }}>Retired</option>
                                    <option value="TRANSFERRED" {{ old('status') == 'TRANSFERRED' ? 'selected' : '' }}>Transferred</option>
                                </select>
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
});
</script>
@endsection