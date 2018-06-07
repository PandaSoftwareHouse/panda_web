<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_attendance_model extends CI_Model {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
        $this->load->library('form_validation');

	}

    public function get_data()
    {
        $sql = "SELECT GST,Suppliers,RefNo,Amount,Remark,web_guid,LEFT(Created_at,10) as date,RIGHT(Created_at,8) as time ,Updated_at FROM backend_warehouse.attendance WHERE DATE(Created_at) = DATE(NOW()) ORDER BY date DESC,time DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_date_data($date) //add
    {
        $sql = "SELECT GST,Suppliers,RefNo,Amount,Remark,web_guid,LEFT(Created_at,10) as date,RIGHT(Created_at,8) as time ,Updated_at FROM backend_warehouse.attendance WHERE LEFT(Created_at,10) = '$date' ORDER BY date DESC,time DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_supplier()
    {
        $sql = "SELECT Name, code,Type FROM backend.supcus";
        $query = $this->db->query($sql);
        return $query;
    }

    public function insert_data($gst,$code,$supplier,$refno,$Amount,$remark)
    {
        /*$data['suppliers'] = $suppliers;*/
        $username = $_SESSION['username'];
        $sql = "INSERT INTO backend_warehouse.attendance (web_guid, Code,Suppliers, RefNo,Amount,GST,Remark,Created_by,Created_at,Updated_by,Updated_at)
        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$code', '$supplier', '$refno','$Amount','$gst','$remark','$username',NOW(),'$username',NOW())";
        $query = $this->db->query($sql);
        return $query; 
    }

    public function fetch_single_data($trans) //change
    {
        $data = "SELECT GST,Suppliers,Code,RefNo,Amount,Remark,web_guid,LEFT(Created_at,10) as date FROM backend_warehouse.attendance WHERE web_guid ='$trans'";
        $sql = $this->db->query($data);
        return $sql;
    }

    public function update_data($gst,$supplier,$refno,$Amount,$remark,
            $trans)
    {
        $username = $_SESSION['username'];
        $sql = "UPDATE backend_warehouse.attendance 
                SET Suppliers = '$supplier', RefNo = '$refno', Amount = '$Amount', GST = '$gst',Remark = '$remark', Updated_by = '$username', Updated_at = Now() 
                WHERE web_guid = '$trans'";
        $query = $this->db->query($sql);
        return $query; 
    }

    public function insert_supplier($code,$name,$address)
    {
        $sql = "INSERT INTO backend.supcus (supcus_guid, Type, Code, Name, Add1)
        VALUES ( REPLACE(UPPER(UUID()),'-',''), 'S', '$code', '$name','$address' )";
        $query = $this->db->query($sql);
        return $query;
    }

}
?> 