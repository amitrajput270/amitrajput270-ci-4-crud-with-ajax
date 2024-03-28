<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProductController extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function inserDataInDataBase()
    {
        $productModel = new \App\Models\Products();
        $productModel->inserDataInDataBase();
        return $this->response->setJSON([
            'error' => false,
            'message' => 'Successfully inserted data in database',
        ]);
    }

    public function add()
    {
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $data = [
            'title' => $this->request->getPost('title'),
            'category' => $this->request->getPost('category'),
            'description' => $this->request->getPost('description'),
            'image' => $fileName,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $validation = \Config\Services::validation();
        $validation->setRules([
            'image' => 'uploaded[file]|max_size[file,1024]|is_image[file]|mime_in[file,image/jpg,image/jpeg,image/png]',
        ]);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'error' => true,
                'message' => $validation->getErrors(),
            ]);
        } else {
            $file->move('uploads/avatar', $fileName);
            $postModel = new \App\Models\Products();
            // $postModel->save($data);
            $postModel->createData($data);
            return $this->response->setJSON([
                'error' => false,
                'message' => 'Successfully added',
            ]);
        }
    }
    public function fetch()
    {
        $postModel = new \App\Models\Products();
        // $posts = $postModel->findAll();
        $posts = $postModel->allData();
        $data = '';

        if ($posts) {
            foreach ($posts as $post) {
                $data .= '<div class="col-md-4">
                <div class="shadow-sm card">
                  <a href="#" id="' . $post['id'] . '" data-bs-toggle="modal" data-bs-target="#detail_product_modal" class="product_detail_btn"><img src="uploads/avatar/' . $post['image'] . '" class="img-fluid card-img-top"></a>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="card-title fs-5 fw-bold">' . $post['title'] . '</div>
                      <div class="badge bg-dark">' . $post['category'] . '</div>
                    </div>
                    <p>
                      ' . substr($post['description'], 0, 80) . '...
                    </p>
                  </div>
                  <div class="card-footer d-flex justify-content-between align-items-center">
                    <div class="fst-italic">' . date('d F Y', strtotime($post['created_at'])) . '</div>
                    <div>
                      <a href="#" id="' . $post['id'] . '" data-bs-toggle="modal" data-bs-target="#edit_product_modal" class="btn btn-success btn-sm product_edit_btn">Edit</a>
                      <a href="#" id="' . $post['id'] . '" class="btn btn-danger btn-sm product_delete_btn">Delete</a>
                    </div>
                  </div>
                </div>
              </div>';
            }
            return $this->response->setJSON([
                'error' => false,
                'message' => $data,
            ]);
        } else {
            return $this->response->setJSON([
                'error' => false,
                'message' => '<div class="my-5 text-center text-secondary fw-bold">No product found in the database!</div>',
            ]);
        }
    }

    public function edit($id = null)
    {
        $postModel = new \App\Models\Products();
        // $post = $postModel->find($id);
        $post = $postModel->editData($id);
        return $this->response->setJSON([
            'error' => false,
            'message' => $post,
        ]);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $file = $this->request->getFile('file');
        $fileName = $file->getFilename();

        if ($fileName != '') {
            $fileName = $file->getRandomName();
            $file->move('uploads/avatar', $fileName);
            if ($this->request->getPost('old_image') != '') {
                unlink('uploads/avatar/' . $this->request->getPost('old_image'));
            }
        } else {
            $fileName = $this->request->getPost('old_image');
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'category' => $this->request->getPost('category'),
            'description' => $this->request->getPost('description'),
            'image' => $fileName,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $postModel = new \App\Models\Products();
        // $postModel->update($id, $data);
        $postModel->updateData($id, $data);
        return $this->response->setJSON([
            'error' => false,
            'message' => 'Successfully updated',
        ]);
    }

    public function delete($id = null)
    {
        $postModel = new \App\Models\Products();
        // $post = $postModel->find($id);
        // $postModel->delete($id);
        // unlink('uploads/avatar/' . $post['image']);
        $postModel->deleteData($id);
        return $this->response->setJSON([
            'error' => false,
            'message' => 'Successfully deleted',
        ]);
    }

    public function detail($id = null)
    {
        $postModel = new \App\Models\Products();
        // $post = $postModel->find($id);
        $post = $postModel->details($id);
        return $this->response->setJSON([
            'error' => false,
            'message' => $post,
        ]);
    }
}
