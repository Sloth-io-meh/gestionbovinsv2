<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'etables';
    protected $primaryKey = 'id_etab';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_etab',
        'nom',
    ];

    // Relationships
    public function bovins()
    {
        return $this->hasMany(Bovin::class, 'id_etab', 'id_etab');
    }
}
