<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeocodingService
{
    public function geocode(string $address): ?array
    {
        $key = config('services.google_maps.key');

        $res = Http::get('https://maps.googleapis.com/maps/api/geocode/json',[
            'address' => $address,
            'key'     => $key,
        ]);

        if (!$res->ok()) {
            return null;
        }

        $data = $res->json();
        if (($data['status'] ?? '') !== 'OK') return null;

        $loc = $data['results'][0]['geometry']['location'] ?? null;
        if(!$loc) return null;

        return ['lat' => $loc['lat'], 'log' => $loc['log']];
    }
}
