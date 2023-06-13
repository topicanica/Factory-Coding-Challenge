<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class MealRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'per_page' => 'nullable|numeric|min:1',
            'page' => 'nullable|numeric|min:1',
            'category' => 'nullable|numeric|min:1',
            'tags' => 'nullable|numeric|min:1',
            'tag.*' => 'numeric|min:1',
            'lang' => 'required|string',
            'with' => 'nullable|string',
            'diff_time' => 'nullable|numeric',
        ];
    }
}
