<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedsRequest extends FormRequest
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
            'libelle' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'quantite_med' => ['required', 'integer', 'min:1'],
            'prix_med' => ['required', 'numeric', 'min:0'],
            'dateexp_med' => ['required', 'date'],
        ];
    }
}
