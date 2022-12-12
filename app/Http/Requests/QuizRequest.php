<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuizRequest extends FormRequest
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
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(function($query){
                    $query->where('role', 'user');
                })
            ],
            'batch_date' => 'required|date_format:Y-m-d',
            'duration' => 'required|numeric|min:15',
            'subject' => 'required',
            'desc' => 'required',
        ];
    }
}
