<?php

namespace App\Http\Requests;

use App\Models\Lookup;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'role' => [
                'required',
                Rule::exists('lookups', 'value')->where(function($query){
                    return $query->where([
                        'category' => Lookup::ROLES,
                    ]);
                })
            ],
        ];
        if ($this->getMethod() == 'POST') {
            $rules += [
                'password' => 'required|alpha_num|min:6',
                'email' => 'required|email|unique:users,email',
                'repassword' => 'required|same:password',
            ];
        }elseif ($this->getMethod() == 'PUT') {
            $rules += [
                'password' => 'present|alpha_num|min:6',
                'repassword' => 'present|same:password',
                'email' => [
                    'required','email',
                    Rule::unique('users', 'email')->ignore($this->user)
                ],
            ];
        }
        return $rules;
    }
}
