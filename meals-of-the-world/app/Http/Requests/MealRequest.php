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
            'per_page' => 'sometimes|numeric|min:1',
            'page' => 'sometimes|numeric|min:1',
            'category' => ['sometimes', new \App\Rules\ValidCategoryRule],
            'tags' => ['sometimes','string', new \App\Rules\ValidTagsRule],
            'lang' => ['required','string', new \App\Rules\ValidLangRule],
            'with' => ['sometimes','string', new \App\Rules\ValidWithRule],
            'diff_time' => 'sometimes|numeric',
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
