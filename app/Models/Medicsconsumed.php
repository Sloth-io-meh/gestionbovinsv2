<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicsconsumed extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'medicsconsumed';
    protected $primaryKey = 'id_m';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_m',
        'libelle_m',
        'quantite_m',
        'id_bov',
    ];

    // Relationships
    public function bovin()
    {
        return $this->belongsTo(Bovin::class, 'id_bov', 'id_bov');
    }
}
