@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-foreground">Add New Employee</h1>
                <p class="text-muted-foreground">Enter employee details to create a new record</p>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="save-icon mr-2"></i>
                Save Employee
            </button>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Personal Information -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Personal Information</div>
                </div>
                <div class="card-content space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="empCode" class="label">Employee Code</label>
                            <input type="text" id="empCode" name="empCode" value="{{ old('empCode') }}" 
                                class="input" placeholder="130228" required>
                        </div>
                        <div>
                            <label for="empId" class="label">Employee ID</label>
                            <input type="text" id="empId" name="empId" value="{{ old('empId') }}" 
                                class="input" placeholder="295" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="name" class="label">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                            class="input" placeholder="DR. K S MURALI DHARA" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="gender" class="label">Gender</label>
                            <select id="gender" name="gender" class="select" required>
                                <option value="">Select Gender</option>
                                <option value="MALE" {{ old('gender') == 'MALE' ? 'selected' : '' }}>Male</option>
                                <option value="FEMALE" {{ old('gender') == 'FEMALE' ? 'selected' : '' }}>Female</option>
                                <option value="OTHER" {{ old('gender') == 'OTHER' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="category" class="label">Category</label>
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
                        <input type="text" id="education" name="education" value="{{ old('education') }}" 
                            class="input" placeholder="M.SC.(PHY,ECO-ENVI), PH.D.(SCIENCE)">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="mobile" class="label">Mobile</label>
                            <input type="tel" id="mobile" name="mobile" value="{{ old('mobile') }}" 
                                class="input" placeholder="9967533770" pattern="[0-9]{10}">
                        </div>
                        <div>
                            <label for="email" class="label">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" 
                                class="input" placeholder="employee@company.com">
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
                        <label for="dateOfAppointment" class="label">Date of Appointment</label>
                        <input type="date" id="dateOfAppointment" name="dateOfAppointment" 
                            value="{{ old('dateOfAppointment') }}" class="input" required>
                    </div>

                    <div>
                        <label for="designationAtAppointment" class="label">Designation at Appointment</label>
                        <input type="text" id="designationAtAppointment" name="designationAtAppointment" 
                            value="{{ old('designationAtAppointment') }}" class="input" placeholder="QAO (LAB)" required>
                    </div>

                    <div>
                        <label for="designationAtPresent" class="label">Current Designation</label>
                        <input type="text" id="designationAtPresent" name="designationAtPresent" 
                            value="{{ old('designationAtPresent') }}" class="input" placeholder="JT. DIRECTOR (LAB)" required>
                    </div>

                    <div>
                        <label for="presentPosting" class="label">Present Posting</label>
                        <input type="text" id="presentPosting" name="presentPosting" 
                            value="{{ old('presentPosting') }}" class="input" placeholder="MUMBAI" required>
                    </div>

                    <div>
                        <label for="personalFileNo" class="label">Personal File No.</label>
                        <input type="text" id="personalFileNo" name="personalFileNo" 
                            value="{{ old('personalFileNo') }}" class="input" placeholder="206">
                    </div>

                    <div>
                        <label for="officeLandline" class="label">Office Landline</label>
                        <input type="text" id="officeLandline" name="officeLandline" 
                            value="{{ old('officeLandline') }}" class="input" placeholder="02266527524">
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
                            <label for="dateOfBirth" class="label">Date of Birth</label>
                            <input type="date" id="dateOfBirth" name="dateOfBirth" 
                                value="{{ old('dateOfBirth') }}" class="input" required>
                        </div>
                        <div>
                            <label for="dateOfRetirement" class="label">Date of Retirement</label>
                            <input type="date" id="dateOfRetirement" name="dateOfRetirement" 
                                value="{{ old('dateOfRetirement') }}" class="input" required>
                        </div>
                    </div>

                    <div>
                        <label for="homeTown" class="label">Home Town</label>
                        <input type="text" id="homeTown" name="homeTown" value="{{ old('homeTown') }}" 
                            class="input" placeholder="KRISHNA RAJA NAGARA, MYSORE">
                    </div>

                    <div>
                        <label for="residentialAddress" class="label">Residential Address</label>
                        <textarea id="residentialAddress" name="residentialAddress" 
                            class="textarea" placeholder="Complete residential address">{{ old('residentialAddress') }}</textarea>
                    </div>

                    <div>
                        <label for="status" class="label">Status</label>
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
    </form>
</div>

@push('styles')
<style>
.save-icon {
    width: 1rem;
    height: 1rem;
    display: inline-block;
    background-size: cover;
    background-image: url("data:image/svg+xml,...");
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add date validation to ensure retirement date is after birth date
        const dobInput = document.getElementById('dateOfBirth');
        const retirementInput = document.getElementById('dateOfRetirement');
        
        if (dobInput && retirementInput) {
            dobInput.addEventListener('change', function() {
                retirementInput.min = this.value;
            });
        }
    });
</script>
@endpush
@endsection