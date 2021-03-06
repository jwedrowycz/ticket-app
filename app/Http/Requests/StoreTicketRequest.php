<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
        $rules = [ 
            'title' => 'required',
            'descr' => 'required',
            'priority_id' => 'required',
            'category_id' => 'exists:categories',
            'files.*' => 'nullable|mimes:jpg,png,jpeg|max:2000'
        ];

        return $rules;
    }
}
