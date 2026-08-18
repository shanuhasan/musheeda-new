<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled in controller/policies
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'file' => [
                    'required',
                    'file',
                    'max:10240', // 10MB max
                    'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx'
                ],
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'name' => 'required|string|max:255',
                'custom_properties.alt' => 'nullable|string|max:255',
                'custom_properties.caption' => 'nullable|string|max:500',
                'custom_properties.description' => 'nullable|string|max:1000',
            ];
        }

        return [];
    }
}
