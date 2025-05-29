<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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
            'id' => ['sometimes', 'numeric'],
            'name' => ['required', 'string', 'min:10', Rule::unique('customers', 'email')->ignore($this->input('id') ?? $this->id)],
            'address' => ['required', 'string'],
            'post_code' => ['required', 'string', 'min:4', 'max:6'],

            'old_name' => ['sometimes', 'string', 'min:10'],
            'old_address' => ['sometimes', 'string'],
            'old_post_code' => ['sometimes', 'string', 'min:4', 'max:6']
        ];
    }

    public function getOldValues()
    {
        $old = $this->only([
            'old_name',
            'old_address',
            'old_post_code'
        ]);

        return [
            'name' => $old['old_name'] ?? null,
            'address' => $old['old_address'] ?? null,
            'post_code' => $old['old_post_code'] ?? null,
        ];
    }
}
