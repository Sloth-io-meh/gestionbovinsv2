<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Bovin extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'bovins';
    protected $primaryKey = 'id_bov';
    public $incrementing = true;
    public $timestamps = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['race', 'vendu', 'mort', 'poidAct', 'id_etab'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    protected $fillable = [
        'race',
        'dateachat',
        'prixachat',
        'poidachat',
        'lieuachat',
        'datevente',
        'prixavente',
        'poidvente',
        'lieuvente',
        'vendu',
        'mort',
        'datemort',
        'id_etab',
        'id_vend',
        'id_q',
        'poidAct',
    ];

    protected $casts = [
        'dateachat' => 'date',
        'datevente' => 'date',
        'datemort' => 'date',
        'vendu' => 'boolean',
        'mort' => 'boolean',
    ];

    // Relationships
    public function etable()
    {
        return $this->belongsTo(Etable::class, 'id_etab', 'id_etab');
    }

    public function vendeur()
    {
        return $this->belongsTo(Vendeur::class, 'id_vend', 'id_vend');
    }

    public function quarantaine()
    {
        return $this->belongsTo(Quarantaine::class, 'id_q', 'id_q');
    }

    public function nourriture()
    {
        return $this->hasMany(Nourriture::class, 'id_bov', 'id_bov');
    }

    public function medicsconsumed()
    {
        return $this->hasMany(Medicsconsumed::class, 'id_bov', 'id_bov');
    }

    public function visites()
    {
        return $this->hasMany(Visite::class, 'id_bov', 'id_bov');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('vendu', false)->where('mort', false);
    }

    public function scopeSold($query)
    {
        return $query->where('vendu', true);
    }

    public function scopeDead($query)
    {
        return $query->where('mort', true);
    }

    public function scopeInQuarantine($query)
    {
        return $query->whereIn('id_q', function ($subQuery) {
            $subQuery->select('id_q')->from('quarantaines')->where('libelle', 'true');
        });
    }
}
