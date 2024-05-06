<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class WeatherService
{

    public function getWeather(array $place): float
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather', [
            'query' => [
                'lat' => $place[0],
                'lon' => $place[1],
                'appid' => '48cf5d236cd363ef71aadaac0bf33291',
            ],
        ]);

        $data = $response->toArray();
        $temp = $data['main']['temp'];
        // Process and return weather information
        return $temp;
    }
}
