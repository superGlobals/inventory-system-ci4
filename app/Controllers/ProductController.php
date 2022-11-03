<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\HTTP\Response;

class ProductController extends BaseController
{
    /**
     * Activate the helper and create function in helper folder
     */
    public function __construct()
    {
        helper(['url', 'form']);
    }

    /**
     * Show the product page
     */
    public function index()
    {
        $product = new ProductModel();  
        $data['products'] = $product->findAll();
        return view('admin/product', $data);
    }

    /**
     * Show the add product page
     */
    public function add()
    {   
        $category = new CategoryModel();
        $data['categories'] = $category->findAll();

        return view('admin/add_product', $data);
    }

    /**
     * Store product in database
     */
    public function storeProduct()
    {
         // custom validation
         $validated = $this->validate([
            'product_name' => [
                'rules' => 'required|alpha_space|min_length[2]',
                'errors' => [
                    'required' => 'Product Name is required',
                    'alpha_space' => 'Product Name cannot accept numbers and symbols',
                    'min_length' => 'Product Name must have 2 letters long',
                ]
            ],

            'category' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Category is required',
                ]
            ],

            'product_qty' => [
                'rules' => 'required|alpha_numeric',
                'errors' => [
                    'required' => 'Product Quantity is required',
                    'alpha_numeric' => 'Product Quantity can contain numbers only'
                ]
            ],

            'buying_price' => [
                'rules' => 'required|alpha_numeric',
                'errors' => [
                    'required' => 'Buying Price is required',
                    'alpha_numeric' => 'Buying Price can contain numbers only'
                ]
            ],

            'selling_price' => [
                'rules' => 'required|alpha_numeric',
                'errors' => [
                    'required' => 'Selling Price is required',
                    'alpha_numeric' => 'Selling Price can contain numbers only'
                ]
            ],

            'supplier' => [
                'rules' => 'required','alpha_space',
                'errors' => [
                    'required' => 'Supplier Name is required',
                    'alpha_space' => 'Supplier Name cannot accept numbers and symbols',
                ]
            ],

            'description' => [
                'rules' => 'required','alpha_space',
                'errors' => [
                    'required' => 'Description is required',
                    'alpha_space' => 'Description cannot accept numbers and symbols',
                ]
            ],
        ]);
        $category = new CategoryModel();
        $data['categories'] = $category->findAll();
        $data['validation'] = $this->validator;
        

        if(!$validated)
        {
            return view('admin/add_product', $data);
        }

        if($img = $this->request->getFile('product_image'))
        {
            if($img->isValid() && !$img->hasMoved())
            {
                $imageName = $img->getRandomName();
                $img->move('uploads/', $imageName);
            }
        }

        if(!empty($_FILES['product_image']['name']))
        {
            $productImage = $imageName;
        }
        else
        {
            $productImage = "no_image.jpg";
        }

        $product_id = 'PID-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        $totalProductPrice = $_POST['product_qty'] * $_POST['selling_price'];

        $data = [
            'product_id' => $product_id,
            'product_name' => $this->request->getPost('product_name', FILTER_SANITIZE_SPECIAL_CHARS),
            'category' => $this->request->getPost('category', FILTER_SANITIZE_SPECIAL_CHARS),
            'product_qty' => $this->request->getPost('product_qty', FILTER_SANITIZE_SPECIAL_CHARS),
            'supplier' => $this->request->getPost('supplier', FILTER_SANITIZE_SPECIAL_CHARS),
            'buying_price' => $this->request->getPost('buying_price', FILTER_SANITIZE_NUMBER_INT),
            'selling_price' => $this->request->getPost('selling_price', FILTER_SANITIZE_NUMBER_INT),
            'description' => $this->request->getPost('description', FILTER_SANITIZE_SPECIAL_CHARS),
            'product_image' => $productImage,
            'product_total_price' => $totalProductPrice,
        ];

        // save product info
        $product = new ProductModel();
        $save = $product->insert($data);

        if(!$save)
        {   
            return redirect()->to('/admin/add_product')
            ->with('status_icon', 'error')
            ->with('status_text', 'Error saving user')
            ->with('status', 'error');
        }
        else
        {
            return redirect()->to(base_url('admin/add_product'))
            ->with('status_icon', 'success')
            ->with('status_text', 'Product added successfully')
            ->with('status', 'Success');
        }
    }

    /**
     * Delete the product from database
     */
    public function deleteProduct($id = null)
    {
        $product = new ProductModel();
        $productImage = $product->find($id);
        $image = $productImage->product_image;

        if($image == "no_image.jpg")
        {
            $product->delete($id);
        }
        else
        {
            unlink("uploads/", $image);
            $product->delete($id);
        }

        $data = [
            'status' => 'Success',
            'status_text' => 'Product Deleted successfully',
            'status_icon' => 'success'
        ];

        return $this->response->setJSON($data);
    }

    /**
     * Show product edit page
     */
    public function edit($id = null)
    {
        $product = new ProductModel();

        $category = new CategoryModel();
        
        $data['categories'] = $category->findAll();
        $data['product'] = $product->find($id);

        return view('admin/edit_product', $data);
    }

    /**
     * Update product in database
     */
    public function updateProduct($id = null)
    {
        $updateProduct = new ProductModel();
        $db = db_connect();

        if($img = $this->request->getFile('product_image'))
        {
            if($img->isValid() && !$img->hasMoved())
            {
                $imageName = $img->getRandomName();
                $img->move('uploads/', $imageName);
            }
        }

        $productImage = $updateProduct->find($id);
        $product_image = $productImage->product_image;

        // update user profile
        if(!empty($_FILES['image']['name']))
        {
            if($product_image != "no_image.jpg")
            {
                unlink("uploads/".$product_image);
                $updateProfile = "UPDATE tbl_products SET product_image = :product_image: WHERE id = :id: LIMIT 1";
                $db->query($updateProfile, [
                    'product_image' => $imageName,
                    'id' => $id,
                ]);
            }
            else{
                $updateProfile = "UPDATE tbl_products SET profile = :profile: WHERE id = :id: LIMIT 1";
                $db->query($updateProfile, [
                    'product_image' => $imageName,
                    'id' => $id,
                ]);
            }
        }

        $totalProductPrice = $_POST['product_qty'] * $_POST['selling_price'];

        $data = [
            'product_name' => $this->request->getPost('product_name', FILTER_SANITIZE_SPECIAL_CHARS),
            'category' => $this->request->getPost('category', FILTER_SANITIZE_SPECIAL_CHARS),
            'product_qty' => $this->request->getPost('product_qty', FILTER_SANITIZE_SPECIAL_CHARS),
            'supplier' => $this->request->getPost('supplier', FILTER_SANITIZE_SPECIAL_CHARS),
            'buying_price' => $this->request->getPost('buying_price', FILTER_SANITIZE_NUMBER_INT),
            'selling_price' => $this->request->getPost('selling_price', FILTER_SANITIZE_NUMBER_INT),
            'description' => $this->request->getPost('description', FILTER_SANITIZE_SPECIAL_CHARS),
            'product_total_price' => $totalProductPrice,
        ];

        $updateProduct->update($id, $data);

        return redirect()->to(base_url('admin/product'))
            ->with('status_icon', 'success')
            ->with('status_text', 'Product updated successfully')
            ->with('status', 'Success');     

    }
}
