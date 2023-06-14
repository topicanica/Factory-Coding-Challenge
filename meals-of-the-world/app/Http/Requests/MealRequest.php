<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'tags' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (is_array($value) && count($value) > 0) {
                        foreach ($value as $tag) {
                            if (!is_numeric($tag) || $tag < 1) {
                                $fail("The $attribute must contain at least one numeric value greater than 0.");
                                return;
                            }
                        }
                    } elseif (!is_numeric($value) || $value < 1) {
                        $fail("The $attribute must be a numeric value greater than 0.");
                    }
                },
            ],
            'lang' => 'required|string',
            'with' => 'nullable|string',
            'diff_time' => 'nullable|numeric',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
