<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'comment_name'      => 'required|max:15',
            'comment_message'   => 'required|max:255',
        ];
    }
    public function messages()
    {
        return [
            'comment_name.required'     => '名前を入力してください',
            'comment_name.max'          => '名前は15文字まででお願いします。',
            'comment_message.required'  => 'コメントを入力してください',
            'comment_message.max'       => 'コメントは255文字まででお願いします。',
        ];
    }
}
