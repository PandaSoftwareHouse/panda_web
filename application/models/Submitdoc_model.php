<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class submitdoc_model extends CI_Model
{
    public $table = 'backend_warehouse.d_grn_batch';
    public $table_item = 'backend_warehouse.d_grn_batch_item';
    public $table_set_sysrun = 'backend_warehouse.set_sysrun';
    public $table_d_grn = 'backend_warehouse.d_grn';
    public $table_sl_child = 'backend_warehouse.sl_child';
    public $table_sl_main = 'backend_warehouse.sl_main';
  
    public function __construct()
    {
        parent::__construct();
    }

    
    function insert_sysrun($data)
    {
        $this->db->insert($this->table_set_sysrun, $data);
    }

    function update_sysrun($data)
    {
        $this->db->where('run_type', 'SUBMISSIONLIST');
        $this->db->update($this->table_set_sysrun, $data);
    }

    function insert_dataMain($dataMain)
    {
        $this->db->insert($this->table_sl_main, $dataMain);
    }

    function insert_dataChild_array($check_barcode)
    {
        $userid = $_SESSION["userid"];
        $guid = $_SESSION['sl_guid'];

        $query_datetime = $this->db->query("SELECT NOW() AS datetime");
        $datetime = $query_datetime->row('datetime');

        $data = [];

        foreach($check_barcode->result() as $row) {

        $query_guid = $this->db->query('SELECT REPLACE(UPPER(UUID()),"-","") AS guid ');
        $guid_c = $query_guid->row('guid');

         $data[] = [ 'sl_guid_c' => $guid_c,
                     'sl_guid' => $guid,
                     'trans_refno' => $row->refno,
                     'location' => $row->location,
                     'doc_type' => $row->doc_type,
                     'doc_no' => $row->doc_no, 
                     'inv_no' =>  $row->inv_no , 
                     'doc_date' => $row->doc_date , 
                     'grdate' => $row->grdate ,
                     'code' => $row->CODE , 
                     'name' =>  $row->NAME,
                     'total' => $row->total , 
                     'total_include_tax' => $row->total_include_tax , 
                     'gst_tax_sum' => $row->gst_tax_sum, 
                     'issuestamp' => $row->issuestamp,
                     'postdatetime' => $row->postdatetime, 
                     'created_at' => $datetime,
                     'created_by' => $userid, 
                     ];
        }
        $this->db->insert_batch($this->table_sl_child, $data);
    }

    function insert_dataChild($trans_refno, $location, $doc_type, $doc_no, $invno, $doc_date, $grdate, $CODE, $NAME, $total, $total_include_tax, $gst_tax_sum, $issuestamp, $postdatetime)
    {
        $userid = $_SESSION["userid"];
        $guid = $_SESSION['sl_guid'];
        $sql = "INSERT INTO backend_warehouse.sl_child (sl_guid_c, sl_guid, trans_refno, location ,doc_type, inv_no, doc_no, doc_date, grdate, code, name, total, total_include_tax, gst_tax_sum, issuestamp, postdatetime, created_at, created_by)
        VALUES ( REPLACE(UPPER(UUID()),'-',''), '$guid', '$trans_refno','$location','$doc_type', '$invno',  '$doc_no','$doc_date', '$grdate', '$CODE', '$NAME', '$total', '$total_include_tax', '$gst_tax_sum', '$issuestamp', '$postdatetime', NOW(),'$userid')";
        $query = $this->db->query($sql);
        return $query; 
    }

}
?> 