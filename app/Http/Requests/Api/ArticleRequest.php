<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize()
    {
        switch ($this->method()) {
            case 'GET':
            case 'POST':
                {

                    return [
                        'name' => ['required', 'max:25'],
                        'topics_id' => ['required'],
                        'name_id' => ['required'],
                    ];
                }
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            default:
                {
                    return [

                    ];
                }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name.required' => '标题不能为空',
            'topics_id.required' => '请选择所属板块',
            'name_id.required' => '未登录',
            'name.max' => '标题最大长度为25个字符',
        ];
    }
}
