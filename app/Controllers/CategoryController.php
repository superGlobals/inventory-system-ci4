<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{   

    /**
     * Activate the helper and create function in helper folder
     */
    public function __construct()
    {
        helper(['url', 'form']);
    }

    /**
     * Show category page
     */
    public function index()
    {
        $category = new CategoryModel();
        $data['categories'] = $category->findAll();
        return view('admin/category', $data);
    }

    /**
     * Show the add category page
     */
    public function add()
    {
        return view('admin/add_category');
    }

    /**
     * Store the category in database
     */
    public function storeCategory()
    {   
        $category = new CategoryModel();

        // custom validation
        $validated = $this->validate([
            'category_name' => [
                'rules' => 'required|alpha_space|min_length[2]',
                'errors' => [
                    'required' => 'Category Name is required',
                    'alpha_space' => 'Category Name cannot accept numbers and symbols',
                    'min_length' => 'Category Name must have atleast 2 letters long',
                ]
            ],

            'description' => [
                'rules' => 'required|alpha_space|min_length[2]',
                'errors' => [
                    'required' => 'Description is required',
                    'alpha_space' => 'Description cannot accept numbers and symbols',
                    'min_length' => 'Description must have atleast 2 letters long',
                ]
            ],
        ]);

        if(!$validated)
        {
            return view('admin/add_category', ['validation' => $this->validator]);
        }

        $data = [
            'category_name' => $this->request->getPost('category_name', FILTER_SANITIZE_SPECIAL_CHARS),
            'description' => $this->request->getPost('description', FILTER_SANITIZE_SPECIAL_CHARS),
        ];

        $save = $category->insert($data);

        if(!$save)
        {
            return redirect()->to('/category/add_category')
            ->with('status_icon', 'error')
            ->with('status_text', 'Error saving category')
            ->with('status', 'error');
        }
        else
        {
            return redirect()->to(base_url('admin/add_category'))
            ->with('status_icon', 'success')
            ->with('status_text', 'Category added successfully')
            ->with('status', 'Success');
        }
    }

    /**
     * Delete category from database
     */
    public function deleteCategory($id = null)
    {
        $category = new CategoryModel();
        $category->delete($id);

        $data = [
            'status' => 'Success',
            'status_text' => 'Category Deleted successfully',
            'status_icon' => 'success'
        ];

        return $this->response->setJSON($data);
    }

    /**
     * Show the edit category page
     */
    public function edit($id = null)
    {
        $category = new CategoryModel();
        $data['category'] = $category->find($id);

        return view('admin/edit_category', $data);
    }

    /**
     * Update category in database
     */
    public function updateCategory($id = null)
    {
        $categoryUpdate = new CategoryModel();

        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'description' => $this->request->getPost('description'),
        ];

        $categoryUpdate->update($id, $data);

        return redirect()->to(base_url('admin/category'))
            ->with('status_icon', 'success')
            ->with('status_text', 'Category updated successfully')
            ->with('status', 'Success'); 
    }
}
