<?php 

namespace App\Models;
 
use CodeIgniter\Model;
 
class User_model extends Model {    
 
    public function getKpiByUser($user_id)
    {
        return $this->db->table('tbl_kpi')
        ->getWhere(['user_id' => $user_id])->getResultArray();                         
        
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

    public function getKpi($id){

        return $this->db->table('tbl_kpi')
        ->getWhere(['id' => $id])->getRowArray();        
    }

    public function insertSop($data){

        return $this->db->table('tbl_sop')
        ->insert($data);                                 

    }    

    public function updateSop($data, $id){

        return $this->db->table('tbl_sop')->where('id', $id)->update($data);

    }

    public function hapusSop($data){

        return $this->db->table('tbl_sop')
        ->delete($data);                                 

    }
    
} 