<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {   

        $db = db_connect();
        $users = $db->table('tbl_users');
        $products = $db->table('tbl_products');
        $sales = $db->table('tbl_sales');
        $data['users'] = $users->countAll(); // return all count of sales
        $data['products'] = $products->countAll();
        $data['sales'] = $sales->countAll();

        return view('admin/home', $data);
    }
}
