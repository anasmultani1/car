<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\ReviewModel;
use CodeIgniter\Controller;

class CarController extends Controller
{
    public function index()
    {
        $model = new CarModel();
        $reviewModel = new ReviewModel();

        $search = $this->request->getGet('search');
        $data['cars'] = [];
        $data['apiCars'] = [];
        $data['search'] = $search;

        try {
            if ($search) {
                $localCars = $model->like('name', $search)->findAll();
                $data['cars'] = $localCars;

                $apiCars = $this->fetchCarModels($search);
                $data['apiCars'] = $apiCars ?: [];
            } else {
                $data['cars'] = $model->findAll();
            }

            foreach ($data['cars'] as &$car) {
                $car['reviews'] = $reviewModel->where('car_id', $car['id'])->findAll();
                $ratings = array_column($car['reviews'], 'rating');
                $car['average_rating'] = count($ratings) ? array_sum($ratings) / count($ratings) : 0;
            }

            return view('car_list', $data);
        } catch (\Exception $e) {
            log_message('error', 'CarController::index error - ' . $e->getMessage());
            return view('errors/html/error_500');
        }
    }

    public function fetchCarModels($make)
    {
        $makeEncoded = urlencode(strtolower($make));
        $url = "https://www.carqueryapi.com/api/0.3/?cmd=getModels&make={$makeEncoded}&sold_in_us=1";

        try {
            $response = file_get_contents($url);
            if (!$response) throw new \Exception("CarQuery API failed.");

            if (str_starts_with($response, 'var models = ')) {
                $response = str_replace('var models = ', '', $response);
                $response = trim($response, ';');
            }

            $data = json_decode($response, true);

            $cars = [];
            if (!empty($data['Models'])) {
                foreach ($data['Models'] as $car) {
                    $modelName = $car['model_name'] ?? 'Unknown';
                    $year = $car['model_year'] ?? 'Unknown';

                    $image = $this->fetchCarImage($makeEncoded . ' ' . $modelName);

                    $cars[] = [
                        'model_name'   => $modelName,
                        'model_year'   => $year,
                        'make_display' => ucfirst($make),
                        'image'        => $image,
                    ];
                }
            }

            return $cars;
        } catch (\Exception $e) {
            log_message('error', 'fetchCarModels Error: ' . $e->getMessage());
            return null;
        }
    }

    public function fetchCarImage($query)
    {
        try {
            $url = "http://www.carimagery.com/api.asmx/GetImageUrl?searchTerm=" . urlencode($query);
            $xml = file_get_contents($url);
            preg_match('/<string.*?>(.*?)<\/string>/', $xml, $matches);

            $imageUrl = $matches[1] ?? null;

            if ($imageUrl && filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                return $imageUrl;
            }
        } catch (\Exception $e) {
            log_message('error', 'Car image fetch error: ' . $e->getMessage());
        }

        return base_url('assets/images/default-car.jpg');
    }

    public function view($id)
    {
        $carModel = new CarModel();
        $reviewModel = new ReviewModel();

        $car = $carModel->find($id);
        if (!$car) return redirect()->to('/carlist');

        $car['reviews'] = $reviewModel->where('car_id', $id)->findAll();
        $ratings = array_column($car['reviews'], 'rating');
        $car['average_rating'] = count($ratings) ? array_sum($ratings) / count($ratings) : 0;

        return view('car_detail', ['car' => $car]);
    }

    public function saveCarAndRedirect()
    {
        $carModel = new CarModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'brand' => $this->request->getPost('brand'),
            'release_year' => $this->request->getPost('release_year'),
            'poster' => $this->request->getPost('poster'),
            'description' => $this->request->getPost('description'),
        ];

        $carModel->save($data);

        return $this->response->setJSON(['redirect' => base_url('/carlist')]);
    }
}
