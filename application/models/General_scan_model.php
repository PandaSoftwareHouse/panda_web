<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class general_scan_model extends CI_Model
{
  
    public function __construct()
	{
		parent::__construct();
	}

	public function check_guid($barcode)
	{	
		$web_guid = $_SESSION['web_guid'];
		/*$sql =  "SELECT * FROM backend.web_trans_c where web_guid = '$web_guid' and itemcode = '$itemcode'";*/
        $sql = "SELECT * FROM web_trans_c AS a
        INNER JOIN web_trans AS b
        ON a.`web_guid` = b.`web_guid`
        WHERE itemcode IN (SELECT itemcode FROM itembarcode WHERE barcode = '$barcode')
        AND a.web_guid = '$web_guid'";
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


    public function checkModule($web_guid)
    {
        $sql = "SELECT module_desc from backend.web_trans where web_guid = '$web_guid'";
        $query = $this->db->query($sql);
        return $query;

    }

      public function check_itemcode($barcode)
    {
        $sql = "SELECT itemcode from backend.itembarcode where barcode = '$barcode'";
        $query = $this->db->query($sql);
        return $query;

    }

     public function check_supplier($itemcode,$acc_code)
    {
        //scan itemcode for supcus
        $sql = "SELECT * FROM backend.itemmastersupcode WHERE CODE='$acc_code' AND Itemcode='$itemcode'";
        $query = $this->db->query($sql);
        return $query; 
    }

    public function check_acc()
    {
        $web_guid = $_SESSION['web_guid'];
        $sql = "SELECT * FROM backend.web_trans where web_guid = '$web_guid'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function check_decode($module)
    {
        $sql = "SELECT 
                c.weight_type_code               
                ,c.weight_capture_price          
                ,c.weight_bar_pos_start           
                ,c.weight_bar_pos_count           
                ,c.weight_capture_factor        
                ,c.weight_capture_weight         
                ,c.weight_capture_pos_start      
                ,c.weight_capture_pos_count       
                ,c.weight_capture_weight_type     
                ,c.weight_capture_price_factor    
                ,c.weight_capture_price_pos_start 
                ,c.weight_capture_price_pos_count 
                FROM `set_weight_type_by_module` a INNER JOIN 
                `set_weight_type_by_module_c` b ON a.`module_guid`=b.`module_guid` 
                INNER JOIN `set_weight_parameter` c ON c.weight_guid=b.`weight_guid` 
                WHERE b.as_default=1 AND a.module_desc ='$module'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function check_itemmaster_all($barcode)
    {
        $sql = "SELECT barcodetype, sellingprice,soldbyweight FROM backend.itemmaster as a inner join backend.itembarcode as b on a.itemcode = b.itemcode where barcode = '$barcode' limit 1";
        $query = $this->db->query($sql);
        return $query;
    }

      public function check_itemmaster_18D($barcode)
    {
        $sql = "SELECT barcodetype, sellingprice,soldbyweight FROM backend.itemmaster as a inner join backend.itembarcode as b on a.itemcode = b.itemcode where barcode = left('$barcode', 7) limit 1";
        $query = $this->db->query($sql);
        return $query;
    }

        public function reloadmodel($web_guid)
    {
        $sql = "SELECT * FROM web_trans WHERE web_guid = '$web_guid' ";  
        $query = $this->db->query($sql);
        // echo $this->db->last_query();die;
        return $query;        
    }

    public function reloadbillamt($web_guid)
    {

    $sql = "UPDATE backend.web_trans SET bill_amt  = (SELECT SUM(amount) FROM backend.`web_trans_c` WHERE web_guid = '$web_guid')
WHERE web_guid = '$web_guid'";
       $query = $this->db->query($sql);
        // echo $this->db->last_query();die;
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

    public function itemQOH($itemcode)
    {
        $sql = "SELECT SUM(b.onhandqty) as SinglePackQOH FROM backend.itemmaster a
        INNER JOIN backend.itemmaster b ON a.ItemLink=b.ItemLink WHERE a.itemcode='$itemcode'";
        $query = $this->db->query($sql);
        return $query; 
    }

         public function itemQty($itemcode)
    {
        $web_guid = $_SESSION['web_guid'];
        $sql = "SELECT a.qty, b.acc_name, a.web_c_guid FROM backend.web_trans_c a INNER JOIN backend.web_trans b ON a.web_guid=b.web_guid 
        WHERE a.web_guid='$web_guid' AND a.itemcode = '$itemcode'
        order by a.created_at desc";
        $query = $this->db->query($sql);
        return $query; 
    }

     public function edit_itemqty($web_c_guid)
    {
        $sql = "SELECT * FROM backend.web_trans_c WHERE web_c_guid = '$web_c_guid'"; 
       
        $query = $this->db->query($sql);
        return $query; 
    }


     public function delete_item($web_c_guid)
    {
        $sql = "DELETE FROM backend.web_trans_c where web_c_guid = '$web_c_guid'";
       $query = $this->db->query($sql);
        // echo $this->db->last_query();die;
        return $query;  
    }

     public function insertsysrun()
    {
        $sql = "INSERT INTO sysrun (TYPE,CODE,CurrentNo,NoDigit,YYYY,MM,Remarks) (SELECT 'PLATFORM','PLT',0,4,YEAR(NOW()),MONTH(NOW()),'Panda Platform')";
        $query = $this->db->query($sql);
        return $query;

    }

    public function updatesysrun()
    {
        $sql = "UPDATE sysrun set YYYY=Year(Now()),MM=Month(Now()),CurrentNo=0 where type='PLATFORM'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function updaterunningnum()
    {
        $sql = "UPDATE sysrun set CurrentNo=CurrentNo+1 where type='PLATFORM'";
        $query = $this->db->query($sql);
        return $query;    
    }




}
?>