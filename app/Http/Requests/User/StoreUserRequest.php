<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
//    public function authorize(): bool
//    {
//        return true;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'passwordConfirmation' => 'required|string|min:8',
            'teamId' => 'nullable|numeric|exists:teams,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name' => [
                'required' => '이름은 필수값입니다.',
                'max' => '이름은 최대 50자까지 가능합니다.'
            ],

            'email' => [
                'required' => '이메일은 필수값입니다.',
                'email' => '이메일 형식이 맞는지 확인해주세요.',
                'unique' => '이미 존재하는 이메일입니다.'
            ],

            'password' => [
                'required' => '비밀번호는 필수값입니다.',
                'min' => '비밀번호는 최소 8자리입니다.',
                'confirmed' => '비밀번호 확인과 일치하지 않습니다.',
            ],

            'passwordConfirmation' => [
                'required' => '비밀번호 확인은 필수값입니다.',
                'min' => '비밀번호는 최소 8자리입니다.',
            ],

            'teamId' => [
                'numeric' => '존재하지 않는 팀입니다.' ,
                'exists' => '존재하지 않는 팀입니다.'
            ],
        ];
    }
}
