<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Client\RequestException;

class GooglePlacesService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GOOGLE_PLACES_API_KEY');
        if (!$this->apiKey) {
            throw new \Exception('Google Places API key not set in environment variables');
        }
    }

    public function getCitiesTowns($state)
    {
        $url = "https://maps.googleapis.com/maps/api/place/textsearch/json";
        $query = [
            'query' => "cities, villages, towns in $state",
            'key' => $this->apiKey,
        ];
        try {
            $response = $this->client->get($url, ['query' => $query]);
            $results = json_decode($response->getBody(), true);
            //  dd($results);
            if (isset($results['error_message'])) {
                throw new \Exception($results['error_message']);
            }

            $places = $results['results'];

            while (isset($results['next_page_token'])) {
                sleep(2); // Delay to ensure the next page token is valid
                $query['pagetoken'] = $results['next_page_token'];
                $response = $this->client->get($url, ['query' => $query]);
                $results = json_decode($response->getBody(), true);
                // dd($results);
                if (isset($results['error_message'])) {
                    throw new \Exception($results['error_message']);
                }
                $places = array_merge($places, $results['results']);
            }

            return array_map(function ($place) {
                return ['name' => $place['name']];
            }, $places);
        } catch (RequestException $e) {
            
            throw new \Exception("HTTP request failed: " . $e->getMessage());
        } catch (\Exception $e) {
            
            throw new \Exception("Error: " . $e->getMessage());
        }
    }
}
