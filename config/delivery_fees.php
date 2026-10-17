
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Delivery Fee
    |--------------------------------------------------------------------------
    */

    'default_fee' => 50,

    /*
    |--------------------------------------------------------------------------
    | Barangay Delivery Fees
    |--------------------------------------------------------------------------
    |
    | 30  = Near areas
    | 50  = Medium-distance areas
    | 100 = Far areas
    |
    | Pickup is handled separately by the cart and checkout logic.
    |
    */

    'barangays' => [

        /*
        |--------------------------------------------------------------------------
        | Near Areas — ₱30
        |--------------------------------------------------------------------------
        */

        'Bito' => 30,
        'Loyonsawang' => 30,
        'Victory' => 30,

        /*
        |--------------------------------------------------------------------------
        | Medium Areas — ₱50
        |--------------------------------------------------------------------------
        */

        // Buntay and nearby delivery areas
        'Buntay' => 50,
        'Can-uguib' => 50,
        'Alangilan' => 50,
        'Balocawe' => 50,
        'Balocawehay' => 50,
        'Barayong' => 50,

        // Central and nearby areas
        'Buenavista' => 50,
       
        'Bunga' => 50,
        'Can-aporong' => 50,
        'Canmarating' => 50,
        'Capilian' => 50,
        'Cadac-an' => 50,
        'Guintagbucan' => 50,
        'Nalibunan' => 50,
        'Santa Fe' => 50,
        'Santo Niño' => 50,

        // Other medium-fee areas
        'Buaya' => 70,
        'Katipunan' => 70,
        'Kikilo' => 70,
        'Laray' => 70,
        'Lawa-an' => 70,
        'Mag-atubang' => 70,
        'Mahayahay' => 70,
        'Maitum' => 70,
        'Odiongan' => 70,
        'Pagsang-an' => 70,
        'Tib-o' => 70,
        'Tinalian' => 70,
        'Tinocolan' => 70,
        'Santa Lucia' => 70,
        'Bulak' => 70,


        /*
        |--------------------------------------------------------------------------
        | Far Areas — ₱100
        |--------------------------------------------------------------------------
        */

        // Tabigue-to-New Taligue route group
        'Tabigue' => 100,
        'Tadoc' => 100,
        'Old Taligue' => 100,
        'New Taligue' => 100,

        // Nearby entries grouped with the far-fee areas
        'Paguite' => 100,
        'Parasanon' => 100,
        'Picas Sur' => 100,
        'Pilar' => 100,
        'Pinamanagan' => 100,
        'Salvacion' => 100,
        'San Francisco' => 100,
        'San Isidro' => 100,
        'San Roque' => 100,
        'Malaguicay' => 100,

        // Other far-fee areas
        'Hampipila' => 100,
        'Nebga' => 100,
        'Anibongon' => 100,
        'Burubud-an' => 100,
        'Cagbolo' => 100,
        'Bagacay' => 100,
        'Bahay' => 100,
        'Balinsasayao' => 100,
        'Matagnao' => 100,
        'Combis' => 100,
        'Dingle' => 100,
        'Libertad' => 100,
        'Mahagna' => 100,
        'Bayabas' => 100,
        'Tuy-a' => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | Unknown Address Message
    |--------------------------------------------------------------------------
    */

    'unknown_message' => 'Enter your complete delivery address.',
];
