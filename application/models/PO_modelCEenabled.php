<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PO_model extends CI_Model
{
  
    public function __construct()
	{
		parent::__construct();
	}

	public function main()
    {

        $sql = "SELECT a.*, CONCAT ('$',FORMAT(bill_amt,2)) AS bill_amt_format FROM backend.web_trans a WHERE 
		module_desc= 'PO' AND posted=0 AND cancel=0 ORDER BY created_at DESC";
        $query = $this->db->query($sql);
        return $query;
        
    }


    public function search_result($supname)
    {

        $sql = "SELECT CODE,NAME,CONCAT(NAME,' ->(',CODE,')') AS dname FROM backend.supcus 
        WHERE `name` LIKE '%$supname%' AND `type`= 'S' ORDER BY NAME LIMIT 100";
        $query = $this->db->query($sql);
        return $query;
        
    }


    public function add_trans($supcode, $supname)
    {
        $username = $_SESSION["username"];
        $location = $_SESSION["location"];
        $sql = "INSERT INTO backend.web_trans (web_guid, remarks, module_desc,acc_code,acc_name,location,loc_group,created_at,created_by,updated_at,updated_by)
        VALUES ( REPLACE(UPPER(UUID()),'-',''), '', 'PO','$supcode','$supname','$location','$location',NOW(),'$username',NOW(),'$username')";
        $query = $this->db->query($sql);
        return $query; 
    }


    public function item_in_po($web_guid)
    {
        
        $sql = "SELECT a.*, b.acc_name FROM backend.web_trans_c a INNER JOIN backend.web_trans b ON a.web_guid=b.web_guid 
        WHERE a.web_guid='$web_guid' ORDER BY created_at DESC";
        $query = $this->db->query($sql);
        return $query; 
    }


    public function item_in_po_header($web_guid)
    {
        
        $sql = "SELECT b.*,a.*, CONCAT('$' ,FORMAT(bill_amt,2)) AS bill_amt_format FROM backend.web_trans a 
        INNER JOIN backend.supcus b ON a.acc_code = b.Code WHERE web_guid='$web_guid'";
        $query = $this->db->query($sql);
        return $query; 
    }


    public function itemresult($barcode)
    {
        //scan all item
        $sql = "SELECT a.barcode,b.packsize,b.description,a.itemcode,a.bardesc,a.barprice,b.sellingprice,b.lastcost 
        FROM backend.itembarcode a INNER JOIN backend.itemmaster b ON a.itemcode=b.itemcode 
        WHERE a.barcode='$barcode'";
        $query = $this->db->query($sql);
        return $query; 
    }


    public function itemQty($barcode, $web_guid)
    {
        
        $sql = "SELECT a.qty, b.acc_name FROM backend.web_trans_c a INNER JOIN backend.web_trans b ON a.web_guid=b.web_guid 
        WHERE a.web_guid='$web_guid' AND a.barcode = '$barcode'";
        $query = $this->db->query($sql);
        return $query; 
    }


    public function itemresultSupCus($itemcode, $acc_code)
    {
        //scan itemcode for supcus
        $sql = "SELECT * FROM backend.itemmastersupcode WHERE CODE='$acc_code' AND Itemcode='$itemcode'";
        $query = $this->db->query($sql);
        return $query; 
    }


    public function itemQOH($itemcode)
    {
        //qoh result using itemcode
        $sql = "SELECT IF(SUM(IF(b.OnHandQty IS NULL,0,b.OnHandQty)*a.`PackSize`) IS NULL,0,
        SUM(IF(b.OnHandQty IS NULL,0,b.OnHandQty)*a.`PackSize`)) AS SinglePackQOH
        FROM (SELECT b.itemlink,b.`Itemcode`,a.`PackSize` FROM backend.itemmaster a
        INNER JOIN backend.itemmaster b ON a.`ItemLink`=b.`ItemLink` WHERE a.itemcode='$itemcode') a 
        INNER JOIN backend.locationstock b ON b.`Itemcode`=a.itemcode";
        $query = $this->db->query($sql);
        return $query; 
    }



    public function add_qty($web_guid,$itemcode,$description,$sellingprice,$foc_qty,$barcode,$SinglePackQOH,$qty,$remark)
    {
        //scan itemcode on web_trans_c
        $sql = "INSERT INTO backend.web_trans_c (web_c_guid,web_guid,itemcode,description,price,qty_foc,barcode,qoh,barcode_actual,
        SoldbyWeight,Qty,amount,Created_at,Created_by,Updated_at,Updated_by,remark_c)
        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$web_guid', '$itemcode', '$description', '$sellingprice',
            '$foc_qty', '$barcode', '$SinglePackQOH', '', '', '$qty', '$remark')";
        $query = $this->db->query($sql);
        return $query; 
    }

}
?>