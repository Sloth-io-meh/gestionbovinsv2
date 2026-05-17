<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vetos';
    protected $primaryKey = 'id_vet';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id_vet',
        'nom_vet',
        'prenom_vet',
        'tel_vet',
    ];

    // Relationships
    public function visites()
    {
        return $this->hasMany(Visite::class, 'id_vet', 'id_vet');
    }
}
