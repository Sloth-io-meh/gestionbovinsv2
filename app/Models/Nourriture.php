<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nourriture extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nourriture';
    protected $primaryKey = 'id_n';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_n',
        'libelle_n',
        'quantite_n',
        'prix',
        'id_bov',
    ];

    // Relationships
    public function bovin()
    {
        return $this->belongsTo(Bovin::class, 'id_bov', 'id_bov');
    }
}
