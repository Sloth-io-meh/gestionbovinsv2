<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Visite extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'visites';
    protected $primaryKey = 'id_pres';
    public $incrementing = false;
    public $timestamps = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    protected $fillable = [
        'id_pres',
        'description_v',
        'datepres',
        'prix_pres',
        'id_bov',
        'id_vet',
    ];

    protected $casts = [
        'datepres' => 'date',
    ];

    // Relationships
    public function bovin()
    {
        return $this->belongsTo(Bovin::class, 'id_bov', 'id_bov');
    }

    public function veto()
    {
        return $this->belongsTo(Veto::class, 'id_vet', 'id_vet');
    }
}
