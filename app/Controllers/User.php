<?php namespace App\Controllers;


use App\Models\User_model;

class User extends BaseController
{    

	public function index()
	{
		return view('user/dashboard');
    }
    
    public function kpi(){                

        return view('user/tampil_kpi');
    }

    public function getKpi(){

        $model = new User_model;
        $kpiData = $model->getKpi(1);           
        
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

        $model = new User_model;
        $json = $this->request->getJSON();

        $data = [
            'judul_kpi' => $json->judul_kpi,
            'batas_tanggal' => $json->tanggal_berakhir,
            'user_id' => 1
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

        $model = new User_model;
        $json = $this->request->getJSON();        
       
        $data = [
            'judul_kpi' => $json->judulKpi,
            'batas_tanggal' => $json->batasTanggal,
            'user_id' => 1
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
	

}
