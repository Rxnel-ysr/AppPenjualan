<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'id' => ['nullable'],
            'name' => ['required', 'string', 'max:255'],
            'picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'qty' => ['nullable', 'numeric', 'min:1'],
            'price' => ['required', 'numeric', 'min:1'],
            'category_id' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Item needed a name',
            'name.string' => 'Item\'s name must be string',
            'picture.max' => 'Image size must less than 2mb',
            'qty.min' => 'Stock/Qty must at least 1',
            'price.min' => 'Price must at least 1$',
            'category.required' => 'Category is required',
        ];
    }
}
