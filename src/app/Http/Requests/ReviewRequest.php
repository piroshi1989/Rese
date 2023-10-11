<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'comment' => ['nullable', 'string', 'max:400'],
            'image' => ['mimes:jpeg,png'],
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '星を選択して評価してください',
            'comment.max' => '400文字以下で入力してください',
            'image.mines' => 'ファイル形式を.jpeg,もしくは.pngでアップロードしてください',
        ];
    }
}