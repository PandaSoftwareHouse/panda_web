<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class greturn_model extends CI_Model
{
  public $table_set_sysrun = 'backend_warehouse.set_sysrun';
    public $table_d_grn = 'backend_warehouse.dn';
    public $table = 'backend_warehouse.d_grn_batch';
  
    public function __construct()
    {
        parent::__construct();
    }


    public function dn_list()
    {
        $location = $_SESSION["location"];
        //data is retrive from this query
        $sql = "SELECT sup_name,sup_code FROM backend.dbnote_basket WHERE location_to='$location' 
        AND converted=0 GROUP BY sup_code ORDER BY sup_name";
        $query = $this->db->query($sql);
        return $query;
    }


    public function dn_item_list($sup_code)
    {
        
        $location = $_SESSION["location"];
        //data is retrive from this query
        $sql = "SELECT * FROM backend.dbnote_basket WHERE converted=0  AND location_to='$location' 
        AND sup_code='$sup_code' ORDER BY updated_at DESC";
        $query = $this->db->query($sql);
        return $query;
        
    }


    public function delete_item($item_guid)
    {
        
        //data is retrive from this query
        $sql = "DELETE FROM backend.dbnote_basket WHERE item_guid='$item_guid'";
        $query = $this->db->query($sql);
        return $query;
        
    }

    public function check_barcode($barcode)
    {
        $sql = "SELECT if(b.none_return = 1, 999, b.none_return) as sort,priority_vendor, none_return,a.* from backend.itembarcode a  inner join backend.itemmastersupcode b on a.itemcode = b.itemcode where barcode ='$barcode' order by sort asc, priority_vendor asc limit 1";
        $query = $this->db->query($sql);
        return $query;
    }

    public function result_barcode($itemcode)
    {
        $sql = "SELECT a.* FROM backend.itemmastersupcode a INNER JOIN backend.`itemmastersupcode` b ON a.itemcode=b.itemcode INNER JOIN backend.supcus c ON b.code=c.code AND c.Type='S' WHERE stock_returnable=1 AND a.Itemcode ='$itemcode' AND a.none_return=0 order by a.priority_vendor asc, updated_at desc";
        $query = $this->db->query($sql);
        return $query;
    }

    public function result_itemmaster($itemcode)
    {
        $sql = "SELECT * from backend.itemmaster where Itemcode ='$itemcode'";
        $query = $this->db->query($sql);
        return $query;
    }

    function insert_sysrun($data)
    {
        $this->db->insert($this->table_set_sysrun, $data);
    }

    function update_sysrun($data)
    {
        $this->db->where('run_type', 'DNBATCH');
        $this->db->update($this->table_set_sysrun, $data);
    }

    function insert_item($data)
    {
        $this->db->insert('dbnote_basket', $data);
    }

    function edit_item($data, $item_guid)
    {
        $this->db->where('item_guid', $item_guid);
        $this->db->update('dbnote_basket', $data);
    }

    function dn_add_insert($data)
    {
        $this->db->insert($this->table_d_grn, $data);
    }
}
?>