<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quarantaine extends Model
{
    use HasFactory;

    protected $table = 'quarantaines';
    protected $primaryKey = 'id_q';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_q',
        'libelle',
    ];

    // Relationships
    public function bovins()
    {
        return $this->hasMany(Bovin::class, 'id_q', 'id_q');
    }
}
