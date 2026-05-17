<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVisiteRequest extends FormRequest
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
            'description_v' => ['required', 'string', 'max:1000'],
            'datepres' => ['required', 'date'],
            'prix_pres' => ['required', 'numeric', 'min:0'],
            'id_bov' => ['required', 'exists:bovins,id_bov'],
            'id_vet' => ['required', 'exists:vetos,id_vet'],
        ];
    }
}
