<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicules';
    protected $primaryKey = 'id_veh';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_veh',
        'Matricule',
        'type',
        'id_trans',
    ];

    // Relationships
    public function tansporteur()
    {
        return $this->belongsTo(Tansporteur::class, 'id_trans', 'id_trans');
    }
}
