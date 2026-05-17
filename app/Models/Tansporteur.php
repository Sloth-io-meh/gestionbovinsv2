<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tansporteur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tansporteurs';
    protected $primaryKey = 'id_trans';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'cin_t',
        'nom',
        'prenom',
        'tel',
    ];

    // Relationships
    public function vehicules()
    {
        return $this->hasMany(Vehicule::class, 'id_trans', 'id_trans');
    }
}
