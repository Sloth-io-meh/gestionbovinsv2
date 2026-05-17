<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendeur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendeurs';
    protected $primaryKey = 'id_vend';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nom_vend',
        'prenom_vend',
        'tel_vend',
        'farm_vend',
        'id_bov',
    ];

    // Relationships
    public function bovins()
    {
        return $this->hasMany(Bovin::class, 'id_vend', 'id_vend');
    }
}
