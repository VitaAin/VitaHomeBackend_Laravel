<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Created by PhpStorm.
 * User: Vita
 * Date: 2017/11/27
 * Time: 10:36
 */
class StoreArticleRequest extends FormRequest
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
            'title' => 'required|between:4,100',
            'body' => 'required|min:10',
            'tag' => 'required',
            'is_public' => 'required',
            'category' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'title.between' => '标题不能少于4个字符',
            'body.required' => '内容不能为空',
            'body.min' => '内容不能少于10个字符',
            'tag.required' => '文章标签不能为空',
            'category.required' => '文章类别不能为空',
            'is_public.required' => '是否允许评论不能为空',
        ];
    }
}