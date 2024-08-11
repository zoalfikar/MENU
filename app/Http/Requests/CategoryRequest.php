<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\IsParentCategory;

class CategoryRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'discountPercent'  => 'numeric|min:0|max:100|nullable',
            'type' => 'required|in:parentCa,itemsCa',
            'parentId'  => ['numeric',new IsParentCategory() ,'nullable']
        ];
    }
}
