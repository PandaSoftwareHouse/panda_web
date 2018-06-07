<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Minmax_Model extends CI_Model
{
  
    public function __construct()
	{
		parent::__construct();
	}


    public function login_data($username, $userpass)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.set_user WHERE user_name='$username' AND user_password='$userpass'";
        $query = $this->db->query($sql);
        return $query->num_rows();
        
    }
    
    public function home_data()  
    {  
         
        //data is retrive from this query
        /*$sql = "SELECT * FROM backend_warehouse.module_menu WHERE hide_menu = '2'";*/
        $sql = "SELECT * FROM backend_warehouse.module_menu";
        $query = $this->db->query($sql);  
        return $query;  
    }


     public function check_binID($bin_ID)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_stktake.set_bin WHERE bin_no='$bin_ID'";
        $query = $this->db->query($sql);
        return $query;
    }
    
    public  function insert_sysrun($data)
    {
        $this->db->insert('backend_warehouse.set_min_max', $data);
    }

    public  function update_sysrun($data)
    {
        $this->db->where('loc_group', $_SESSION['loc_group']);
        $this->db->where('bin_id', $_SESSION['bin_ID']);
        $this->db->where('itemcode', $data['itemcode']);
        $this->db->update('backend_warehouse.set_min_max',$data);
    }
    

}
?> 
