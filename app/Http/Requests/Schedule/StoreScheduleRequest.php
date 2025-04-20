<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
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
            'title' => 'required|max:255',
            'description' => 'nullable|max:255',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'color' => 'nullable|regex:/^#([A-Fa-f0-9]{6})$',
            'parentId' => 'nullable|integer',
            'pmId' => 'nullable|integer',
            'statusId' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'title' => [
              'required' => '일정 제목은 필수값입니다.',
            ],

            'startDate' => [
                'date' => '2000-01-01 형식만 가능합니다.'
            ],

            'endDate' => [
                'date' => '2000-01-01 형식만 가능합니다.'
            ],
        ];
    }
}
