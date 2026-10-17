<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class DeliveryDistanceService
{
    private const ORIGIN =
        "Andrea's Pizza, Avenida Rizal Street, Bito, Abuyog, Leyte, Philippines";

    private const USER_AGENT =
        'AbuyogAndreaPizza/1.0 (local delivery distance calculator)';

    public function calculate(string $address): array
    {
        $address = trim($address);

        if ($address === '') {
            throw new RuntimeException(
                'Please enter your complete delivery address.'
            );
        }

        $origin = Cache::remember(
            'andrea_pizza_delivery_origin_coordinates',
            now()->addDays(30),
            fn () => $this->geocode(self::ORIGIN)
        );

        $destination = $this->geocode($address);

        $response = Http::timeout(20)
            ->withHeaders([
                'User-Agent' => self::USER_AGENT,
            ])
            ->get(
                'https://router.project-osrm.org/route/v1/driving/'
                . $origin['longitude'] . ',' . $origin['latitude']
                . ';'
                . $destination['longitude'] . ',' . $destination['latitude'],
                [
                    'overview' => 'false',
                    'alternatives' => 'false',
                    'steps' => 'false',
                ]
            );

        if (
            !$response->successful()
            || $response->json('code') !== 'Ok'
        ) {
            throw new RuntimeException(
                'Unable to calculate the driving route right now. Please try again.'
            );
        }

        $meters = $response->json('routes.0.distance');

        if (!is_numeric($meters)) {
            throw new RuntimeException(
                'The driving distance could not be determined for this address.'
            );
        }

        $distanceKm = round(((float) $meters) / 1000, 2);

        if ($distanceKm > 10) {
            throw new RuntimeException(
                'This address is more than 10 km away. Delivery is not available for this address.'
            );
        }

        if ($distanceKm <= 3) {
            $fee = 30;
        } elseif ($distanceKm <= 5) {
            $fee = 50;
        } elseif ($distanceKm <= 8) {
            $fee = 70;
        } else {
            $fee = 100;
        }

        return [
            'distance_km' => $distanceKm,
            'delivery_fee' => $fee,
        ];
    }

    private function geocode(string $address): array
    {
        $normalizedAddress = preg_replace('/\s+/', ' ', trim($address));

        $cacheKey = 'delivery_geocode_' . sha1(
            mb_strtolower($normalizedAddress)
        );

        return Cache::remember(
            $cacheKey,
            now()->addDays(7),
            function () use ($normalizedAddress) {
                $queries = [
                    $normalizedAddress,
                    $normalizedAddress . ', Abuyog, Leyte, Philippines',
                    'Barangay ' . $normalizedAddress . ', Abuyog, Leyte, Philippines',
                ];

                $lastRequestFailed = false;

                foreach (array_unique($queries) as $index => $query) {
                    // Respect the public Nominatim service's usage limit.
                    if ($index > 0) {
                        usleep(1100000);
                    }

                    try {
                        $response = Http::timeout(15)
                            ->withHeaders([
                                'User-Agent' => self::USER_AGENT,
                            ])
                            ->get(
                                'https://nominatim.openstreetmap.org/search',
                                [
                                    'q' => $query,
                                    'format' => 'jsonv2',
                                    'limit' => 5,
                                    'countrycodes' => 'ph',
                                    'viewbox' => '124.70,11.05,125.15,10.55',
                                ]
                            );

                        if (!$response->successful()) {
                            $lastRequestFailed = true;
                            continue;
                        }

                        $results = $response->json();

                        if (!is_array($results)) {
                            continue;
                        }

                        foreach ($results as $result) {
                            if (
                                !is_array($result)
                                || !isset($result['lat'], $result['lon'])
                            ) {
                                continue;
                            }

                            $latitude = (float) $result['lat'];
                            $longitude = (float) $result['lon'];

                            // Broad geographic check around Abuyog.
                            if (
                                $latitude < 10.55
                                || $latitude > 11.05
                                || $longitude < 124.70
                                || $longitude > 125.15
                            ) {
                                continue;
                            }

                            return [
                                'latitude' => $latitude,
                                'longitude' => $longitude,
                            ];
                        }
                    } catch (\Throwable $e) {
                        $lastRequestFailed = true;
                    }
                }

                if ($lastRequestFailed) {
                    throw new RuntimeException(
                        'The map service is temporarily unavailable. Please wait and try again.'
                    );
                }

                throw new RuntimeException(
                    'We could not find this address near Abuyog, Leyte. Enter a recognized barangay or a more complete address and try again.'
                );
            }
        );
    }
}
