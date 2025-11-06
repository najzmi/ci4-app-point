<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;

class Bo extends BaseController
{
    protected $data;
    public function __construct()
    {
        $this->data = [];
    }

    public function login()
    {
        helper('form');
        $this->data['pdn_title'] = 'Form Login';
        if($this->request->getMethod() === 'POST'){
            // Prosess Login
            $email      = $this->request->getPost('email_login');
            $password   = $this->request->getPost('password_login');

            $rules = [
                'email_login' => [
                    'label'  => 'Email',
                    'rules'  => 'required|valid_email|is_not_unique[users.email]',
                    'errors' => [
                        'required'    => 'Email harus diisi.',
                        'valid_email' => 'Format email tidak valid.',
                        'is_not_unique'   => 'Email tidak terdaftar.',
                    ]
                ],
                'password_login' => [
                    'label'  => 'Password',
                    'rules'  => 'required|min_length[8]',
                    'errors' => [
                        'required'   => 'Password harus diisi.',
                        'min_length' => 'Password terlalu pendek!',
                    ]
                ],
            ];
        
            $data = $this->request->getPost(array_keys($rules));

            if (! $this->validateData($data, $rules)) {
                $validation = \Config\Services::validation();
                // Jika ingin langsung menampilkan (debug)
                //echo $validation->listErrors();
                // Atau redirect kembali ke form dengan pesan error
                return redirect()->to('login')->withInput()->with('validation', $validation);
            }

            $modelUser = new UsersModel();
            $user = $modelUser->where('email', $email)->first();

            if ($user && password_verify($password, $user->password)){
                //Jika user ada dan password sesuai
                // Buat Session
                session()->set([
                    'is_login' => true,
                    'pdn_email' => $user->email,
                    'pdn_nama' => $user->first_name.' '.$user->last_name,
                    'pdn_level' => $user->role,
                    'pdn_token' => $user->token,                
                ]);
                return redirect()->to('/dashboard')->with('success', 'Selamat anda sudah berhasil login.');
                
            }else{
                // Jika user tidak ada dan password salah
                return redirect()->to('/login')->with('error', 'Maaf, Email dan Password anda tidak sesuai.');
            }
        }
        // Input Form
        $this->data['email_login'] = [
            'name'    => 'email_login',
            'id'      => 'email_login',
            'type'    => 'email',
            'class'   => 'form-control form-control-user',
            'required'=> 'required',
            'value'   => set_value('email_login'),
        ];
        $this->data['password_login'] = [
            'name'    => 'password_login',
            'id'      => 'password_login',
            'type'    => 'password',
            'class'   => 'form-control form-control-user',
            'required'=> 'required',
        ];

        return view('bo/login', $this->data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
