<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\ReviewModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $carModel = new CarModel();
        $data['cars'] = $carModel->findAll();
        return view('dashboard', $data);
    }

    public function editCar($id){
        $carModel = new CarModel();
        $data['car'] = $carModel->find($id);
        return view('edit_car', $data);
    }

    public function updateCar($id){
        $carModel = new CarModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'brand' => $this->request->getPost('brand'),
            'release_year' => $this->request->getPost('release_year'),
            'engine' => $this->request->getPost('engine'),
            'fuel' => $this->request->getPost('fuel'),
            'transmission' => $this->request->getPost('transmission'),
            'drive' => $this->request->getPost('drive'),
            'doors' => $this->request->getPost('doors'),
            'seats' => $this->request->getPost('seats'),
        ];

        $carModel->update($id, $data);
        return redirect()->to('/dashboard');
    }

    public function deleteCar($id){
        $carModel = new CarModel();
        $carModel->delete($id);
        return redirect()->to('/dashboard');
    }


    // Review Management Functions
    public function editReview($id){
        $model = new ReviewModel();
        $data['review'] = $model->find($id);
        return view('edit_review', $data);
    }

    public function updateReview($id){
        $model = new ReviewModel();
        $data = [
            'review' => $this->request->getPost('review'),
            'rating' => $this->request->getPost('rating')
        ];
        $model->update($id, $data);
        $carId = $model->find($id)['car_id'];
        return redirect()->to('/car/' . $carId);
    }

    public function deleteReview($id){
        $model = new ReviewModel();
        $carId = $model->find($id)['car_id'];
        $model->delete($id);
        return redirect()->to('/car/' . $carId);
    }
}
