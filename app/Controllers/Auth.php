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
                
        $data = $model->getUser($nik);        

        if($data){            
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if($verify_pass){
                
                $ses_data = [
                    'nama'          => $data['nama'],
                    'user_id'       => $data['id'],
                    'nik'           => $data['nik'],
                    'email'         => $data['email'],
                    'level'         => $data['level'],
                    'logged_in'     => TRUE
                ];                

                $session->set($ses_data);

                if($ses_data['level'] == 'admin'){
                    return redirect()->to(base_url('admin'));

                } else {
                    return redirect()->to(base_url('kpi'));

                }
                
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

    public function register()
	{
		return view('daftar');
    }

    public function prosesDaftar()
	{                

        $session = session();
        $model = new Auth_model();        

        
        $nik = $_POST['nik'];        
        $nama = $_POST['nama'];        
        $jenkel = $_POST['jenkel'];        
        $handphone = $_POST['handphone'];        
        $email = $_POST['email'];        
        $password = $_POST['password'];        
        $password_konfirm = $_POST['password_konfirm'];                  

        //cek nik apakah sudah ada
        $cekUser = $model->cekUser('nik', $nik);                
        
        if(!empty($cekUser)){
            $respon = [
                'code' => 400,
                'message' => 'NIK sudah terdaftar, silahkan cek kembali NIK Anda!'
            ];
        } else {            
            
            //insert data
            $data = [
                'nik'       => $nik,
                'password'  => password_hash($password, PASSWORD_DEFAULT),
                'level'     => 'user'
            ];
        
            $model->insertUser($data, null);            

            $lastId = $model->insertID();
            
            $dataInfo = [
                'user_id'       => $lastId,
                'nama'          => $nama,
                'jenis_kelamin' => $jenkel,
                'handphone'     => $handphone,
                'email'         => $email
            ];
                        
            $insert_userinfo = $model->insertUser($dataInfo, 'tbl_user_info');

            if($insert_userinfo){
                $respon = [
                    'code' => 200,
                    'message' => 'Berhasil daftar, silahkan login'
                ];
            } else {
                $respon = [
                    'code' => 400,
                    'message' => 'Gagal daftar!'
                ];
            }
                        
            
        }

        return json_encode($respon);        
        
    }


    public function gantiPassword()
    {
        return view('ganti_password.php');
    }

    public function gantiPasswordAction()
    {   
        $session = session();
        $model = new Auth_model();        
                
        $nik = $session->nik;
        $passwd_lama = $_POST['passwd_lama'];
        $passwd_baru = $_POST['passwd_baru'];
        $passwd_konfirm = $_POST['passwd_konfirm'];

        $cekUser = $model->where('nik', $nik)->first();                

        if(!empty($cekUser)){
            
            //cek password            
            $verify_pass = password_verify($passwd_lama, $cekUser['password']);                       
            
            if($verify_pass){    
                

                $new_passwd = password_hash($passwd_baru, PASSWORD_DEFAULT);
                
                $data_update = [
                    'password' => $new_passwd
                ];                
                
                $update_data = $model->updatePassword($data_update, $nik);                
                
                if($update_data){
                    $respon = [
                        'code' => 200,
                        'message' => 'Berhasil update password'
                    ];
                } else {
                    $respon = [
                        'code' => 200,
                        'message' => 'Gagal update password'
                    ];
                }                
                
            } else {
                $respon = [
                    'code' => 400,
                    'message' => 'Password lama salah, silahkan cek kembali'
                ];
            }
        }         

        return json_encode($respon);
                 
    }
    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('login'));
    }
    
}
