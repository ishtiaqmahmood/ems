<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_id' => 'required|exists:organizations,id',
            'department_id' => 'nullable|exists:departments,id',
            'section_id' => 'nullable|exists:sections,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employers,email',
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
            'documents.*' => 'nullable|file|max:5120',
            'joining_date' => 'nullable|date',
            'resign_date' => 'nullable|date|after_or_equal:joining_date',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_relation' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,terminated,resigned',
        ];
    }
}
