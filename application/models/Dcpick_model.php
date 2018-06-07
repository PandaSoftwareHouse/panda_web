<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dcpick_model extends CI_Model
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
        $sql = "SELECT IF(b.item_guid IS NOT NULL ,'BATCH','QTY') AS scan_type,b.`item_guid`,b.`type`, a.*  
FROM (SELECT SUBSTRING(description,1,30) AS description,qty,qty_mobile,a.`Itemcode`,a.`line`,a.`CHILD_GUID`, a.reason
FROM backend.dc_req_child a WHERE trans_guid='$dc_trans_guid' ORDER BY line)a 
LEFT JOIN backend_warehouse.`d_batch_scan_log` b ON a.`Itemcode` = b.`scan_itemcode` 
GROUP BY a.Itemcode ORDER BY a.line";
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




    public function item_entry_add($sum_min, $dc_child_guid, $reason_input)
    {
        
         $sql = "UPDATE dc_req_child set qty_mobile=qty_mobile+('$sum_min'/packsize), reason='$reason_input' where CHILD_GUID='$dc_child_guid'";
         $query = $this->db->query($sql);
         return $query;
        
    }
}
?>