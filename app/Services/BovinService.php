<?php

namespace App\Services;

use App\Models\Bovin;

class BovinService
{
    public function markSold(Bovin $bovin, array $data): void
    {
        $bovin->update([
            'prixavente' => $data['prixavente'],
            'poidvente'  => $data['poidvente'],
            'lieuvente'  => $data['lieuvente'],
            'datevente'  => $data['datevente'],
            'vendu'      => true,
        ]);
    }

    public function markDead(Bovin $bovin, string $datemort): void
    {
        $bovin->update([
            'datemort' => $datemort,
            'mort'     => true,
        ]);
    }

    public function updateWeight(Bovin $bovin, float $weight): void
    {
        $bovin->update(['poidAct' => $weight]);
    }
}
