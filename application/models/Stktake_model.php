<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stktake_model extends CI_Model
{
  
    public function __construct()
	{
		parent::__construct();
	}

    public function store_trans()
    {
        $location = $_SESSION['location'];
        /*$sql = "SELECT a.* FROM backend_stktake.stk_trans_location AS a
                INNER JOIN backend_stktake.`set_date` AS b
                ON a.trans_guid = b.trans_guid
                WHERE status_closed = '0' and a.location = '$location'";*/
        $sql = "SELECT TRANS_GUID FROM backend_stktake.set_date WHERE status_closed=0 ORDER BY created_at DESC LIMIT 1";        
        $query = $this->db->query($sql);
        return $query;
    }

    public function check_binID($bin_ID)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_stktake.set_bin WHERE BIN_NO='$bin_ID'";
        $query = $this->db->query($sql);
        return $query;
        
    }


    public function scan_item($barcode)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend.itembarcode WHERE barcode = '$barcode'";
        $query = $this->db->query($sql);
        return $query;
        
    }

    public function check_guid($barcode)
    {   
        $trans_guid = $_SESSION['trans_guid'];
        $bin_ID = $_SESSION['bin_ID'];
        /*$sql =  "SELECT * FROM backend.web_trans_c where web_guid = '$web_guid' and itemcode = '$itemcode'";*/
        $sql = "SELECT * FROM backend_stktake.stk_trans_c WHERE barcode IN 
                (SELECT barcode FROM itembarcode WHERE barcode = '$barcode')
                AND trans_guid = '$trans_guid' and bin_id = '$bin_ID'";
        $query = $this->db->query($sql);
        return $query;
    }

   public function itemresult_new($barcode)
    {

        $sql ="SELECT a.barcode,b.packsize,b.description,a.itemcode,b.itemlink,a.bardesc,a.barprice,b.sellingprice,b.lastcost
        /*, c.code as acc_code*/
        FROM backend.itembarcode AS a 
        INNER JOIN backend.itemmaster AS b 
        ON a.itemcode=b.itemcode 
     /*   INNER JOIN backend.itemmastersupcode AS c
        ON a.itemcode = c.itemcode*/
        WHERE a.barcode='$barcode'  

        GROUP BY b.itemlink";

        $query = $this->db->query($sql);
        return $query; 
    }

     public function itemQty($barcode)
    {
        $trans_guid = $_SESSION['trans_guid'];
        $bin_id = $_SESSION['bin_ID'];
        $sql = "SELECT qty, trans_guid, barcode, bin_id, itemcode FROM backend_stktake.stk_trans_c WHERE trans_guid = '$trans_guid' AND barcode = '$barcode' and bin_id = '$bin_id'";
        $query = $this->db->query($sql);
        return $query; 
    }

    public function deptsubdept($barcode)
    {
        $trans_guid = $_SESSION['trans_guid'];
        $bin_ID = $_SESSION['bin_ID'];
        $itemcode = $this->db->query("SELECT itemcode from backend.itembarcode where barcode = '$barcode' group by itemcode")->row('itemcode');

        $sql = "SELECT concat('Total Bin Qty by Itemcode - ', qty) as detail from backend_stktake.stk_trans where trans_guid = '$trans_guid' and  bin_id = '$bin_ID' and itemcode = '$itemcode'
        union all
        SELECT CONCAT(dept , ' - ', subdept, ' ',b.description ) AS detail FROM backend.itemmaster AS a
        INNER JOIN backend.itembarcode AS c
        ON a.itemcode = c.itemcode
        INNER JOIN backend.`subdept` AS b
        ON a.subdept = b.code
        WHERE c.barcode= '$barcode'";

        $query = $this->db->query($sql);

        return $query;
    }


    public function add_qty($barcode,$itemcode,$description,$itemlink,$totalqty)
    {

        $username = $_SESSION["user_ID"];
        $bin_id = $_SESSION["bin_ID"];
        $trans_guid = $_SESSION["trans_guid"];
        $_description = addslashes($description);

        $sql = "INSERT INTO backend_stktake.stk_trans_c 
        (TRANS_GUID,barcode, bin_id, itemcode, bardesc, itemlink,qty, created_at, created_by, updated_at, updated_by)
        VALUES
        ('$trans_guid', '$barcode', '$bin_id', '$itemcode', '$_description', '$itemlink', '$totalqty', NOW(), '$username', NOW(), '$username')"; 
       
        $query = $this->db->query($sql);
        return $query; 
    }

      public function add_stk_trans()
      {
        $username = $_SESSION["user_ID"];
        $bin_id = $_SESSION["bin_ID"];
        $trans_guid = $_SESSION["trans_guid"];

        $sql = "INSERT INTO backend_stktake.stk_trans 
        (trans_guid,bin_id,Itemcode,barcode,itemlink,qty,created_at,created_by,updated_at,updated_by)  
        (SELECT trans_guid,bin_id,Itemcode,barcode,itemlink,SUM(qty) AS qty,created_at,created_by,updated_at,updated_by 
        FROM backend_stktake.stk_trans_c  WHERE bin_id='$bin_id'  
        AND itemcode NOT IN  (SELECT itemcode FROM backend_stktake.stk_trans 
        WHERE bin_id='$bin_id'  
        AND trans_guid='$trans_guid' )
        AND trans_guid='$trans_guid' 
        GROUP BY bin_id,itemcode)"; 
       
        $query = $this->db->query($sql);
        return $query; 
      }



    public function edit_qty($barcode,$itemcode,$description,$itemlink,$totalqty)
    {

        $username = $_SESSION["user_ID"];
        $bin_id = $_SESSION["bin_ID"];
        $trans_guid = $_SESSION["trans_guid"];
        $_description = addslashes($description);

        $sql = "UPDATE backend_stktake.stk_trans_c 
        set qty = '$totalqty' , updated_at = now() , updated_by = '$username'
        where bin_id = '$bin_id' and barcode = '$barcode' and itemcode = '$itemcode' and trans_guid = '$trans_guid'";
       
        $query = $this->db->query($sql);
        return $query; 
    }

    public function edit_stk_trans()
    {
        $username = $_SESSION["user_ID"];
        $bin_id = $_SESSION["bin_ID"];
        $trans_guid = $_SESSION["trans_guid"];
        $sql = "UPDATE backend_stktake.stk_trans a 
        INNER JOIN (  SELECT bin_id,itemcode,SUM(qty) AS qty 
        FROM backend_stktake.stk_trans_c
        WHERE  bin_id='$bin_id'  AND trans_guid='$trans_guid'  
        GROUP BY itemcode) b 
        ON a.bin_id=b.bin_id AND a.itemcode=b.itemcode 
        SET a.qty=b.qty 
        WHERE   a.trans_guid='$trans_guid'  
        AND a.bin_id='$bin_id'";
        $query = $this->db->query($sql);
                return $query; 
    }

    public function update_stk_trans()
    {
        $username = $_SESSION["user_ID"];
        $bin_id = $_SESSION["bin_ID"];
        $trans_guid = $_SESSION["trans_guid"];

        $sql = "UPDATE backend_stktake.stk_trans a 
        INNER JOIN backend.itemmaster b  
        ON a.itemcode=b.itemcode 
        SET a.Description=b.Description,  a.Packsize=b.Packsize,a.UM=b.UM
        ,a.Costmargin=b.Costmargin,a.Costmarginvalue=b.Costmarginvalue
        ,a.SoldbyWeight=b.SoldbyWeight,a.WeightFactor=b.WeightFactor
        ,a.WeightPrice=b.WeightPrice,  a.Consign=b.Consign
        ,a.Dept=b.Dept,a.SubDept=b.SubDept,a.Category=b.Category
        ,a.AVerageCost=b.AverageCost,  a.LastCost=b.LastCost 
        WHERE  bin_id='$bin_id'  AND trans_guid='$trans_guid'";
       
        $query = $this->db->query($sql);
        return $query; 

    }

    public function updateitemmasterinfo($itemcode)
    {

        $trans_guid = $_SESSION["trans_guid"];

        $sql = "UPDATE backend_stktake.`stk_qoh` a
        INNER JOIN backend.itemmaster AS b
        ON a.itemcode = b.`Itemcode`
        SET a.itemlink =b.`ItemLink`
        , a.description = b.`Description` , a.consign = b.consign
        , a.um = b.`UM`
        , a.AVerageCost=b.AverageCost , a.LastCost=b.LastCost 
        , a.Costmargin=b.Costmargin,a.Costmarginvalue=b.Costmarginvalue
        , a.SoldbyWeight=b.SoldbyWeight,a.WeightFactor=b.WeightFactor
        , a.WeightPrice=b.WeightPrice, a.packsize = b.`PackSize`
        , a.Dept=b.Dept,a.SubDept=b.SubDept,a.Category=b.Category
        , a.itemtype = b.`ItemType` , a.manufacturer = b.`Manufacturer`
        , a.brand = b.`Brand` , a.not_in_sys = '0'
        WHERE  a.itemcode='$itemcode'  AND trans_guid='$trans_guid'";
       
        $query = $this->db->query($sql);
        return $query; 

    }

    public function bin_location($bin_ID)
    {
        $sql = "SELECT bin_no , location from backend_stktake.set_bin where bin_no = '$bin_ID'";
        $query  = $this->db->query($sql);
        return $query;
    }

    public function sublocation($bin_ID)
    {
        if ($_SESSION['bin_ID'] == '')
        {
            $bin_id = '';
        }
        else
        {
        $bin_id = $_SESSION['bin_ID'];
        }
        $sql = "SELECT sublocation FROM backend_warehouse.`set_sublocation` a 
        INNER JOIN backend_stktake.`set_bin` b 
        ON a.`location`=b.`Location` 
        WHERE b.`BIN_NO`='$bin_ID' 
        GROUP BY sublocation";
        $query  = $this->db->query($sql);
        return $query;
    }






}