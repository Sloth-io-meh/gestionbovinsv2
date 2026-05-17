<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

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

    public function messages(): array
    {
        return [
            'description_v.required' => 'La description est requise',
            'datepres.required' => 'La date de la visite est requise',
            'datepres.date' => 'La date doit être au format valide',
            'prix_pres.required' => 'Le prix de la visite est requis',
            'prix_pres.numeric' => 'Le prix doit être un nombre',
            'id_bov.required' => 'L\'animal est requis',
            'id_bov.exists' => 'L\'animal sélectionné n\'existe pas',
            'id_vet.required' => 'Le vétérinaire est requis',
            'id_vet.exists' => 'Le vétérinaire sélectionné n\'existe pas',
        ];
    }
}
