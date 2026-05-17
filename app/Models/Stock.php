<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stocks';
    protected $primaryKey = 'id_stock';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_stock',
        'libelle_st',
        'description_s',
        'quantite_s',
        'quantiteAct',
        'prix_s',
        'dateachat',
        'dateexp_s',
    ];

    protected $casts = [
        'dateachat' => 'date',
        'dateexp_s' => 'date',
    ];

    // Scopes
    public function scopeLowStock($query)
    {
        return $query->where('quantiteAct', '<', 5);
    }

    public function scopeExpired($query)
    {
        return $query->whereDate('dateexp_s', '<', now());
    }
}
