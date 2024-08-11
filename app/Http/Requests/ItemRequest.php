<?php

namespace App\Http\Requests;

use App\Rules\IsItemsCategory;
use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'price'  => 'required|numeric' ,
            'discountPercent'  => 'numeric|min:0|max:100|nullable',
            'categoryId'  => ['required' , new IsItemsCategory()]
        ];
    }
}
