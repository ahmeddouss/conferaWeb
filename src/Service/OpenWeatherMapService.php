<?php
// src/Service/OpenWeatherMapService.php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class OpenWeatherMapService
{


    public function getCityGeoInfo(string $city): array
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://api.openweathermap.org/geo/1.0/direct', [
            'query' => [
                'q' => $city,
                'limit' => 1,
                'appid' => '48cf5d236cd363ef71aadaac0bf33291',
            ],
        ]);

        $data = $response->toArray();

        foreach ($data as $location) {

                $lat = $location['lat'];
                $lon = $location['lon'];

        }

        // Process and return geographical information
        return [$lat,$lon];
    }
}
