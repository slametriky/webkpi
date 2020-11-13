<?php 

namespace App\Models;
 
use CodeIgniter\Model;
 
class User_model extends Model {
 
    public function getKpi($user_id)
    {
        return $this->db->table('tbl_kpi')
        ->getWhere(['user_id' => 1])->getResultArray();                         
        
    }

    public function getSop($kipId){

        return $this->db->table('tbl_sop')
        ->getWhere(['kpi_id' => $kipId])->getResultArray();                                 

    }

    public function insertKpi($data){

        return $this->db->table('tbl_kpi')
        ->insert($data);                                 

    }    

    public function updateKpi($data, $id){

        return $this->db->table('tbl_kpi')->where('id', $id)->update($data);

    }

    public function hapusKpi($data){

        return $this->db->table('tbl_kpi')
        ->delete($data);                                 

    }
    
} 