<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class ReservationRequest extends FormRequest
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
        $today = Carbon::today();

        $rules = [
            'date' => 'required',
            'time' => 'required',
            // 他のフォームフィールドのバリデーションルールをここに追加
        ];

        if ($this->input('date') === $today->format('Y-m-d')) {
            $rules['time'] .= '|after_or_equal:' . Carbon::now()->format('H:i');
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください',
            'time.after_or_equal' => '予約可能時間が過ぎています。',
        ];
    }
}