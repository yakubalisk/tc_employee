@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Doctor Record</h1>
                    <p class="text-gray-600">Update doctor record details</p>
                </div>
                <a href="{{ route('doctor.index') }}" 
                   class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-600 text-white hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>

            <!-- Form -->
            <div class="card border rounded-xl">
                <div class="card-content p-6">
                    <form action="{{ route('doctor.update', $doctor->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                                
                                <div>
                                    <label for="empID" class="block text-sm font-medium text-gray-700 mb-1">Employee ID *</label>
                                    <input type="text" name="empID" id="empID" value="{{ old('empID', $doctor->empID) }}" 
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Enter employee ID" required>
                                    @error('empID') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="name_of_doctor" class="block text-sm font-medium text-gray-700 mb-1">Name of Doctor</label>
                                    <input type="text" name="name_of_doctor" id="name_of_doctor" value="{{ old('name_of_doctor', $doctor->name_of_doctor) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Enter doctor's full name">
                                    @error('name_of_doctor') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="registration_no" class="block text-sm font-medium text-gray-700 mb-1">Registration Number</label>
                                    <input type="text" name="registration_no" id="registration_no" value="{{ old('registration_no', $doctor->registration_no) }}"
                                           class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., 9812, G-7543, DMC-49529">
                                    @error('registration_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Qualification & Address -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Qualification & Address</h3>
                                
                                <div>
                                    <label for="qualification" class="block text-sm font-medium text-gray-700 mb-1">Qualification</label>
                                    <select name="qualification" id="qualification" 
                                            class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Qualification</option>
                                        @foreach(App\Models\Doctor::QUALIFICATIONS as $key => $value)
                                            <option value="{{ $key }}" {{ old('qualification', $doctor->qualification) == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('qualification') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <textarea name="address" id="address" rows="4"
                                              class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                              placeholder="Enter complete address of the doctor">{{ old('address', $doctor->address) }}</textarea>
                                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>

                        <!-- AMA Remarks -->
                        <div class="mt-6">
                            <label for="ama_remarks" class="block text-sm font-medium text-gray-700 mb-1">AMA Remarks</label>
                            <textarea name="ama_remarks" id="ama_remarks" rows="3"
                                      class="py-2 px-3 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Any AMA related remarks">{{ old('ama_remarks', $doctor->ama_remarks) }}</textarea>
                            @error('ama_remarks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('doctor.index') }}" 
                               class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                                <i class="fas fa-save mr-2"></i>
                                Update Doctor Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection