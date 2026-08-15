<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreNavigationMenuItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('manage_settings');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'navigation_menu_id' => 'required|exists:navigation_menus,id',
            'parent_id' => 'nullable|exists:navigation_menu_items,id',
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'target' => 'required|string|in:_self,_blank',
            'order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
