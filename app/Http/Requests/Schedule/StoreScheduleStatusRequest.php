<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'statusName' => 'required|string',
            'statusBackground' => 'nullable|regex:/^#([A-Fa-f0-9]{6})$',
            'statusTextColor' => 'nullable|regex:/^#([A-Fa-f0-9]{6})$/',
        ];
    }

    public function messages(): array
    {
        return [
            'statusName' => [
                'required' => '상태명은 필수값입니다.',
            ]
        ];
    }
}
