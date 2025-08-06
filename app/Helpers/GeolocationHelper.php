<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class GeolocationHelper
{
    public static function getGeolocationData($latitude, $longitude)
    {
        $location = 'Location Not Provided';
        $country = 'Country Not Provided';

        if ($latitude && $longitude) {
            $apiKey = env('GOOGLE_MAPS_API_KEY');
            try {
                $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
                    'latlng' => "$latitude,$longitude",
                    'key' => $apiKey,
                ]);

                if ($response->successful()) {
                    $geoData = $response->json();
                    $location = $geoData['results'][0]['formatted_address'] ?? 'Unknown City';

                    foreach ($geoData['results'][0]['address_components'] ?? [] as $component) {
                        if (in_array('country', $component['types'])) {
                            $country = $component['long_name'];
                            break;
                        }
                    }
                } else {
                    $location = 'Unable to Fetch Location';
                    $country = 'Unable to Fetch Country';
                }
            } catch (\Exception $e) {
                $location = 'Geolocation Error';
                $country = 'Geolocation Error';
            }
        }

        return ['location' => $location, 'country' => $country];
    }
}
