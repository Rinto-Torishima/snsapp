<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        #↓trueに書き換える
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
            'name'      => 'required|max:15',
            'content'   => 'required|max:255',
        ];
    }
    public function messages()
    {
        return [
            'name.required'     => '名前を入力してください。',
            'name.max'          => '名前は15文字まででお願いします。',
            'content.required'  => 'コメントを入力してください。',
            'content.max'       => 'コメントは255文字まででお願いします。',
        ];
    }
}
