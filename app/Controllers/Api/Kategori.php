<?php 

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Kategori extends ResourceController
{

    protected $format       = 'json';
    protected $modelName    = 'App\Models\Kategori_model';

	public function index(){
        return $this->respond($this->model->findAll(), 200);        
    }

    public function create(){

        $validation =  \Config\Services::validation();

        $data = file_get_contents("php://input");

        $row = json_decode($data);
        echo print_r($row);
        exit;
        $data = [
            'kategori' => $kategori,            
        ];

        if($validation->run($data, 'kategori') == FALSE){
            $response = [
                'status' => 500,
                'error' => true,
                'data' => $validation->getErrors(),
            ];

            return $this->respond($response, 500);
        } else {

            $simpan = $this->model->insertCategory($data);         

            if($simpan){
                $msg = ['message' => 'Berhasil buat kategori'];
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' => $msg,
                ];
                return $this->respond($response, 200);
            } 
        }
        
    }

    public function show($id = NULL){

        $get = $this->model->getCategory($id);

        if($get){
            $code = 200;
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $get
            ];
        } else {
            $code = 401;
            $msg = ['message' => 'Kategori tidak ditemukan'];
            $response = [
                'status' => $code,
                'error' => true,
                'data' => $msg
            ];
        }

        return $this->respond($response, $code);

    }

    public function edit($id = NULL){
        $get = $this->model->getCategory($id);

        if($get){
            $code = 200;
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $get
            ];
        } else {
            $code = 401;
            $msg = ['message' => 'Kategori tidak ditemukan'];
            $response = [
                'status' => $code,
                'error' => true,
                'data' => $msg
            ];
        }

        return $this->respond($response, $code);
    }

    public function update($id = NULL){

        $validation =  \Config\Services::validation();

        $kategori   = $this->request->getRawInput('kategori');                                    

        $data = [
            'kategori' => $kategori,            
        ];

        if($validation->run($data, 'kategori') == FALSE){
            $response = [
                'status' => 500,
                'error' => true,
                'data' => $validation->getErrors(),
            ];
            return $this->respond($response, 500);
        } else {
            $simpan = $this->model->updateCategory($data,$id);
            if($simpan){
                $msg = ['message' => 'Berhasil update kategori!'];
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' => $msg,
                ];
                return $this->respond($response, 200);
            }
        }

    }

    public function delete($id = NULL){

        $hapus = $this->model->getCategory($id);        
        if($hapus){
            $this->model->deleteCategory($id); 
            $code = 200;
            $msg = ['message' => 'Berhasil hapus kategori'];
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $msg
            ];
        } else {
            $code = 401;
            $msg = ['message' => 'Kategori tidak ditemukan'];
            $response = [
                'status' => $code,
                'error' => true,
                'data' => $msg
            ];
        }

        return $this->respond($response, $code);

    }
        	
}
