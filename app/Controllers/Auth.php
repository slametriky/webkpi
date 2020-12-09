<?php namespace App\Controllers;

use App\Models\Auth_model;

class Auth extends BaseController
{    

	public function index()
	{
		return view('login');
    }

    public function login()
    {
        $session = session();
        $model = new Auth_model();
        $nik = $this->request->getVar('nik');
        $password = $this->request->getVar('password');
                
        $data = $model->where('nik', $nik)->first();

        if($data){            
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if($verify_pass){
                
                $ses_data = [
                    'user_id'       => $data['id'],
                    'nik'           => $data['nik'],
                    'email'         => $data['email'],
                    'level'         => $data['level'],
                    'logged_in'     => TRUE
                ];

                $session->set($ses_data);
                
                return redirect()->to(base_url('kpi'));

            }else{
                echo 'salah_password';
                exit;
                $session->setFlashdata('msg', 'Salah Password');
                return redirect()->to(base_url('login'));
            }
        }else{                        
            echo 'nik tidak terdaftar';
            exit;
            $session->setFlashdata('msg', 'NIK tidak terdaftar!');
            return redirect()->to(base_url('login'));
        }
    }
    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('login'));
    }
    
}
