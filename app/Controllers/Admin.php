<?php namespace App\Controllers;


use App\Models\Admin_model;

class Admin extends BaseController
{        

	public function index()
	{        
		return view('admin/dashboard');
    }
    
    public function kpi(){       
        $session = session();                
        return view('admin/tampil_kpi');
    }

    public function getListKpi(){
        
        $model = new Admin_model;
        
        $listKpi = $model->getListKpi();           

        $data = [];

        foreach($listKpi as $kpi){

            $jmlKpi = $model->getJmlKpi($kpi['user_id']);
            $jmlSop = $model->getJmlSop($kpi['user_id']);

            $data[] = [
                'user_id' => $kpi['user_id'],
                'nama' => $kpi['nama'],
                'jmlKpi' => $jmlKpi['jmlKpi'],
                'jmlSop' => $jmlSop['jmlSop'],
            ];
            
        }    
        
        return json_encode($data);
        
    }   

    public function getKpiByUser(){

        $json = $this->request->getJSON();                        
        
        $user_id = $json->user_id;

        $model = new Admin_model;
        $kpiData = $model->getKpiByUser($user_id);                      
        
        if(count($kpiData) > 0){

            foreach($kpiData as $kpi){
                
                $sopData = $model->getSop($kpi['id']);            
                $jumlahSop = count($sopData);
                $selesai = 0;
                $belum = 0;
    
                foreach($sopData as $sop){
    
                    if($sop['status'] == 0) {
                        $belum += 1;
                    } else if($sop['status'] == 1){
                        $selesai += 1;
                    }
                }
    
                $hasil[] = [
                    'id' => $kpi['id'],
                    'judulKpi' => $kpi['judul_kpi'],
                    'batasTanggal' => $kpi['batas_tanggal'],
                    'jumlahSop' => $jumlahSop,
                    'selesai' => $selesai,
                    'belum' => $belum
    
                ];            
                            
            }     
            
            $data['kpi'] = [
                'error_code' => 0,
                'data' => $hasil
            ];
            // $data['kpi'] = $hasil;
            

        } else {

            $data['kpi'] = [
                'error_code' => 0,
                'data' => []
            ];
            
        }
        
        return json_encode($data['kpi']);
       

        
    }

    public function sop(){      
        
        $json = $this->request->getJSON();    
        
        $id = $json->id;

        $model = new Admin_model;;
        
        $kpi = $model->getKpi($id);           
        $sop = $model->getSop($id);        

        $data = [
            'kpi' => $kpi,
            'sop' => $sop
        ];                

        return json_encode($data);
    }

    public function simpanSop(){
        
        $kpi_id = $this->request->getPost('kpi_id');
        $sop = $this->request->getPost('sop');
        $status = $this->request->getPost('status');
        $file = $this->request->getFile('file');


        //upload file
        //validasi file upload
        // $validated = $this->validate([
        //     'file' => [
        //         'uploaded[file]',
        //         'mime_in[avatar,image/jpg,image/jpeg',
        //         'max_size[avatar,1000]',
        //     ],
        // ]);
        
        // print_r(ROOTPATH.'public/img/');
        // exit;

        $nama_baru = $file->getRandomName();
        
        if($file->move(ROOTPATH.'public/img/', $nama_baru)){
            
            $model = new User_model;        
            $data = [
                'sop' => $sop,
                'status' => $status,
                'file' => $nama_baru,
                'kpi_id' => $kpi_id
            ];                      
                
            if($model->insertSop($data)){
                $respon = [
                    'code' => 200,
                    'message' => 'Berhasil'
                ];
            } else {
                $respon = [
                    'code' => 400,
                    'message' => 'Gagal'
                ];
            }

            return json_encode($respon);

        }                                             
        
    }
	
    public function getSop(){

        $model = new User_model;

        $kpi_id = $this->request->uri->getSegment(2);
        $sopData = $model->getSop($kpi_id);                                                   

        return json_encode($sopData);
    }

    public function updateSop(){
        
        $id = $this->request->getPost('id');
        $sop = $this->request->getPost('sop');
        $status = $this->request->getPost('status');
        $file = $this->request->getFile('file');
        $gambar = $this->request->getPost('gambar');

        $model = new User_model;        

        if($file){
            //hapus file lama            
            if(file_exists($gambar)) unlink($gambar);  
            //update sop
            $nama_baru = $file->getRandomName();
            $file->move(ROOTPATH.'public/img/', $nama_baru);

            $data_update = [
                'sop' => $sop,
                'status' => $status,
                'file' => $nama_baru
            ];


        } else {            

            //update sop
            $data_update = [
                'sop' => $sop,
                'status' => $status,                
            ];
            
        }        

        if($model->updateSop($data_update, $id)){
            $respon = [
                'code' => 200,
                'message' => 'Berhasil'
            ];
        } else {
            $respon = [
                'code' => 400,
                'message' => 'Gagal'
            ];
        }

        return json_encode($respon);
        
    }

    public function hapussop(){

        $model = new User_model;
        $json = $this->request->getJSON()->data;
    
        //hapus gambar
        $lokasi_file = ROOTPATH.'public/img/'.$json->file;
        if(file_exists($lokasi_file)) unlink($lokasi_file);    
            
        $data = [
            'id' => $json->id,            
        ];                           

        if($model->hapusSop($data)){
            $respon = [
                'code' => 200,
                'message' => 'Berhasil'
            ];
        } else {
            $respon = [
                'code' => 400,
                'message' => 'Gagal'
            ];
        }

        return json_encode($respon);
        
    }
}
