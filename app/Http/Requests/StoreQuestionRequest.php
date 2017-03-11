<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
     * Valigate messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'body.required' => "内容 不能为空。",
            'body.min'      => "内容 不能少于40个字符。",
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:1|max:150',
            'body'  => 'required|min:40'
        ];
    }
}
