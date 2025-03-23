<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\ReviewModel;
use CodeIgniter\Controller;

class CarController extends Controller
{
    public function index()
    {
        $carModel = new CarModel();
        $reviewModel = new ReviewModel();

        $cars = $carModel->findAll();

        foreach ($cars as &$car) {
            $car['reviews'] = $reviewModel->where('car_id', $car['id'])->findAll();
        }

        $data['cars'] = $cars;

        return view('car_list', $data);
    }

    public function create()
    {
        return view('add_car');
    }

    public function save()
    {
        $model = new CarModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'brand' => $this->request->getPost('brand'),
            'description' => $this->request->getPost('description'),
            'release_year' => $this->request->getPost('release_year'),
            'poster' => $this->request->getPost('poster')
        ];

        $model->save($data);

        return redirect()->to('/carlist');
    }
}
