<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatchRequest extends FormRequest
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
            '*.name' => 'required|string',
            '*.governmentId' => 'required|string',
            '*.email' => 'required|email',
            '*.debtAmount' => 'required|numeric',
            '*.debtDueDate' => 'required|date',
            '*.debtId' => 'required|string',
        ];
    }
}
