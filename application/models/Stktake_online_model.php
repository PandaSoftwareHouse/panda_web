<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class stktake_online_model extends CI_Model
{
  
    public function __construct()
    {
        parent::__construct();
    }


    public function scan_item($barcode)
    {
        //data is retrive from this query
        $sql = "SELECT a.itemlink,a.packsize,a.itemcode,a.description,b.barcode 
        FROM backend.itemmaster a INNER JOIN backend.itembarcode b ON a.itemcode=b.itemcode 
        WHERE b.barcode='$barcode'";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
        
    }


    public function scan_itemlink($itemlink)
    {
        $location = $_SESSION['location'];
        //data is retrive from this query
        $sql = "SELECT * FROM backend.stk_take_online WHERE POSTED=0 
        AND ITEMLINK='$itemlink' AND LOCATION='$location' AND BIZDATE= CURDATE()";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
        
    }

    public function check_qoh($itemlink)
    {
        $location = $_SESSION['location'];
        //data is retrive from this query
        $sql = "SELECT b.itemlink,IF(SUM(a.OnHandQty*b.packsize) IS NULL,0,ROUND(SUM(a.OnHandQty*b.packsize),3)) AS OnHandStock FROM locationstock a INNER JOIN itemmaster b ON a.itemcode=b.itemcode 
            WHERE b.itemlink = '$itemlink' AND a.location= '$location' GROUP BY b.itemlink;";
        $query = $this->db->query($sql);
        return $query;
    }

    public function check_qty_actual($itemlink)
    {
        $location = $_SESSION['location'];
        //data is retrive from this query
        $sql = "SELECT SUM(QTY_ACTUAL*PACKSIZE) AS QTY_ACTUAL FROM stk_take_online WHERE itemlink = '$itemlink' 
            AND location= '$location' AND BIZDATE= CURDATE() GROUP BY itemlink";
        $query = $this->db->query($sql);
        return $query;
    }

    public function itemlink_list($itemlink)
    {
        $location = $_SESSION['location'];
        //data is retrive from this query
        $sql = "SELECT TRANS_GUID,a.ITEMCODE,a.ITEMLINK,a.PACKSIZE,a.DESCRIPTION, b.price_include_tax,QTY_CURR,QTY_ACTUAL,QTY_DIFF 
        FROM backend.stk_take_online as a inner join backend.itemmaster as b on a.itemcode = b.itemcode WHERE POSTED=0 AND a.ITEMLINK = '$itemlink'
        AND LOCATION= '$location' AND BIZDATE= CURDATE() ORDER BY a.PACKSIZE";
        $query = $this->db->query($sql);
        return $query;
    }

    function itemlink_create_insert($data)
    {
        $this->db->insert('stk_take_online', $data);

    }

    function update_item($data, $trans_guid)
    {
        $this->db->where('TRANS_GUID', $trans_guid);
        $this->db->update('stk_take_online', $data);
    }

    
}
?>