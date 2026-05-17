<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'libelle_st' => ['required', 'string', 'max:255'],
            'description_s' => ['required', 'string', 'max:1000'],
            'quantite_s' => ['required', 'integer', 'min:1'],
            'quantiteAct' => ['nullable', 'integer', 'min:0'],
            'prix_s' => ['required', 'numeric', 'min:0'],
            'dateachat' => ['required', 'date'],
            'dateexp_s' => ['required', 'date', 'after:dateachat'],
        ];
    }

    public function messages(): array
    {
        return [
            'libelle_st.required' => 'Le libellé est requis',
            'description_s.required' => 'La description est requise',
            'quantite_s.required' => 'La quantité est requise',
            'quantite_s.integer' => 'La quantité doit être un nombre entier',
            'prix_s.required' => 'Le prix est requis',
            'prix_s.numeric' => 'Le prix doit être un nombre',
            'dateachat.required' => 'La date d\'achat est requise',
            'dateexp_s.required' => 'La date d\'expiration est requise',
            'dateexp_s.after' => 'La date d\'expiration doit être après la date d\'achat',
        ];
    }
}
