<?php 

namespace App\Models;
 
use CodeIgniter\Model;
 
class Auth_model extends Model {    
 
    protected $table = 'tbl_user';
    
    public function updatePassword($data, $nik)
    {
        return $this->db->table($this->table)->update($data, ['nik' => $nik]);
    }

    public function cekUser($where, $data)
    {
        $query = $this->db->table($this->table);        
        $query->where($where, $data);
        return $query->get()->getRowArray();
    }

    public function getUser($nik){
        
        $query = $this->db->table('tbl_user as u');
        $query->select('u.*, ui.nama');        
        $query->join('tbl_user_info ui', 'u.id = ui.user_id');        
        $query->where('u.nik', $nik);
        return $query->get()->getRowArray();
        
        // return $query->get()->getRowArray();
        // $query = $this->db->table($this->table);        
        // $query->select('');
        // $query->where($where, $data);
        // return $query->get()->getRowArray();
    }

    public function insertUser($data, $table){        
        
        if($table == null){            
            $query = $this->db->table($this->table);        
            return $query->insert($data);
        } else {            
            $query = $this->db->table($table);        
            return $query->insert($data);
        }
        

    }
    
} 