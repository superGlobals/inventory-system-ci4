<?php

namespace App\Controllers;

use App\Libraries\Hash;
use App\Models\UsersModel;
use App\Controllers\BaseController;

class UserController extends BaseController
{
    /**
     * Activate the helper and create function in helper folder
     */
    public function __construct()
    {
        helper(['url', 'form']);
    }

    /**
     * Show list of users
     */
    public function index()
    {   
        $users = new UsersModel();
        $data['users'] = $users->findAll();

        return view('admin/user', $data);
    }

    /**
     * Show add form
     */
    public function add()
    {
        if(!session('loggedUserRole' == "admin"))
        {
            return view('admin/add_user');
        }
        else
        {
            return redirect()->to(base_url('admin/users'));
        }
        
    }

    /**
     * Store user to database
     */
    public function storeUser()
    {
        // custom validation
        $validated = $this->validate([
            'firstname' => [
                'rules' => 'required|alpha_space|min_length[2]',
                'errors' => [
                    'required' => 'First Name is required',
                    'alpha_space' => 'First Name cannot accept numbers and symbols',
                    'min_length' => 'First Name must have 2 letters long',
                ]
            ],

            'lastname' => [
                'rules' => 'required|alpha_space|min_length[2]',
                'errors' => [
                    'required' => 'Last Name is required',
                    'alpha_space' => 'Last Name cannot accept numbers and symbols',
                    'min_length' => 'Last Name must have 2 letters long',
                ]
            ],

            'contact' => [
                'rules' => 'required|alpha_numeric',
                'errors' => [
                    'required' => 'Contact number is required',
                    'alpha_numeric' => 'Contact number can contain numbers only'
                ]
            ],

            'position' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Position is required',
                ]
            ],

            'email' => [
                'rules' => 'required|valid_email|is_unique[tbl_users.email]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Invalid email',
                    'is_unique' => 'Email already used',
                ]
            ],

            'password' => [
                'rules' => 'required|min_length[6]|max_length[20]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be 6 character long',
                    'max_length' => 'Password cannot be longer than 20 characters',
                ]
            ],
        ]);
        
        if(!$validated)
        {
            return view('admin/add_user', ['validation' => $this->validator]);
        }

        if($img = $this->request->getFile('image'))
        {
            if($img->isValid() && !$img->hasMoved())
            {
                $imageName = $img->getRandomName();
                $img->move('uploads/', $imageName);
            }
        }

        if(!empty($_FILES['image']['name']))
        {
            $imageProfile = $imageName;
        }
        else
        {
            $imageProfile = "user_male.jpg";
        }

        // else save the user in database
        $firstname = $this->request->getPost('firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = $this->request->getPost('lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $contact = $this->request->getPost('contact', FILTER_SANITIZE_NUMBER_INT);
        $position = $this->request->getPost('position');
        $email = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
        $password = $this->request->getPost('password', FILTER_SANITIZE_SPECIAL_CHARS);
        $profile = $imageProfile;
        $user_id = 'UID-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

        $data = [
            'user_id' => $user_id,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'contact' => $contact,
            'position' => $position,
            'email' => $email,
            'password' => Hash::encrypt($password),
            'profile' => $profile
        ];

        // saving user info in database
        $userModel = new UsersModel();
        $save = $userModel->insert($data);

        if(!$save)
        {
            return redirect()->to('/user/add_user')
            ->with('status_icon', 'error')
            ->with('status_text', 'Error saving user')
            ->with('status', 'error');
        }
        else
        {
            return redirect()->to(base_url('admin/add_user'))
            ->with('status_icon', 'success')
            ->with('status_text', 'User added successfully')
            ->with('status', 'Success');
        }
    }

    /**
     * Delete user info in database
     */
    public function deleteUser($id = null)
    {
        $user = new UsersModel();

        $userProfile = $user->find($id);
        $profile = $userProfile->profile;

        if($profile == "user_male.jpg")
        {
            $user->delete($id);
        }
        else
        {
            unlink("uploads/".$profile);
            $user->delete($id);
        }

        $data = [
            'status' => 'Success',
            'status_text' => 'User Deleted successfully',
            'status_icon' => 'success'
        ];

        return $this->response->setJSON($data);
    }

    /**
     * Show user edit page
     */
    public function edit($id = null)
    {
        $user = new UsersModel();
        $data['user'] = $user->find($id);

        return view('admin/edit_user', $data);
    }

    /**
     * Update user info in database
     */
    public function updateUser($id = null)
    {
        $updateUser = new UsersModel();
        $db = db_connect();

        if($img = $this->request->getFile('image'))
        {
            if($img->isValid() && !$img->hasMoved())
            {
                $imageName = $img->getRandomName();
                $img->move('uploads/', $imageName);
            }
        }

        $userProfile = $updateUser->find($id);
        $profile = $userProfile->profile;

        // update user profile
        if(!empty($_FILES['image']['name']))
        {
            if($profile != "user_male.jpg")
            {
                unlink("uploads/".$profile);
                $updateProfile = "UPDATE tbl_users SET profile = :profile: WHERE id = :id: LIMIT 1";
                $db->query($updateProfile, [
                    'profile' => $imageName,
                    'id' => $id,
                ]);
            }
            else{
                $updateProfile = "UPDATE tbl_users SET profile = :profile: WHERE id = :id: LIMIT 1";
                $db->query($updateProfile, [
                    'profile' => $imageName,
                    'id' => $id,
                ]);
            }
        }

        $pass = $_POST['password'];
        $hash = Hash::encrypt($pass);

        // update user password
        if(!empty($pass))
        {   
            $updatePass = "UPDATE tbl_users SET password = :passoword: WHERE id = :id: LIMIT 1";
            $db->query($updatePass, [
                'password' => $hash,
                'id' => $id,
            ]);
        }
        
        $data = [
            'first_name' => $this->request->getPost('firstname'),
            'last_name' => $this->request->getPost('lastname'),
            'contact' => $this->request->getPost('contact'),
            'postion' => $this->request->getPost('postion'),
            'email' => $this->request->getPost('email'),
        ];

        $updateUser->update($id, $data);

        return redirect()->to(base_url('admin/users'))
            ->with('status_icon', 'success')
            ->with('status_text', 'User updated successfully')
            ->with('status', 'Success');       
    }
}
