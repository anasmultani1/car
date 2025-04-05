<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class LocationController extends ResourceController
{
    public function getNearbyShowrooms()
    {
        $lat = $this->request->getGet('lat');
        $lon = $this->request->getGet('lon');

        $query = <<<EOD
[out:json];
node["shop"="car"](around:10000,{$lat},{$lon});
out;
EOD;

        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query(['data' => $query])
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents('https://overpass-api.de/api/interpreter', false, $context);

        return $this->response
                    ->setHeader('Content-Type', 'application/json')
                    ->setBody($response);
    }
}
