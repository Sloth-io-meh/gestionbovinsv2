<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'libelle_st'  => ['sometimes', 'string', 'max:255'],
            'description_s' => ['sometimes', 'string', 'max:1000'],
            'quantite_s'  => ['sometimes', 'integer', 'min:1'],
            'quantiteAct' => ['sometimes', 'integer', 'min:0'],
            'prix_s'      => ['sometimes', 'numeric', 'min:0'],
            'dateexp_s'   => ['sometimes', 'nullable', 'date'],
        ];
    }
}
