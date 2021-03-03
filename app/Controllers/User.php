<?php namespace App\Controllers;


use App\Models\User_model;

class User extends BaseController
{        

	public function index()
	{
		return view('user/dashboard');
    }
    
    public function kpi(){       
        $session = session();                
        return view('user/tampil_kpi');
    }

    public function getKpiByUser(){
        
        $session = session();   
        
        $model = new User_model;
        $kpiData = $model->getKpiByUser($session->user_id);           
        
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
        
        $data['kpi'] = $hasil;

        return json_encode($data['kpi']);
    }

    public function tambahkpi(){
        return view('user/tambah_kpi');
    }

    public function simpanKpi(){

        $session = session();        
        $model = new User_model;
        $json = $this->request->getJSON();

        $data = [
            'judul_kpi' => $json->judul_kpi,
            'batas_tanggal' => $json->tanggal_berakhir,
            'user_id' => $session->user_id
        ];                   

                
        if($model->insertKpi($data)){
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

    public function updatekpi(){

        $session = session();       
        $model = new User_model;
        $json = $this->request->getJSON();     
           
       
        $data = [
            'judul_kpi' => $json->judulKpi,
            'batas_tanggal' => $json->batasTanggal,
            'user_id' => $session->user_id
        ];            
        
        $id = $json->id;

        if($model->updatekpi($data, $id)){
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

    public function hapuskpi(){

        $model = new User_model;
        $json = $this->request->getJSON();

        $data = [
            'id' => $json->id,            
        ];                           

        if($model->hapusKpi($data)){
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

    public function sop($id){                        
        
        $model = new User_model;
        
        $kpi = $model->getKpi($id);           
        $sop = $model->getSop($id);        

        $data = [
            'kpi' => $kpi,
            'sop' => $sop
        ];                

        return view('user/sop', $data);
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
