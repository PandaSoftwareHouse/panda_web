<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class greceive_model extends CI_Model
{
    public $table = 'backend_warehouse.d_grn_batch';
    public $table_item = 'backend_warehouse.d_grn_batch_item';
    public $table_set_sysrun = 'backend_warehouse.set_sysrun';
    public $table_d_grn = 'backend_warehouse.d_grn';
  
    public function __construct()
    {
        parent::__construct();
    }


    public function po_list()
    {
        $username = $_SESSION["username"];
        $location = $_SESSION["location"];
        $sublocation = $_SESSION["sub_location"];
        //data is retrive from this query
        $sql = "SELECT 1 AS Seq,a.* FROM backend_warehouse.d_grn a WHERE convert_grn='0' AND received=0 AND 
        trans_type='GRN_WEIGHT' AND created_by='$username' AND sublocation='$sublocation' AND canceled=0 
        UNION ALL 
        SELECT 2 AS Seq,a.* FROM backend_warehouse.d_grn a WHERE convert_grn='0' AND received=0 AND 
        trans_type='GRN_WEIGHT' AND created_by<>'$username' AND 
        sublocation='$sublocation' AND canceled=0 ORDER BY Seq,created_by, created_at DESC";
        $query = $this->db->query($sql);
        return $query;
        
    }

    public function check_po_no($po_no)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend.pomain WHERE refno='$po_no'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function scan_po_result($po_no)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend.pomain WHERE BillStatus='1' AND refno='$po_no'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function barcode_scan_result($barcode)
    {
        //data is retrive from this query
        $sql = "SELECT a.itemcode,a.itemlink,b.barcode,b.bardesc,a.packsize from backend.itemmaster a inner join backend.itembarcode b on a.itemcode=b.itemcode where barcode='$barcode'";
        $query = $this->db->query($sql);
        return $query;
    }


    public function po_add($po_no)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.d_grn WHERE po_no= '$po_no' AND convert_grn='0' 
        and canceled='0' ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function po_details($po_no)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.d_grn WHERE po_no= '$po_no' AND convert_grn= '0' ";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function po_batch($grn_guid)
    {
        //data is retrive from this query
        $sql = "SELECT * from backend_warehouse.d_grn_batch where grn_guid = '$grn_guid' order by batch_id desc";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function have_itemlink($posum_guid)
    {
        //data is retrive from this query
        $sql = "SELECT itemcode,itemlink,description,packsize,po_qty,foc_qty,po_bal,grn_diff,grn_by_weight_hide_po_info from backend_warehouse.d_grn_posum a join backend.xsetup b where posum_guid='$posum_guid'";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function po_post_grn_scan($grn_id)
    {
        $location = $_SESSION["location"];
        $sql = "SELECT * FROM backend_warehouse.d_grn WHERE grn_id = '$grn_id' AND trans_type='GRN_WEIGHT' 
        AND received=0 AND location='$location' ";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function po_print_batch_list_dn($grn_guid)
    {
        //data is retrive from this query
        $sql = "UPDATE backend_warehouse.d_grn SET send_print_2 ='1' WHERE grn_guid= '$grn_guid' ";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function po_print_batch_list($grn_guid)
    {
        //data is retrive from this query
        $sql = "UPDATE backend_warehouse.d_grn SET send_print='1' WHERE grn_guid= '$grn_guid' ";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function po_print_batch_only($batch_guid)
    {
        //data is retrive from this query
        $sql = "UPDATE backend_warehouse.d_grn_batch SET send_print=1 WHERE batch_guid='$batch_guid'";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function batch_gross_weight($batch_guid)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.d_grn_batch WHERE batch_guid= '$batch_guid' ";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function goods_pallet_weight_update($goods_pallet_weight)
    {
        $batch_guid = $_SESSION['batch_guid'];
        $sql = "UPDATE backend_warehouse.d_grn_batch SET goods_pallet_weight = '$goods_pallet_weight' WHERE batch_guid = '$batch_guid'";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    //before $_SESSION['batch_guid'] declared
    public function d_grn_recal_batch_variance_before($batch_guid)
    {
        // $batch_guid = $_SESSION['batch_guid'];
        $sql = "CALL backend_warehouse.d_grn_recal_batch_variance('$batch_guid')";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function d_grn_recal_batch_variance($batch_guid)
    {
        $batch_guid = $_SESSION['batch_guid'];
        $sql = "CALL backend_warehouse.d_grn_recal_batch_variance('$batch_guid')";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function d_grn_create_batch($batch_guid, $method_name)
    {
        $sql = "CALL backend_warehouse.d_grn_create_batch('$batch_guid', '$method_name')";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function d_grn_method_weight_by_batchguid($batch_guid)
    {
        $sql = "CALL backend_warehouse.d_grn_method_weight_by_batchguid('$batch_guid')";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function d_grn_pallet_weight_by_batchguid($batch_guid)
    {
        $sql = "CALL backend_warehouse.d_grn_pallet_weight_by_batchguid('$batch_guid')";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    public function guid($bin_ID)
    {
        //data is retrive from this query
        $sql = "SELECT REPLACE(UPPER(UUID()),'-','') AS row_guid,IF(MAX(row_no) IS NULL,0,MAX(row_no))+1 AS next_row 
        FROM backend_stktake.set_bin_row WHERE bin_no='$bin_ID'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function batch_data($batch_guid)
    {
        //data is retrive from this query
        $sql = "SELECT batch_id,batch_barcode,send_print from backend_warehouse.d_grn_batch where batch_guid='$batch_guid'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function batch_item_data($batch_guid)
    {
        //data is retrive from this query
        $sql = "SELECT IF(b.item_guid IS NOT NULL ,'BATCH','QTY') AS scan_type, a.*  FROM 
(SELECT * FROM backend_warehouse.d_grn_batch_item a WHERE batch_guid='$batch_guid' ORDER BY lineno DESC) a
LEFT JOIN backend_warehouse.d_grn_batch_item_c b ON a.item_guid = b.`item_guid` GROUP BY a.item_guid ORDER BY a.lineno DESC;";
        $query = $this->db->query($sql);
        return $query;
    }

    public function grda_button($batch_guid)
    {
        //data is retrive from this query
        // $sql = "SELECT IF(rec_type = 'RTV',-1,iconshow) AS iconshow, a.* FROM ( SELECT * FROM backend_warehouse.d_grn_batch_item ) a
        //     LEFT JOIN(SELECT batch_guid, SUM(qty_diff)AS  iconshow FROM backend_warehouse.d_grn_batch_item 
        //     WHERE batch_guid = '$batch_guid' AND qty_diff < 0) c ON a.batch_guid = c.batch_guid
        //     WHERE a.batch_guid = '$batch_guid' ORDER BY lineno DESC";
        // close by faizul 27102017
        $sql = "SELECT IF(EXISTS
(SELECT rec_type FROM backend_warehouse.d_grn_batch_item WHERE batch_guid = '$batch_guid'),-1,iconshow) 
AS iconshow, a.* FROM ( SELECT * FROM backend_warehouse.d_grn_batch_item ) a 
LEFT JOIN(SELECT batch_guid, SUM(qty_diff)AS iconshow FROM backend_warehouse.d_grn_batch_item 
WHERE batch_guid = '$batch_guid' AND qty_diff < 0) c ON a.batch_guid = c.batch_guid 
WHERE a.batch_guid = '$batch_guid' ORDER BY lineno DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    function convert_excess_to_foc($update_data, $item_guid)
    {
        $this->db->where('item_guid', $item_guid);
        $this->db->update('backend_warehouse.d_grn_batch_item', $update_data);
        //echo $this->db->last_query();die;
    }

    function item_entry_update($data)
    {
        $this->db->where('item_guid', $_SESSION['item_guid']);
        $this->db->update('backend_warehouse.d_grn_batch_item', $data);
        //echo $this->db->last_query();die;
    }

    function item_entry_insert($data)
    {
        $this->db->insert('backend_warehouse.d_grn_batch_item', $data);
        //echo $this->db->last_query();die;
    }

    function item_entry_insert_c($data_insert)
    {
        $this->db->insert('backend_warehouse.d_grn_batch_item_c', $data_insert);
        //echo $this->db->last_query();die;
    }

    function insert_data($data)
    {
        $this->db->insert($this->table, $data);
        
    }

    function delete_data($batch_guid)
    {
        $this->db->where('batch_guid', $batch_guid);
        $this->db->delete('backend_warehouse.d_grn_batch');
    }

    function batch_itemDelete($item_guid)
    {
        $this->db->where('item_guid', $item_guid);
        $this->db->delete('backend_warehouse.d_grn_batch_item');
    }

    function batch_itemDelete2_c($item_guid)
    {
        $this->db->where('item_guid', $item_guid);
        $this->db->delete('backend_warehouse.d_grn_batch_item_c');
    }

    function batch_itemDelete_c($item_guid_c)
    {
        $this->db->where('item_guid_c', $item_guid_c);
        $this->db->delete('backend_warehouse.d_grn_batch_item_c');
    }

    public function d_grn_goods_weight_by_batchguid($batch_guid)
    {
        $sql = "CALL backend_warehouse.d_grn_goods_weight_by_batchguid('$batch_guid')";
        $query = $this->db->query($sql);
        return $query;
    }

    public function d_grn_update_porec($posum_guid)
    {
        $sql = "CALL backend_warehouse.d_grn_update_porec('$posum_guid')";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    function insert_entry_as_RTV_action($data)
    {
        $this->db->insert($this->table_item, $data);
        //echo $this->db->last_query();die;
    }

    function update_entry_as_RTV_action($data, $guid)
    {
        $this->db->where('item_guid', $guid);
        $this->db->update($this->table_item, $data);
    }

    function insert_sysrun($data)
    {
        $this->db->insert($this->table_set_sysrun, $data);
    }

    function update_sysrun($data)
    {
        $this->db->where('run_type', 'GRNBATCH');
        $this->db->update($this->table_set_sysrun, $data);
    }

    function po_add_insert($data)
    {
        $this->db->insert($this->table_d_grn, $data);
    }

    function po_edit_update($data)
    {
        $grn_guid = $_SESSION['grn_guid'];
        $this->db->where('grn_guid', $grn_guid);
        $this->db->update($this->table_d_grn, $data);
    }

    function d_grn_update($data)
    {
        $refno = $_SESSION['gr_no'];
        $this->db->where('convert_grn_by', $refno);
        $this->db->update($this->table_d_grn, $data);
    }

    function d_grn_delete($grn_guid)
    {
        $sql = "CALL backend_warehouse.d_grn_delete('$grn_guid')";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    function d_grn_create_podetail($grn_guid)
    {
        $sql = "Call backend_warehouse.d_grn_create_podetail('$grn_guid','".$_SESSION['po_no']."')";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    function d_grn_create_posum($grn_guid)
    {
        $sql = "Call backend_warehouse.d_grn_create_posum('$grn_guid')";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $query;
    }

    function batch_weight_save($data, $method_guid)
    {
        $this->db->where('method_guid', $method_guid);
        $this->db->update('backend_warehouse.d_grn_method', $data);
        //echo $this->db->last_query();die;
    }

    

}