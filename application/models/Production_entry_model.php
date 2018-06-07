<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class production_entry_model extends CI_Model
{
  
    public function __construct()
	{
		parent::__construct();
	}


    public function check_reqNO($req_NO)
    {
        $sql = "SELECT trans_guid,refno,post_status,locto FROM backend.dc_req where refno='$req_NO'";
        $query = $this->db->query($sql);
        return $query;
        
    }

    public function LocTo($req_NO)
    {
        $sql = "SELECT LocTo FROM backend.dc_req WHERE RefNo = '$req_NO'";
        $query = $this->db->query($sql);
        return $query;
        
    }


    public function itemlist($dc_trans_guid)
    {
        $sql = "SELECT substring(description,1,30) as description,qty,qty_mobile FROM `dc_req_child` 
                where trans_guid='$dc_trans_guid' order by line";
        $query = $this->db->query($sql);
        return $query;
        
    }


    public function scan_item($barcode)
    {
        $sql = "SELECT a.`itemlink`,a.`itemcode`,a.description FROM backend.itemmaster a 
           INNER JOIN backend.itembarcode b ON a.`itemcode`=b.`itemcode` 
           where b.barcode='$barcode'";
        $query = $this->db->query($sql);
        return $query;
        
    }




    public function item_entry_add($sum_min, $dc_child_guid)
    {
        
         $sql = "UPDATE dc_req_child set qty_mobile=qty_mobile+('$sum_min'/packsize)
          where CHILD_GUID='$dc_child_guid'";
         $query = $this->db->query($sql);
         return $query;
        
    }
}
?>