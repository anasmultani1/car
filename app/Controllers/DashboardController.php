<?php

namespace App\Controllers;

use App\Models\ReviewModel;
use App\Models\CarModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $reviewModel = new ReviewModel();
        $userId = session()->get('user_id');
        $userRole = (new UserModel())->find($userId)['role'];

        $data = [
            'reviews' => $reviewModel->where('user_id', $userId)->findAll(),
            'isAdmin' => $userRole === 'admin'
        ];

        if ($userRole === 'admin') {
            $carModel = new CarModel();
            $data['cars'] = $carModel->findAll();
            $data['allReviews'] = $reviewModel->findAll();
        }

        return view('dashboard', $data);
    }

    public function deleteCar($id)
    {
        $model = new CarModel();
        $model->delete($id);
        return redirect()->to('/dashboard');
    }

    public function deleteReview($id)
    {
        $model = new ReviewModel();
        $model->delete($id);
        return redirect()->to('/dashboard');
    }

    public function editCar($id)
    {
        $model = new CarModel();
        $data['car'] = $model->find($id);
        return view('edit_car', $data);
    }

    public function updateCar($id)
    {
        $model = new CarModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'brand' => $this->request->getPost('brand'),
            'description' => $this->request->getPost('description'),
            'release_year' => $this->request->getPost('release_year')
        ];
        $model->update($id, $data);
        return redirect()->to('/dashboard');
    }

    public function editReview($id)
    {
        $model = new ReviewModel();
        $data['review'] = $model->find($id);
        return view('edit_review', $data);
    }

    public function updateReview($id)
    {
        $model = new ReviewModel();
        $data = [
            'review' => $this->request->getPost('review'),
            'rating' => $this->request->getPost('rating')
        ];
        $model->update($id, $data);
        return redirect()->to('/dashboard');
    }
}
