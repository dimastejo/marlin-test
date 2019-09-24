<?php


namespace App\Services;

use GuzzleHttp\Client;

class OngkirService
{


    /**
     * OngkirService constructor.
     */
    public function __construct()
    {
    }

    public function getProvince()
    {
        $client = new Client(['headers' => ['Content-Type' => 'application/json']]);
        $res = $client->get(
            env('RAJAONGKIR_URL') . '/province',
            [
                'headers' => [
                    'key' => env('RAJAONGKIR_KEY')
                ]
            ]
        );

        return json_decode($res->getBody()->getContents())->rajaongkir->results;
    }

    public function getCity($province_id)
    {
        $client = new Client(['headers' => ['Content-Type' => 'application/json']]);
        $res = $client->get(
            env('RAJAONGKIR_URL') . '/city?province=' . $province_id,
            [
                'headers' => [
                    'key' => env('RAJAONGKIR_KEY')
                ]
            ]
        );

        return json_decode($res->getBody()->getContents())->rajaongkir->results;
    }

    public function getCost($destination, $weight, $courier)
    {
        $origin = 501; // Kota Yogyakarta

        $client = new Client(['headers' => ['Content-Type' => 'application/x-www-form-urlencoded']]);
        $res = $client->post(
            env('RAJAONGKIR_URL') . '/cost',
            [
                'headers' => [
                    'key' => env('RAJAONGKIR_KEY')
                ],
                'form_params' => [
                    'origin' => $origin,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => $courier
                ]
            ]
        );

        return json_decode($res->getBody()->getContents())->rajaongkir->results;
    }
}
