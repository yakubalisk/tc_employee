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
                    <button type="submit" class="btn btn-primary">
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
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Personal Information</div>
                        </div>
                        <div class="card-content space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="empCode" class="label">Employee Code *</label>
                                    <input type="text" id="empCode" name="empCode" 
                                        value="{{ old('empCode') }}" class="input" 
                                        placeholder="130228" required>
                                </div>
                                <div>
                                    <label for="empId" class="label">Employee ID *</label>
                                    <input type="text" id="empId" name="empId" 
                                        value="{{ old('empId') }}" class="input" 
                                        placeholder="295" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="name" class="label">Full Name *</label>
                                <input type="text" id="name" name="name" 
                                    value="{{ old('name') }}" class="input" 
                                    placeholder="DR. K S MURALI DHARA" required>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="gender" class="label">Gender *</label>
                                    <select id="gender" name="gender" class="select" required>
                                        <option value="">Select Gender</option>
                                        <option value="MALE" {{ old('gender') == 'MALE' ? 'selected' : '' }}>Male</option>
                                        <option value="FEMALE" {{ old('gender') == 'FEMALE' ? 'selected' : '' }}>Female</option>
                                        <option value="OTHER" {{ old('gender') == 'OTHER' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="category" class="label">Category *</label>
                                    <select id="category" name="category" class="select" required>
                                        <option value="">Select Category</option>
                                        <option value="General" {{ old('category') == 'General' ? 'selected' : '' }}>General</option>
                                        <option value="OBC" {{ old('category') == 'OBC' ? 'selected' : '' }}>OBC</option>
                                        <option value="SC" {{ old('category') == 'SC' ? 'selected' : '' }}>SC</option>
                                        <option value="ST" {{ old('category') == 'ST' ? 'selected' : '' }}>ST</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="education" class="label">Education</label>
                                <input type="text" id="education" name="education" 
                                    value="{{ old('education') }}" class="input" 
                                    placeholder="M.SC.(PHY,ECO-ENVI), PH.D.(SCIENCE)">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="mobile" class="label">Mobile</label>
                                    <input type="tel" id="mobile" name="mobile" 
                                        value="{{ old('mobile') }}" class="input" 
                                        placeholder="9967533770" pattern="[0-9]{10}">
                                </div>
                                <div>
                                    <label for="email" class="label">Email</label>
                                    <input type="email" id="email" name="email" 
                                        value="{{ old('email') }}" class="input" 
                                        placeholder="employee@company.com">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Official Information -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Official Information</div>
                        </div>
                        <div class="card-content space-y-4">
                            <div>
                                <label for="dateOfAppointment" class="label">Date of Appointment *</label>
                                <input type="date" id="dateOfAppointment" name="dateOfAppointment" 
                                    value="{{ old('dateOfAppointment') }}" class="input" required>
                            </div>

                            <div>
                                <label for="designationAtAppointment" class="label">Designation at Appointment *</label>
                                <input type="text" id="designationAtAppointment" name="designationAtAppointment" 
                                    value="{{ old('designationAtAppointment') }}" class="input" 
                                    placeholder="QAO (LAB)" required>
                            </div>

                            <div>
                                <label for="designationAtPresent" class="label">Current Designation *</label>
                                <input type="text" id="designationAtPresent" name="designationAtPresent" 
                                    value="{{ old('designationAtPresent') }}" class="input" 
                                    placeholder="JT. DIRECTOR (LAB)" required>
                            </div>

                            <div>
                                <label for="presentPosting" class="label">Present Posting *</label>
                                <input type="text" id="presentPosting" name="presentPosting" 
                                    value="{{ old('presentPosting') }}" class="input" 
                                    placeholder="MUMBAI" required>
                            </div>

                            <div>
                                <label for="personalFileNo" class="label">Personal File No.</label>
                                <input type="text" id="personalFileNo" name="personalFileNo" 
                                    value="{{ old('personalFileNo') }}" class="input" 
                                    placeholder="206">
                            </div>

                            <div>
                                <label for="officeLandline" class="label">Office Landline</label>
                                <input type="text" id="officeLandline" name="officeLandline" 
                                    value="{{ old('officeLandline') }}" class="input" 
                                    placeholder="02266527524">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Additional Details</div>
                        </div>
                        <div class="card-content space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="dateOfBirth" class="label">Date of Birth *</label>
                                    <input type="date" id="dateOfBirth" name="dateOfBirth" 
                                        value="{{ old('dateOfBirth') }}" class="input" required>
                                </div>
                                <div>
                                    <label for="dateOfRetirement" class="label">Date of Retirement *</label>
                                    <input type="date" id="dateOfRetirement" name="dateOfRetirement" 
                                        value="{{ old('dateOfRetirement') }}" class="input" required>
                                </div>
                            </div>

                            <div>
                                <label for="homeTown" class="label">Home Town</label>
                                <input type="text" id="homeTown" name="homeTown" 
                                    value="{{ old('homeTown') }}" class="input" 
                                    placeholder="KRISHNA RAJA NAGARA, MYSORE">
                            </div>

                            <div>
                                <label for="residentialAddress" class="label">Residential Address</label>
                                <textarea id="residentialAddress" name="residentialAddress" 
                                    class="textarea" placeholder="Complete residential address" 
                                    rows="3">{{ old('residentialAddress') }}</textarea>
                            </div>

                            <div>
                                <label for="status" class="label">Status *</label>
                                <select id="status" name="status" class="select" required>
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
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <a href="{{ route('employees.index') }}" class="btn btn-outline">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Save Employee
                    </button>
                </div>
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