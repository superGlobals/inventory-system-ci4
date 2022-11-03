<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Hash;
use App\Models\UsersModel;

class AuthController extends BaseController
{   

    /**
     * Activate the helper and create function in helper folder
     */
    public function __construct()
    {
        helper(['url', 'form']);
    }

    /**
     * Show login page
     */
    public function index()
    {
        if(session()->has('loggedUserId'))
        {
            return redirect()->to(base_url('admin/dashboard'));
        }
        else
        {
            return view('login');
        }
    }

    /**
     * Loggedin user
     */
    public function loginUser()
    {
        // validate user input
        $validated = $this->validate([

            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Please enter your email',
                    'valid_email' => 'Please enter a valid email',
                ]
            ],

            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter your Password',
                    
                ]
            ],

        ]);

        if(!$validated)
        {
            return view('login', ['validation' => $this->validator]);
        }
        else
        {
            // check the user details in database
            $email = $this->request->getPost('email', FILTER_VALIDATE_EMAIL);
            $password = $this->request->getPost('password', FILTER_SANITIZE_SPECIAL_CHARS);

            $user = new UsersModel();
            $userInfo = $user->where('email', $email)->first();

            if($userInfo)
            {   

                if($checkPass = Hash::check($password, $userInfo->password))
                {
                    $userId = $userInfo->id;
                    $userRole = $userInfo->position;
                    session()->set('loggedUserId', $userId);
                    session()->set('loggedUserRole', $userRole);

                    return redirect()->to(base_url('admin/dashboard'));
                }
                else
                {
                    session()->setFlashdata('invalid', 'Invalid Credentials');
                    return redirect()->to(base_url('/'));
                }

            }
            else
            {
                session()->setFlashdata('invalid', 'Invalid Credentials');
                return redirect()->to(base_url('/'));
            }
        }
    }

    public function logout()
    {
        if(session()->has('loggedUserId') || session()->has('loggedUserRole'))
        {
            session()->remove('loggedUserId');
            session()->remove('loggedUserRole');
        }

        return redirect()->to(base_url('/'))->with('invali', 'You are logged out');
    }
}
