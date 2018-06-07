<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sipick_model extends CI_Model
{
  
    public function __construct()
	{
		parent::__construct();
	}


    public function check_reqNO($req_NO)
    {
        $sql = "SELECT refno, billstatus FROM backend.somain where refno='$req_NO'";
        $query = $this->db->query($sql);
        return $query;
        
    }

    public function LocTo($req_NO)
    {
        $sql = "SELECT * FROM backend.somain WHERE RefNo = '$req_NO'";
        $query = $this->db->query($sql);
        return $query;
        
    }


    public function itemlist($req_NO)
    {
        $sql = "SELECT substring(description,1,30) as description,qty,qty_mobile FROM `sochild` 
                where refno='$req_NO' order by line";
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

   public function item_entry_add($qty_mobile)
    {

        $sql = "UPDATE sochild SET qty_mobile='$qty_mobile' WHERE refno='".$_SESSION['si_refno']."'
        AND line='".$_SESSION['si_line']."'";
        $query = $this->db->query($sql);
       //  echo $this->db->last_query();die;
        return $query;
        
    }
}
?>