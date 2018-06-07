<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class simplepo_model extends CI_Model
{
  
    public function __construct()
	{
		parent::__construct();
	}

    public function add_qty($itemcode, $description, $code, $name, $iqty, $ppurchase, $barprice, $barcode)
    {
        $_description = addslashes($description);
        $name = addslashes($name);
        $sql = "INSERT INTO backend.mobile_po (po_guid, converted, converted_docno, itemcode, description, sup_code, sup_name, qty_order, price_purchase, price_sell, barcode, created_at, created_by)
VALUES (REPLACE(UPPER(UUID()),'-',''), '0', '', '$itemcode', '$_description', '$code','$name', '$iqty', '$ppurchase', '$barprice', '$barcode', NOW(), '')"; 
        $query = $this->db->query($sql);
        return $query; 
    }


}
?>