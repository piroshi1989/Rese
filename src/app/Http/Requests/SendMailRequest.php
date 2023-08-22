<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMailRequest extends FormRequest
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
            'subject' => ['required', 'string' , 'max:50'],
            'body'  => ['required', 'string' , 'max:10000'],
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => '件名を入力してください',
            'subject.string' => '件名を文字列で入力してください',
            'subject.max' => '件名を50文字以内で入力してください',
            'body.required' => '本文を入力してください',
            'body.string' => '本文を文字列で入力してください',
            'body.max' => '本文を10000文字以内で入力してください',
        ];
    }
}