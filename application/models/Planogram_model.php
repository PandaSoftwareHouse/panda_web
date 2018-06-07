<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class planogram_model extends CI_Model
{
  
    public $table_set_bin_row = 'backend_stktake.set_bin_row';
    public $table_set_bin_row_item = 'backend_stktake.set_bin_row_item';
    public $table_item_volume_master = 'backend_stktake.set_item_volume_master';
  
  
    public function __construct()
    {
        parent::__construct();
    }


    public function check_binID($bin_ID)
    {
        $sql = "SELECT * FROM backend_stktake.set_bin WHERE BIN_NO='$bin_ID'";
        $query = $this->db->query($sql);
        return $query;   
    }


    public function binID_list($bin_ID)
    {
        $sql = "SELECT * FROM backend_stktake.set_bin_row WHERE BIN_NO='$bin_ID' ORDER BY row_no";
        $query = $this->db->query($sql);
        return $query;   
    }


    public function guid($bin_ID)
    {
        $sql = "SELECT REPLACE(UPPER(UUID()),'-','') AS row_guid,IF(MAX(row_no) IS NULL,0,MAX(row_no))+1 AS next_row 
        FROM backend_stktake.set_bin_row WHERE bin_no='$bin_ID'";
        $query = $this->db->query($sql);
        return $query;
        
    }

    function insert_row($data)
    {
        $this->db->insert($this->table_set_bin_row, $data);
        
    }

    public function save1($row_guid, $row_w, $row_d, $row_h, $bin_ID)
    {
        //data is retrive from this query
        $sql = "UPDATE backend_stktake.set_bin_row 
        SET row_w=ROUND('$row_w',2),row_d=ROUND('$row_d',2),row_h=ROUND('$row_h',2) 
        WHERE row_guid='$row_guid'";
        $query = $this->db->query($sql);
        return $query;
        
    }

    public function save2($row_guid, $row_w, $row_d, $row_h)
    {
        //data is retrive from this query
        $sql = "UPDATE backend_stktake.set_bin_row
        SET row_volume=ROUND('$row_w'*'$row_d'*'$row_h',2) WHERE row_guid='$row_guid'";
        $query = $this->db->query($sql);
        return $query;
        
    }

    function insert_row_item($data)
    {
        $this->db->insert($this->table_set_bin_row_item, $data);
        
    }

    function update_row_item($data)
    {
        $this->db->where('item_guid', $_SESSION['get_item_guid']);
        $this->db->update($this->table_set_bin_row_item, $data);
        //echo $this->db->last_query();die;
    }


    function insert_row_item_master($data)
    {
        $this->db->insert($this->table_item_volume_master, $data);

    }

    function update_row_item_master($data)
    {
        $this->db->where('itemcode', $_SESSION['row_itemcode']);
        $this->db->update($this->table_item_volume_master, $data);
        //echo $this->db->last_query();die;
    }
}