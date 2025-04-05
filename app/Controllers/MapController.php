<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class MapController extends ResourceController
{
    public function showrooms()
    {
        $lat = $this->request->getGet('lat');
        $lon = $this->request->getGet('lon');

        if (!$lat || !$lon) {
            return $this->fail('Latitude and Longitude required.');
        }

        $overpassUrl = "https://overpass-api.de/api/interpreter";
        $query = <<<EOT
[out:json];
(
  node["shop"="car"](around:5000,{$lat},{$lon});
  way["shop"="car"](around:5000,{$lat},{$lon});
  relation["shop"="car"](around:5000,{$lat},{$lon});
);
out center;
EOT;

        try {
            $response = file_get_contents($overpassUrl . '?data=' . urlencode($query));
            if ($response === false) {
                return $this->failServerError("Failed to fetch data from Overpass API.");
            }
            return $this->response->setJSON(json_decode($response));
        } catch (\Throwable $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
