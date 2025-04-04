<?php

namespace App\Controllers;

use App\Models\ReviewModel;
use CodeIgniter\Controller;

class ReviewController extends Controller
{
    public function save()
    {
        $model = new ReviewModel();
        $model->save([
            'car_id' => $this->request->getPost('car_id'),
            'user_id' => session()->get('user_id'),
            'username' => session()->get('username'),
            'review' => $this->request->getPost('review'),
            'rating' => $this->request->getPost('rating')
        ]);
        return redirect()->to('/car/' . $this->request->getPost('car_id'));
    }

    public function edit($id)
    {
        $model = new ReviewModel();
        $data['review'] = $model->find($id);
        return view('edit_review', $data);
    }

    public function update($id)
    {
        $model = new ReviewModel();
        $carId = $this->request->getPost('car_id');

        $model->update($id, [
            'review' => $this->request->getPost('review'),
            'rating' => $this->request->getPost('rating')
        ]);

        return redirect()->to('/car/' . $carId);
    }

    public function delete($id)
    {
        $model = new ReviewModel();
        $review = $model->find($id);
        $model->delete($id);

        return redirect()->to('/car/' . $review['car_id']);
    }
}
