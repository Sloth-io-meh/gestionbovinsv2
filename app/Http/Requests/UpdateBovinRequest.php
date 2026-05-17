<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBovinRequest extends FormRequest
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
            'race' => ['sometimes', 'string', 'max:255'],
            'dateachat' => ['sometimes', 'date'],
            'prixachat' => ['sometimes', 'numeric', 'min:0'],
            'poidachat' => ['sometimes', 'numeric', 'min:0'],
            'lieuachat' => ['sometimes', 'string', 'max:255'],
            'datevente' => ['nullable', 'date'],
            'prixavente' => ['nullable', 'numeric', 'min:0'],
            'poidvente' => ['nullable', 'numeric', 'min:0'],
            'lieuvente' => ['nullable', 'string', 'max:255'],
            'datemort' => ['nullable', 'date'],
            'poidAct' => ['nullable', 'numeric', 'min:0'],
            'id_etab' => ['sometimes', 'exists:etables,id_etab'],
            'id_vend' => ['sometimes', 'exists:vendeurs,id_vend'],
            'id_q' => ['sometimes', 'exists:quarantaines,id_q'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'dateachat.date' => 'La date d\'achat doit être une date valide',
            'datevente.date' => 'La date de vente doit être une date valide',
            'datemort.date' => 'La date de mort doit être une date valide',
            'prixachat.numeric' => 'Le prix d\'achat doit être un nombre',
            'prixavente.numeric' => 'Le prix de vente doit être un nombre',
            'poidachat.numeric' => 'Le poids d\'achat doit être un nombre',
            'poidavente.numeric' => 'Le poids de vente doit être un nombre',
            'poidAct.numeric' => 'Le poids actuel doit être un nombre',
            'id_etab.exists' => 'L\'étable sélectionnée n\'existe pas',
            'id_vend.exists' => 'Le vendeur sélectionné n\'existe pas',
            'id_q.exists' => 'Le statut de quarantaine sélectionné n\'existe pas',
        ];
    }
}
