<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Meds extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'meds';
    protected $primaryKey = 'id_med';
    public $incrementing = false;
    public $timestamps = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['quantite_med', 'prix_med'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    protected $fillable = [
        'id_med',
        'libelle',
        'description',
        'quantite_med',
        'prix_med',
        'dateachat',
        'dateexp_med',
    ];

    protected $casts = [
        'dateachat' => 'date',
        'dateexp_med' => 'date',
    ];

    // Relationships
    public function medicsconsumed()
    {
        return $this->hasMany(Medicsconsumed::class, 'id_med', 'id_med');
    }

    // Scopes
    public function scopeLowStock($query)
    {
        return $query->where('quantite_med', '<', 5);
    }

    public function scopeExpired($query)
    {
        return $query->whereDate('dateexp_med', '<', now());
    }
}
