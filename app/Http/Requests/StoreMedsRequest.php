<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'libelle' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'quantite_med' => ['required', 'integer', 'min:1'],
            'prix_med' => ['required', 'numeric', 'min:0'],
            'dateachat' => ['required', 'date'],
            'dateexp_med' => ['required', 'date', 'after:dateachat'],
        ];
    }

    public function messages(): array
    {
        return [
            'libelle.required' => 'Le libellé du médicament est requis',
            'description.required' => 'La description est requise',
            'quantite_med.required' => 'La quantité est requise',
            'quantite_med.integer' => 'La quantité doit être un nombre entier',
            'prix_med.required' => 'Le prix est requis',
            'prix_med.numeric' => 'Le prix doit être un nombre',
            'dateachat.required' => 'La date d\'achat est requise',
            'dateexp_med.required' => 'La date d\'expiration est requise',
            'dateexp_med.after' => 'La date d\'expiration doit être après la date d\'achat',
        ];
    }
}
