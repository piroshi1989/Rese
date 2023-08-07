<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'name' => ['required', 'string' , 'max:255'],
            'genre_id' => ['required'],
            'area_id' => ['required'],
            'detail' => ['required', 'string', 'max:10000'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名を入力してください',
            'name.string' => '店舗名を文字列で入力してください',
            'name.max' => '店舗名を255文字以下で入力してください',
            'genre_id.required' => 'ジャンル名を選択してください',
            'area_id.required' => '地域を選択してください',
            'detail.required' => '詳細を入力してください',
            'detail.string' => '詳細を文字列で入力してください',
            'detail.max' => '詳細を10000文字以内で入力してください',
        ];
    }
}