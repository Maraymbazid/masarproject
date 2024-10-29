<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentNotesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'exam' => 'required|string',
            'semester' => 'required|in:Semester 1,Semester 2',
            'class_name' => 'required|string',
            'subject' => 'required|exists:subjects,id' // Checks if the subject exists in the subjects table
        ];
    }

    public function messages()
    {
        return [
            'exam.required' => 'The exam field is required.',
            'semester.required' => 'The semester field is required.',
            'semester.in' => 'The semester must be either "Semester 1" or "Semester 2".',
            'class_name.required' => 'The class name field is required.',
            'subject.exists' => 'The selected subject is invalid.',
        ];
    }
}