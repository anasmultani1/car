<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\ReviewModel;
use CodeIgniter\Controller;

class CarController extends Controller
{
    /**
     * Show list of cars (local + API if searched)
     */
    public function index()
    {
        $carModel = new CarModel();
        $reviewModel = new ReviewModel();

        $search = $this->request->getGet('search');
        $data['search'] = $search;
        $data['cars'] = [];
        $data['apiCars'] = [];

        if ($search) {
            $data['cars'] = $carModel->like('name', $search)->findAll();
            $data['apiCars'] = $this->fetchCarModels($search) ?? [];
        } else {
            $data['cars'] = $carModel->findAll();
        }

        foreach ($data['cars'] as &$car) {
            $reviews = $reviewModel->where('car_id', $car['id'])->findAll();
            $ratings = array_column($reviews, 'rating');
            $car['average_rating'] = count($ratings) ? array_sum($ratings) / count($ratings) : 0;
        }

        return view('car_list', $data);
    }

    /**
     * Call external API and fetch car model data + image
     */
    private function fetchCarModels($make)
    {
        $make = urlencode(strtolower($make));
        $url = "https://vpic.nhtsa.dot.gov/api/vehicles/GetModelsForMake/{$make}?format=json";

        try {
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            $cars = [];

            foreach ($data['Results'] as $model) {
                $name = $model['Model_Name'];
                $brand = $model['Make_Name'];
                $searchImage = urlencode("{$brand} {$name}");

                $imgXml = file_get_contents("https://www.carimagery.com/api.asmx/GetImageUrl?searchTerm=$searchImage");
                preg_match('/<string.*?>(.*?)<\\/string>/', $imgXml, $matches);
                $image = $matches[1] ?? 'https://cdn-icons-png.flaticon.com/512/743/743007.png';

                $cars[] = [
                    'model_name' => $name,
                    'make_display' => $brand,
                    'model_year' => 'N/A',
                    'poster' => $image,
                    'engine' => 'N/A',
                    'fuel' => 'N/A',
                    'transmission' => 'N/A',
                    'drive' => 'N/A',
                    'doors' => 'N/A',
                    'seats' => 'N/A',
                ];
            }

            return $cars;
        } catch (\Throwable $e) {
            log_message('error', 'API Fetch Failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Save a car (fetched via API) into local DB
     */
    public function saveCarAndRedirect()
    {
        $carModel = new CarModel();
        $data = [
            'name' => $this->request->getPost('model_name'),
            'brand' => $this->request->getPost('make'),
            'release_year' => $this->request->getPost('model_year'),
            'poster' => $this->request->getPost('poster'),
            'engine' => $this->request->getPost('engine'),
            'fuel' => $this->request->getPost('fuel'),
            'transmission' => $this->request->getPost('transmission'),
            'drive' => $this->request->getPost('drive'),
            'doors' => $this->request->getPost('doors'),
            'seats' => $this->request->getPost('seats'),
            'description' => 'Imported from API'
        ];

        $carModel->save($data);
        return redirect()->to('/carlist');
    }

    /**
     * View a car and all reviews for it
     */
    public function view($id)
    {
        $carModel = new CarModel();
        $reviewModel = new ReviewModel();

        $car = $carModel->find($id);
        $reviews = $reviewModel->where('car_id', $id)->findAll();
        $ratings = array_column($reviews, 'rating');
        $car['average_rating'] = count($ratings) ? array_sum($ratings) / count($ratings) : 0;
        $car['reviews'] = $reviews;

        return view('car_detail', ['car' => $car]);
    }

    /**
     * Save user review (1 per user per car)
     */
    public function saveReview()
    {
        $session = session();
        $userId = $session->get('user_id');
        $username = $session->get('username');
        $carId = $this->request->getPost('car_id');

        if (!$userId || !$username) {
            return redirect()->to('/login')->with('error', 'Please login to submit a review.');
        }

        $reviewModel = new ReviewModel();

        // Prevent duplicate reviews
        $existing = $reviewModel
            ->where('user_id', $userId)
            ->where('car_id', $carId)
            ->first();

        if ($existing) {
            return redirect()->to("/car/{$carId}")->with('error', 'You already submitted a review for this car.');
        }

        $data = [
            'car_id'   => $carId,
            'user_id'  => $userId,
            'username' => $username,
            'review'   => $this->request->getPost('review'),
            'rating'   => $this->request->getPost('rating')
        ];

        $reviewModel->save($data);
        return redirect()->to("/car/{$carId}")->with('success', 'Review added!');
    }
}
