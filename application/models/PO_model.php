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
        WHERE `name` LIKE '%$supname%' AND `type`= 'S' and mobile_po ='1' ORDER BY NAME LIMIT 100";
        $query = $this->db->query($sql);
        return $query;
        
    }


    public function add_trans($supcode, $supname)
    {
        $username = $_SESSION["username"];
        $location = $_SESSION["location"];
        $_supname = addslashes($supname);
        $sql = "INSERT INTO backend.web_trans (web_guid, remarks, module_desc,acc_code,acc_name,location,loc_group,created_at,created_by,updated_at,updated_by)
        VALUES ( REPLACE(UPPER(UUID()),'-',''), '', 'PO','$supcode','$_supname','$location','$location',NOW(),'$username',NOW(),'$username')";
        $query = $this->db->query($sql);
        return $query; 
    }


    public function item_in_po($web_guid)
    {
        
         // $sql = "SELECT a.web_c_guid, a.web_guid, itemcode, description, price, a.qty AS qty,amount,barcode,barcode_actual,soldbyweight,a.created_at,b.created_by,a.updated_at,a.updated_by, 
         //     remark_c,qoh,sup_code,price_fixed,cross_refno,qty_foc AS qty_foc , b.acc_name 
         //     FROM backend.web_trans_c a 
         //     INNER JOIN backend.web_trans b 
         //     ON a.web_guid=b.web_guid 
         //     WHERE a.web_guid='$web_guid' ORDER BY b.created_at DESC";
        $sql = "SELECT IF(b.item_guid IS NOT NULL ,'BATCH','QTY') AS scan_type,b.scan_guid,b.item_guid,a.*    
FROM (SELECT b.`module_desc`,a.web_c_guid, a.web_guid, itemcode, description, price, a.qty AS qty,amount,barcode,barcode_actual,soldbyweight,a.created_at,b.created_by,a.updated_at,a.updated_by, 
             remark_c,qoh,sup_code,price_fixed,cross_refno,qty_foc AS qty_foc , b.acc_name 
             FROM backend.web_trans_c a 
             INNER JOIN backend.web_trans b 
             ON a.web_guid=b.web_guid 
             WHERE a.web_guid='$web_guid' ORDER BY b.created_at DESC) a
LEFT JOIN (SELECT * FROM backend_warehouse.`d_batch_scan_log` a WHERE a.`type` = 'PO')b ON a.itemcode = b.scan_itemcode 
GROUP BY a.itemcode ORDER BY a.created_at DESC";
       
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


    public function itemresult($barcode,$web_c_guid)
    {

        $sql ="SELECT a.barcode,b.packsize,b.description,a.itemcode,b.itemlink,a.bardesc,a.barprice,b.sellingprice,b.lastcost, IFNULL(d.qty,0) AS qty, c.code as acc_code, d.web_c_guid
        FROM backend.itembarcode AS a 
        INNER JOIN backend.itemmaster AS b 
        ON a.itemcode=b.itemcode 
        INNER JOIN backend.itemmastersupcode AS c
        ON a.itemcode = c.itemcode
        LEFT JOIN (SELECT * FROM backend.web_trans_c WHERE  web_c_guid = '$web_c_guid') AS d
        ON a.itemcode = d.itemcode AND a.`Barcode` =  d.`barcode` 
        WHERE a.barcode='$barcode'  

        GROUP BY b.itemlink";

        $query = $this->db->query($sql);
        return $query; 
    }

        public function itemresult_new($barcode)
    {

        $sql ="SELECT a.barcode,b.packsize,b.description,a.itemcode,b.itemlink,a.bardesc,a.barprice,b.sellingprice,b.lastcost, b.soldbyweight,
        c.code as acc_code
        FROM backend.itembarcode AS a 
        INNER JOIN backend.itemmaster AS b 
        ON a.itemcode=b.itemcode 
        INNER JOIN backend.itemmastersupcode AS c
        ON a.itemcode = c.itemcode
        WHERE a.barcode='$barcode'  

        GROUP BY b.itemlink";

        $query = $this->db->query($sql);
        return $query; 
    }

        public function itemresult_po($barcode, $check_itemmastersupcode)
    {

         $acc_code = $_SESSION['acc_code'];
        if($check_itemmastersupcode == 'false')
        {
        $sql ="SELECT a.barcode,b.packsize,b.description,a.itemcode,b.itemlink,a.bardesc,a.barprice,b.sellingprice,b.lastcost, b.soldbyweight , '$acc_code' as acc_code
        FROM backend.itembarcode AS a 
        INNER JOIN backend.itemmaster AS b 
        ON a.itemcode=b.itemcode 
        WHERE a.barcode='$barcode'  
        GROUP BY b.itemlink";
        }
        else
        {
            $sql ="SELECT a.barcode,b.packsize,b.description,a.itemcode,b.itemlink,a.bardesc,a.barprice,b.sellingprice,b.lastcost, b.soldbyweight,
        c.code as acc_code
        FROM backend.itembarcode AS a 
        INNER JOIN backend.itemmaster AS b 
        ON a.itemcode=b.itemcode 
        INNER JOIN backend.itemmastersupcode AS c
        ON a.itemcode = c.itemcode
        WHERE a.barcode='$barcode'  

        GROUP BY b.itemlink";
        }
        $query = $this->db->query($sql);
        return $query; 
    }



    public function itemQty($barcode, $web_guid)
    {
        
        $sql = "SELECT a.qty, b.acc_name, a.web_c_guid FROM backend.web_trans_c a INNER JOIN backend.web_trans b ON a.web_guid=b.web_guid 
        WHERE a.web_guid='$web_guid' AND a.barcode = '$barcode'
        order by a.created_at desc
        limit 1";
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


    public function itemQOH($itemcode1)
    {
        //qoh result using itemcode
        /*$sql = "SELECT IF(SUM(IF(b.OnHandQty IS NULL,0,b.OnHandQty)*a.`PackSize`) IS NULL,0,
        SUM(IF(b.OnHandQty IS NULL,0,b.OnHandQty)*a.`PackSize`)) AS SinglePackQOH
        FROM (SELECT b.itemlink,b.`Itemcode`,b.`PackSize` FROM backend.itemmaster a
        INNER JOIN backend.itemmaster b ON a.`ItemLink`=b.`ItemLink` WHERE a.itemcode='$itemcode') a 
        INNER JOIN backend.locationstock b ON b.`Itemcode`=a.itemcode";*/
        $sql = "SELECT SUM(b.onhandqty) as SinglePackQOH FROM backend.itemmaster a
        INNER JOIN backend.itemmaster b ON a.ItemLink=b.ItemLink WHERE a.itemcode='$itemcode1'";
        $query = $this->db->query($sql);
        return $query; 
    }



    public function add_qty($web_c_guid,$web_guid,$itemcode,$description,$sellingprice,$foc_qty,$barcode,$SinglePackQOH,$remark,$totalqty,$_amount,$soldbyweight)
    {
        //scan itemcode on web_trans_c
       /* $sql = "INSERT INTO backend.web_trans_c (web_c_guid,web_guid,itemcode,description,price,qty_foc,barcode,qoh,barcode_actual,
        SoldbyWeight,Qty,amount,Created_at,Created_by,Updated_at,Updated_by,remark_c)
        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$web_guid', '$itemcode', '$description', '$sellingprice',
            '$foc_qty', '$barcode', '$SinglePackQOH', '', '', '$qty', '$remark')";*/
        $username = $_SESSION["username"];
        $_description = addslashes($description);
// changed
        $sql = "INSERT INTO backend.web_trans_c (web_c_guid,web_guid,itemcode,description,price,qty_foc,barcode,qoh,barcode_actual,
        SoldbyWeight,Qty,amount,Created_at,Created_by,Updated_at,Updated_by,remark_c)
        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$web_guid', '$itemcode', '$_description', '$sellingprice',
            '$foc_qty', '$barcode', '$SinglePackQOH', '', '$soldbyweight', '$totalqty', '$_amount', NOW(), '$username', now(), '$username' ,'$remark')"; 
       
        $query = $this->db->query($sql);
        return $query; 
    }


     public function update_qty($web_c_guid,$itemcode,$description,$sellingprice,$foc_qty,$barcode,$SinglePackQOH,$remark,$totalqty,$_amount)
    {
        //scan itemcode on web_trans_c
       /* $sql = "INSERT INTO backend.web_trans_c (web_c_guid,web_guid,itemcode,description,price,qty_foc,barcode,qoh,barcode_actual,
        SoldbyWeight,Qty,amount,Created_at,Created_by,Updated_at,Updated_by,remark_c)
        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$web_guid', '$itemcode', '$description', '$sellingprice',
            '$foc_qty', '$barcode', '$SinglePackQOH', '', '', '$qty', '$remark')";*/
        $username = $_SESSION["username"];
        $_description = addslashes($description);

        $sql = "UPDATE backend.web_trans_c 
SET 
web_c_guid = '$web_c_guid'
,itemcode = '$itemcode'
,description = '$_description'
,price = '$sellingprice'
,qty_foc = '$foc_qty'
,barcode = '$barcode'
,qoh = '$SinglePackQOH'
,barcode_actual = ''
,SoldbyWeight = ''
,Qty = '$totalqty'
,amount = '$_amount'
,Updated_at = NOW()
,Updated_by = '$username'
,remark_c = '$remark'
WHERE web_c_guid = '$web_c_guid'"; 
       
        $query = $this->db->query($sql);
        return $query; 
    }


    public function edit_qty($web_c_guid,$itemcode,$description,$sellingprice,$foc_qty,$barcode,$SinglePackQOH,$qty,$remark)
    {
        $username = $_SESSION["username"];
        $_description = addslashes($description);
        $_amount = $qty*$sellingprice;
        $sql = "REPLACE INTO backend.web_trans_c (web_c_guid,itemcode,description,price,qty_foc,barcode,qoh,barcode_actual,
        SoldbyWeight,Qty,amount,Created_at,Created_by,Updated_at,Updated_by,remark_c)
        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$itemcode', '$_description', '$sellingprice',
            '$foc_qty', '$barcode', '$SinglePackQOH', '', '', '$qty', '$_amount', NOW(), '$username', now(), '$username' ,'$remark')"; 
       
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

    public function reloadmodel($web_guid)
    {
        $sql = "SELECT * FROM backend.web_trans WHERE web_guid = '$web_guid' ";  
        $query = $this->db->query($sql);
        // echo $this->db->last_query();die;
        return $query;        
    }

     public function checkguid($web_guid,$barcode)
    {
        $sql = "SELECT * FROM web_trans_c WHERE barcode = '$barcode' AND web_guid = '$web_guid' ";  
        $query = $this->db->query($sql);
        // echo $this->db->last_query();die;
        return $query;        
    }

    public function delete($web_guid)
    {   
        $sql = "DELETE FROM backend.web_trans_c where web_guid = '$web_guid'";
        $sql = "DELETE FROM backend.web_trans where web_guid = '$web_guid'";
       $query = $this->db->query($sql);
        // echo $this->db->last_query();die;
        return $query;  
    }

    

    public function reloadbillamt($web_guid)
    {
        $sql = "UPDATE backend.web_trans SET bill_amt  = (SELECT IFNULL(SUM(amount),0)  FROM backend.`web_trans_c` AS a
INNER JOIN 
(SELECT  itemcode,MAX(a.created_at) AS max_created
FROM backend.`web_trans_c` AS a
WHERE a.web_guid = '$web_guid'
GROUP BY itemcode
) b
ON a.created_at = b.max_created
ORDER BY created_at DESC)
WHERE web_guid = '$web_guid'";
       $query = $this->db->query($sql);
        // echo $this->db->last_query();die;
        return $query;  
    }

      public function delete_item($web_c_guid)
    {
        $sql = "DELETE FROM backend.web_trans_c where web_c_guid = '$web_c_guid'";
       $query = $this->db->query($sql);
        // echo $this->db->last_query();die;
        return $query;  
    }




}
?>