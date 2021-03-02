<?php 

namespace App\Models;
 
use CodeIgniter\Model;
 
class Admin_model extends Model {    
    
 
    public function getListKpi()
    {       

        $query = $this->db->table('tbl_user_info as info');
        $query->select('u.id as user_id, info.nama');
        $query->join('tbl_user u', 'u.id = info.user_id');        
        return $query->get()->getResultArray();
        
    }

    public function getJmlKpi($userId){
        
        $query = $this->db->table('tbl_kpi');
        $query->select('count(*) AS jmlKpi');
        $query->where('user_id', $userId);
        return $query->get()->getRowArray();

    }

    public function getJmlSop($userId){
        
        $query = $this->db->table('tbl_sop as s');
        $query->select('count(*) as jmlSop');        
        $query->join('tbl_kpi k', 'k.id = s.kpi_id');
        $query->join('tbl_user u', 'k.user_id = u.id');
        $query->where('u.id', $userId);
        return $query->get()->getRowArray();
    }


    public function getKpiByUser($user_id)
    {
        return $this->db->table('tbl_kpi')
        ->getWhere(['user_id' => $user_id])->getResultArray();                         
        
    }

    public function getSop($kipId){

        return $this->db->table('tbl_sop')
        ->getWhere(['kpi_id' => $kipId])->getResultArray();                                 

    }

    public function getKpi($id){

        return $this->db->table('tbl_kpi')
        ->getWhere(['id' => $id])->getRowArray();        
    }

    
    
} 