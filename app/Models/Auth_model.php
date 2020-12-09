<?php 

namespace App\Models;
 
use CodeIgniter\Model;
 
class Auth_model extends Model {    
 
    // public function getKpiByUser($user_id)
    // {
    //     return $this->db->table('tbl_kpi')
    //     ->getWhere(['user_id' => 1])->getResultArray();                         
        
    // }
    protected $table = 'tbl_user';
    
    
} 