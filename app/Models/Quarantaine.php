<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quarantaine extends Model
{
    use HasFactory;

    protected $table = 'quarantaines';
    protected $primaryKey = 'id_q';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'libelle',
    ];

    // Relationships
    public function bovins()
    {
        return $this->hasMany(Bovin::class, 'id_q', 'id_q');
    }
}
