<?php

namespace App\Controllers;

use App\Models\ReviewModel;
use CodeIgniter\Controller;

class ReviewController extends Controller
{
    public function save()
    {
        $reviewModel = new ReviewModel();

        $data = [
            'car_id' => $this->request->getPost('car_id'),
            'user_id' => session()->get('user_id'),
            'username' => session()->get('username'),
            'review' => $this->request->getPost('review'),
            'rating' => $this->request->getPost('rating')
        ];

        $reviewModel->save($data);

        return $this->response->setJSON(['success' => true]);
    }
}
