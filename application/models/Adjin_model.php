<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class adjin_model extends CI_Model
{
  
    public function __construct()
	{
		parent::__construct();
	}

	public function main()
	{
		$sql = "SELECT a.*,CONCAT('$ ',FORMAT(bill_amt,2)) AS bill_amt_format FROM web_trans a WHERE 
				module_desc='Adjust-In'
				AND posted=0 AND cancel=0 ORDER BY created_at DESC";
		$query = $this->db->query($sql);
        return $query;
	}


	public function itemlist($web_guid)
	{
		$sql = "SELECT IF(b.item_guid IS NOT NULL ,'BATCH','QTY') AS scan_type,b.scan_guid,b.item_guid,a.*    FROM (SELECT a.*, b.`module_desc`,b.acc_name FROM backend.web_trans_c a INNER JOIN backend.web_trans b ON a.web_guid=b.web_guid 
        WHERE a.web_guid='$web_guid' ORDER BY created_at DESC) a
LEFT JOIN (SELECT * FROM backend_warehouse.`d_batch_scan_log` a WHERE a.`type` = 'Adjust-In')b ON a.itemcode = b.scan_itemcode 
GROUP BY a.itemcode ORDER BY a.created_at DESC";
		$query = $this->db->query($sql);
        return $query;
	}

    public function item_in_so_header($web_guid)
    {
        //data is retrive from this query
        $sql = "SELECT a.*,
        CONCAT('$' ,FORMAT(bill_amt,2)) AS bill_amt_format 
        FROM backend.web_trans a  WHERE web_guid='$web_guid'";
        $query = $this->db->query($sql);
        return $query; 
    }

	public function edit_item($web_guid, $itemcode)
	{
		$sql = "SELECT * FROM web_trans_c WHERE web_guid = '$web_guid' AND itemcode='$itemcode'";
		$query = $this->db->query($sql);
        return $query;
	}


	public function add_process($remarks, $reason)
	{
		$location = $_SESSION['location'];
		$username = $_SESSION["username"];
        $remarks = addslashes($remarks);
		$sql = "INSERT INTO backend.web_trans (web_guid, module_desc, remarks, reason, location, loc_group, created_at, created_by)
		VALUES ( REPLACE(UPPER(UUID()),'-',''), 'Adjust-In', '$remarks', '$reason', '$location', '$location', NOW(), '$username' )";
		$query = $this->db->query($sql);
        return $query;
	}

	public function store_trans()
	{
		$web_guid = $_REQUEST['web_guid'];
		$sql = "select web_guid from web_trans where web_guid = '$web_guid' and module_desc ='Adjust-In'";
		$query = $this->db->query($sql);
        return $query;

	}

	public function check_guid($barcode)
	{	
		$web_guid = $_SESSION['web_guid'];
		/*$sql =  "SELECT * FROM backend.web_trans_c where web_guid = '$web_guid' and itemcode = '$itemcode'";*/
        $sql = "SELECT * FROM web_trans_c WHERE itemcode IN 
                (SELECT itemcode FROM itembarcode WHERE barcode = '$barcode')
                AND web_guid = '$web_guid'";
		$query = $this->db->query($sql);
        return $query;
	}

		public function check_guid_item($itemcode)
	{	
		$web_guid = $_SESSION['web_guid'];
		$sql =  "SELECT * FROM backend.web_trans_c where web_guid = '$web_guid' and itemcode = '$itemcode'";
		$query = $this->db->query($sql);
        return $query;
	}

	public function itemresult_new($barcode)
    {

        $sql ="SELECT a.barcode,b.packsize,b.description,a.itemcode,b.itemlink,a.bardesc,a.barprice,b.sellingprice,b.lastcost
        FROM backend.itembarcode AS a 
        INNER JOIN backend.itemmaster AS b 
        ON a.itemcode=b.itemcode 
        WHERE a.barcode='$barcode'  
        GROUP BY b.itemlink";

        $query = $this->db->query($sql);
        return $query; 
    }

     public function itemQty($itemcode)
    {
        $web_guid = $_SESSION['web_guid'];
        $sql = "SELECT a.qty, b.acc_name, a.web_c_guid FROM backend.web_trans_c a INNER JOIN backend.web_trans b ON a.web_guid=b.web_guid 
        WHERE a.web_guid='$web_guid' AND a.itemcode = '$itemcode'
        order by a.created_at desc
        limit 1";
        $query = $this->db->query($sql);
        return $query; 
    }

     public function itemQOH($itemcode)
    {

        $sql = "SELECT SUM(b.onhandqty) as SinglePackQOH FROM backend.itemmaster a
        INNER JOIN backend.itemmaster b ON a.ItemLink=b.ItemLink WHERE a.itemcode='$itemcode'";
        $query = $this->db->query($sql);
        return $query; 
    }



    public function add_qty($web_c_guid,$web_guid,$itemcode,$description,$sellingprice,$barcode,$SinglePackQOH,$remark,$totalqty,$_amount)
    {

        $username = $_SESSION["username"];
        $web_guid = $_SESSION['web_guid'];
        $_description = addslashes($description);
        $remark = addslashes($remark);
// changed
        $sql = "INSERT INTO backend.web_trans_c (web_c_guid,web_guid,itemcode,description,price,barcode,qoh,barcode_actual,
        SoldbyWeight,Qty,amount,Created_at,Created_by,Updated_at,Updated_by,remark_c)
        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$web_guid', '$itemcode', '$_description', '$sellingprice', '$barcode', '$SinglePackQOH', '', '', '$totalqty', '$_amount', NOW(), '$username', now(), '$username' ,'$remark')"; 
       
        $query = $this->db->query($sql);
        return $query; 
    }


     public function edit_qty($web_c_guid,$web_guid,$itemcode,$description,$sellingprice,$barcode,$SinglePackQOH,$remark,$totalqty,$_amount)
    {

        $username = $_SESSION["username"];
        $web_guid = $_SESSION['web_guid'];
        $_description = addslashes($description);
        $remark = addslashes($remark);

        $sql = "UPDATE backend.web_trans_c 
				SET 
				-- web_c_guid = REPLACE(UPPER(UUID()),'-','')
				/*web_c_guid = '$web_c_guid'
				,web_guid = '$web_guid'*/
				-- ,
                itemcode = '$itemcode'
				,description = '$_description'
				,price = '$sellingprice'
				
				,barcode = '$barcode'
				,qoh = '$SinglePackQOH'
				,barcode_actual = ''
				,SoldbyWeight = ''
				,Qty = '$totalqty'
				,amount = '$_amount'
				,Updated_at = NOW()
				,Updated_by = '$username'
				,remark_c = '$remark'
				WHERE web_c_guid = '$web_c_guid' and itemcode = '$itemcode' and web_guid = '$web_guid'"; 
       
        $query = $this->db->query($sql);
        return $query; 
    }




     public function edit_itemqty($web_c_guid)
    {
        //$username = $_SESSION["username"];
        $sql = "SELECT * FROM backend.web_trans_c WHERE web_c_guid = '$web_c_guid'"; 
       
        $query = $this->db->query($sql);
        return $query; 
    }


}
?>