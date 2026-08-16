<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('manage_pages');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable', // Can be a file upload OR an integer ID
            'existing_media_id' => 'nullable|integer|exists:media,id',
            
            // SEO Fields
            'seo' => 'nullable|array',
        ];
    }
}
