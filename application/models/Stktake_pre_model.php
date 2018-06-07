<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class stktake_pre_model extends CI_Model
{
    public $table = 'backend_stktake.stk_trans_prelisting';
    public $table_batch = 'backend_stktake.stk_trans_prelisting_batch';
  
    public function __construct()
	{
		parent::__construct();
	}


    public function pre_item()
    {
        //data is retrive from this query
        $sql = "SELECT BIN_ID FROM backend_stktake.stk_trans_prelisting WHERE exported=0 GROUP BY BIN_ID ";
        $query = $this->db->query($sql);
        return $query;
        
    }

    public function pre_batch()
    {
        //data is retrive from this query
        $sql = "SELECT BIN_ID from backend_stktake.stk_trans_prelisting_batch where exported=0 group by BIN_ID";
        $query = $this->db->query($sql);
        return $query;
    }

    public function check_binID($bin_ID)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_stktake.set_bin WHERE bin_no='$bin_ID'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function last_scan($bin_ID)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_stktake.stk_trans_prelisting WHERE exported=0 AND BIN_ID = '$bin_ID' ORDER BY created_at DESC LIMIT 3";
        $query = $this->db->query($sql);
        return $query;
    }

    public function check_weightItem($barcode)
    {
        //Check whether is sold by weight item or not
        $sql = "SELECT a.* FROM backend.itembarcode a INNER JOIN backend.itemmaster b ON a.itemcode=b.itemcode WHERE 
        b.soldbyweight=1 AND a.barcode='$barcode'";
        $query = $this->db->query($sql);
        return $query;
    }


    public function pre_itemEdit($barcode)
    {
        //Item scan result
        $sql = "SELECT a.itemcode,a.BarDesc,a.barcode from backend.itembarcode a inner join backend.itemmaster b 
        on a.itemcode=b.itemcode where barcode='$barcode'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function pre_itemEdit2($itemcode)
    {
        $bin_ID = $_SESSION['bin_ID'];
        //Item scan result with qty added
        $sql = "SELECT * FROM backend_stktake.stk_trans_prelisting WHERE exported=0 and 
        BIN_ID='$bin_ID' and Itemcode = '$itemcode' ";
        $query = $this->db->query($sql);
        return $query;
    }


    public function pre_itemlist($bin_ID)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_stktake.stk_trans_prelisting WHERE exported=0 AND BIN_ID='$bin_ID' order by Description , created_at asc ";
        $query = $this->db->query($sql);
        return $query;
        
    }


    public function pre_batch_itemlist($bin_ID)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_stktake.stk_trans_prelisting_batch WHERE exported=0 AND BIN_ID= '$bin_ID' ORDER BY CREATED_AT DESC";
        $query = $this->db->query($sql);
        return $query;
        
    }

    public function pre_batch_itemView($batch_barcode)
    {
        //data is retrive from this query
        $sql = "SELECT b.* FROM backend_warehouse.d_grn_batch a INNER JOIN 
        backend_warehouse.d_grn_batch_item b ON a.batch_guid=b.batch_guid 
        WHERE a.batch_barcode = '$batch_barcode' ORDER BY b.scan_description";
        $query = $this->db->query($sql);
        return $query;
        
    }


    public function pre_itemDelete($TRANS_GUID)
    {
        //data is retrive from this query
        $sql = "DELETE from backend_stktake.stk_trans_prelisting where TRANS_GUID= '$TRANS_GUID' ";
        $query = $this->db->query($sql);
        return $query;
        
    }

    public function pre_batch_itemDelete($batch_barcode)
    {
        //data is retrive from this query
        $sql = "DELETE FROM backend_stktake.stk_trans_prelisting_batch WHERE exported=0 AND BATCH_BARCODE= '$batch_barcode'  ";
        $query = $this->db->query($sql);
        return $query;
        
    }

    public function pre_itemPrint($bin_ID)
    {
        //data is retrive from this query
        $sql = "UPDATE backend_stktake.stk_trans_prelisting SET send_print=1 WHERE exported=0 
        and BIN_ID = '$bin_ID' ";
        $query = $this->db->query($sql);
        return $query;
        
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
        //echo $this->db->last_query();die;
    }

    function insert_batch($data)
    {
        $this->db->insert($this->table_batch, $data);
        //echo $this->db->last_query();die;
    }

    function update($TRANS_GUID, $data)
    {
        $this->db->where('TRANS_GUID', $TRANS_GUID);
        $this->db->update($this->table, $data);
        //echo $this->db->last_query();die;
    }

    public function get_itemmaster($itemcode)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend.itemmaster where 
                itemcode = '$itemcode' ";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
        
    }

    public function exist_data($TRANS_GUID)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_stktake.stk_trans_prelisting WHERE TRANS_GUID= '$TRANS_GUID' ";
        $query = $this->db->query($sql);
        return $query;
        
    }

    public function exist_data_batch($barcode)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_stktake.stk_trans_prelisting_batch WHERE exported=0 AND BATCH_BARCODE= '$barcode' ";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function exist_barcode_batch($barcode)
    {
        //data is retrive from this query
        $sql = "SELECT * from backend_warehouse.d_grn_batch where BATCH_BARCODE= '$barcode'";
        $query = $this->db->query($sql);
        return $query;
    }
    
}
?>