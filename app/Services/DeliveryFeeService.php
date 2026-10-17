<?php

namespace App\Services;

class DeliveryFeeService
{
    public function quote(string $address): array
    {
        $normalizedAddress = $this->normalize($address);

        if ($normalizedAddress === '') {
            return [
                'known' => false,
                'barangay' => null,
                'fee' => null,
                'message' => config(
                    'delivery_fees.unknown_message'
                ),
            ];
        }

        $barangays = config('delivery_fees.barangays', []);

        // Check the longest barangay names first.
        uksort($barangays, function ($a, $b) {
            return mb_strlen($b) <=> mb_strlen($a);
        });

        foreach ($barangays as $barangay => $fee) {
            $normalizedBarangay = $this->normalize($barangay);

            $pattern = '/(?<![\p{L}\p{N}])'
                . preg_quote($normalizedBarangay, '/')
                . '(?![\p{L}\p{N}])/u';

            if (preg_match($pattern, $normalizedAddress) === 1) {
                return [
                    'known' => true,
                    'barangay' => $barangay,
                    'fee' => (int) $fee,
                    'message' => null,
                ];
            }
        }

        return [
            'known' => true,
            'barangay' => null,
            'fee' => (int) config('delivery_fees.default_fee', 50),
            'message' => null,
        ];
    }

    private function normalize(string $value): string
    {
        $value = mb_strtolower(trim($value));
        $value = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $value);

        return trim(preg_replace('/\s+/u', ' ', $value));
    }
}
