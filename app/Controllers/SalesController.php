<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\SalesModel;

class SalesController extends BaseController
{
    /**
     * Activate the helper and create function in helper folder
     */
    public function __construct()
    {
        helper(['url', 'form']);
    }

    /**
     * Show sales page
     */
    public function index()
    {

        $db = db_connect();
        $data['sales'] = $builder = $db->table('tbl_sales')
                                       ->select('*')
                                       ->join('tbl_products', 'tbl_products.id = tbl_sales.product_name', 'left')
                                       ->get()
                                       ->getResult();

        return view('admin/sales', $data);
    }

    /**
     * Show add sales page
     */
    public function add()
    {   
        $product = new ProductModel();
        $data['product_name'] = $product->findAll();

        return view('admin/add_sales', $data);
    }

    /**
     * Store sales in database
     */
    public function storeSales()
    {
        $product = new ProductModel();

        // custom validation
        $validated = $this->validate([
            'customer' => [
                'rules' => 'required|alpha_space|min_length[2]',
                'errors' => [
                    'required' => 'Customer Name is required',
                    'alpha_space' => 'Customer Name cannot accept numbers and symbols',
                    'min_length' => 'Customer Name must have atleast 2 letters long',
                ]
            ],

            'number_of_orders' => [
                'rules' => 'required|alpha_numeric',
                'errors' => [
                    'required' => 'Number of orders is required',
                    'alpha_numeric' => 'Number of orders can contain numbers only'
                ]
            ],
        ]);

        $data['product_name'] = $product->findAll();
        $data['validation'] = $this->validator;

        if(!$validated)
        {
            return view('admin/add_sales', $data);
        }

        $customer = $this->request->getPost('customer', FILTER_SANITIZE_SPECIAL_CHARS);
        $product_name = $this->request->getPost('product_name', FILTER_SANITIZE_NUMBER_INT);
        $number_of_orders = $this->request->getPost('number_of_orders', FILTER_SANITIZE_NUMBER_INT);
        $transaction_id = 'TID-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

        $productDb = $product->find($product_name);
        $product_qty = $productDb->product_qty;
        $product_total_price = $productDb->product_total_price;
        $selling_price = $productDb->selling_price;

        if($number_of_orders == 0)
        {
            return redirect()->to('/admin/add_sales')
            ->with('status_icon', 'warning')
            ->with('status_text', 'Bawal mo ilagay 0 hahah')
            ->with('status', 'HOY');
        }

        if($product_qty <= $number_of_orders)
        {
            return redirect()->to('/admin/add_sales')
            ->with('status_icon', 'warning')
            ->with('status_text', 'Wala kanag stocks hahah')
            ->with('status', 'HOY');
        }

        $updateProductQty = $product_qty - $number_of_orders;

        $updateTotalPrice = $selling_price * $updateProductQty;     

        $purchase_total_price = $selling_price * $number_of_orders;
        
        $db = db_connect();
        $updateProduct = "UPDATE tbl_products SET product_qty = :product_qty:, product_total_price = :product_total_price: 
        WHERE id =:id: LIMIT 1";
        $db->query($updateProduct, [
            'product_qty' => $updateProductQty,
            'product_total_price' => $updateTotalPrice,
            'id' => $product_name,
        ]);

        $data = [
            'transaction_id' => $transaction_id,
            'product_name' => $product_name,
            'customer_name' => $customer,
            'number_of_orders' => $number_of_orders,
            'purchase_total_price' => $purchase_total_price,
        ];

        

        $sales = new SalesModel();
        $save = $sales->insert($data);

        if(!$save)
        {   
            return redirect()->to('/admin/add_sales')
            ->with('status_icon', 'error')
            ->with('status_text', 'Error saving sales')
            ->with('status', 'error');
        }
        else
        {
            return redirect()->to(base_url('admin/add_sales'))
            ->with('status_icon', 'success')
            ->with('status_text', 'Sales added successfully')
            ->with('status', 'Success');
        }
        
    }
}
