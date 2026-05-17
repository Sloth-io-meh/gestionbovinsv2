<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBovinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'race' => ['required', 'string', 'max:255'],
            'dateachat' => ['required', 'date'],
            'prixachat' => ['required', 'numeric', 'min:0'],
            'poidachat' => ['required', 'numeric', 'min:0'],
            'lieuachat' => ['required', 'string', 'max:255'],
            'id_etab' => ['required', 'exists:etables,id_etab'],
            'id_vend' => ['required', 'exists:vendeurs,id_vend'],
            'id_q' => ['required', 'exists:quarantaines,id_q'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'race.required' => 'La race est requise',
            'dateachat.required' => 'La date d\'achat est requise',
            'dateachat.date' => 'La date d\'achat doit être une date valide',
            'prixachat.required' => 'Le prix d\'achat est requis',
            'prixachat.numeric' => 'Le prix d\'achat doit être un nombre',
            'poidachat.required' => 'Le poids d\'achat est requis',
            'poidachat.numeric' => 'Le poids d\'achat doit être un nombre',
            'id_etab.exists' => 'L\'étable sélectionnée n\'existe pas',
            'id_vend.exists' => 'Le vendeur sélectionné n\'existe pas',
            'id_q.exists' => 'Le statut de quarantaine sélectionné n\'existe pas',
        ];
    }
}
