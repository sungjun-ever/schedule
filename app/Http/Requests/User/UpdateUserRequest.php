<?php

namespace App\Http\Requests\User;

use App\Enum\User\UserLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

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
            'password' =>'nullable|string|min:6',
            'passwordConfirmation' => 'nullable|string|min:6|same:password',
            'level' => ['required', Rule::enum(UserLevel::class)],
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
                'min' => '비밀번호는 최소 8자리입니다.',
            ],

            'passwordConfirmation' => [
                'min' => '비밀번호는 최소 8자리입니다.',
                'same' => '비밀번호와 일치하지 않습니다.'
            ],

            'level' => [
                'enum' => '올바른 사용자 레벨을 선택해주세요.'
            ],

            'teamId' => [
                'numeric' => '존재하지 않는 팀입니다.' ,
                'exists' => '존재하지 않는 팀입니다.'
            ],
        ];
    }
}
