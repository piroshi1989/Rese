<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating' => ['required','integer','min:1','max:5'],
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '星をクリックして評価してください',
        ];
    }
}