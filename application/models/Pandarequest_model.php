<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pandarequest_model extends CI_Model
{
  
    public function __construct()
    {
        parent::__construct();
    }


    public function login_data($username, $userpass)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.set_user WHERE user_name='$username' AND user_password='$userpass'";
        $query = $this->db->query($sql);
        return $query->num_rows();
        
    }
    
    public function home_data()  
    {  
         
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.module_menu WHERE hide_menu = '2'";
        $query = $this->db->query($sql);  
        return $query;  
    }


    public function transaction_today()  
    {  
        
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.stock_request WHERE Trans_Date = CURDATE() ORDER BY DocDate DESC";
        $query = $this->db->query($sql);  
        return $query;  
    }


    public function transaction_data()  
    {  
        
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.stock_request ORDER BY DocDate DESC";
        $query = $this->db->query($sql);  
        return $query;  
    }


    public function add_transaction_data($username)  
    {  
        //data is retrive from this query
        $sql = "REPLACE INTO backend_warehouse.stock_request (Trans_ID, DocDate, Created_By)
                VALUES ( replace(upper(uuid()),'-',''), NOW(), '$username')";
        $query = $this->db->query($sql);  
        return $query;  
    }

// not use
    public function identify_sysrun()  
    {  
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.set_sysrun WHERE run_type = 'REQUEST_STOCK' AND run_code = 'RS'";
        $query = $this->db->query($sql);  
        return $query;  
    }

// not use
    public function insert_sysrun()  
    {  
        //data is retrive from this query
        $sql = "INSERT INTO backend_warehouse.set_sysrun (run_type, run_code ) VALUES ( 'REQUEST_STOCK', 'RS' ) ";
        $query = $this->db->query($sql);  
        return $query;  
    }

// not use
    public function update_sysrun()  
    {  
        //data is retrive from this query
        $sql = "UPDATE backend_warehouse.set_sysrun SET run_year = YEAR(CURRENT_TIMESTAMP) , run_month = MONTH(CURRENT_TIMESTAMP),
        run_day = DAY(CURRENT_TIMESTAMP), run_date = CURDATE(), run_currentno = run_currentno + 1 , run_digit = '4' 
        WHERE run_code = 'RS'";
        $query = $this->db->query($sql);  
        return $query;  
    }

// not use
    public function add_refno($username, $run_code, $run_year, $run_month, $run_day, $run_currentno, $run_digit)  
    {  
        //data is retrive from this query
        $sql = "INSERT INTO backend_warehouse.stock_request (Trans_ID, DocDate, Created_by)
        VALUES ((SELECT CONCAT(run_code, run_year, REPEAT(0,2-LENGTH(run_month)),run_month, 
        REPEAT(0,2-LENGTH(run_day)),run_day, REPEAT(0,run_digit-LENGTH(run_currentno + 1)), run_currentno + 1)
        FROM backend_warehouse.set_sysrun WHERE run_type = 'REQUEST_STOCK' ), NOW(), '$username')";
        $query = $this->db->query($sql);  
        return $query;  
    }


    public function identify_TransID()  
    {  
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.stock_request WHERE Trans_Date = CURDATE()";
        $query = $this->db->query($sql);  
        return $query;  
    }


    public function insert_TransID()  
    {  
        $username = $this->session->userdata('username');
        //data is retrive from this query
        $sql = "INSERT INTO backend_warehouse.stock_request (Trans_ID, Trans_Date, Created_By, DocDate) 
        VALUES ( REPLACE(UPPER(UUID()),'-',''), CURDATE(), '$username', NOW() ) ";
        $query = $this->db->query($sql);  
        return $query;  
    }

// not use
    public function post()  
    {  
        $guid = $this->input->post('guidpost');
        //data is retrive from this query
        $sql = "UPDATE backend_warehouse.stock_request
        SET stock_request.posted = '1' WHERE Trans_ID = '$guid'";
        $query = $this->db->query($sql);
        return $query;
    }


    public function sendprint()  
    {  
        $guid = $this->input->post('guid');
        $Itemcode = $this->input->post('Itemcode');
        
        $data = [];

        foreach($Itemcode as $i => $id) {
         $data[] = [ 'stock_request_item.Itemcode' => $id, 'stock_request_item.Send_print' => '1', ];
        }

        $this->db->where_in('Trans_ID', $guid);
        //$this->db->join('stock_count', 'stock_count.TRANS_GUID = stock_count_item.TRANS_GUID');
        $this->db->update_batch('backend_warehouse.stock_request_item', $data, 'stock_request_item.Itemcode');
        //$this->db->update('stock_count', $array);
        //echo $this->db->last_query();die;
    }


    public function check_binID($bin_ID)  
    {  
        //data is retrive from this query
        $sql = "SELECT BIN_NO FROM backend_stktake.set_bin WHERE BIN_NO = '$bin_ID'";
        $query = $this->db->query($sql);
        return $query;
    }


    public function scan_binID($bin_ID)  
    {  
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.stock_request_item a INNER JOIN backend.itemmaster b
        ON a.Itemcode = b.itemcode WHERE a.Bin_ID = '$bin_ID' AND a.Trans_ID = (SELECT Trans_ID FROM
        backend_warehouse.stock_request WHERE Trans_Date = CURDATE())";
        $query = $this->db->query($sql);
        return $query;
    }


    public function view_bin($guid)  
    {  
        
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.stock_request_item a INNER JOIN backend.itemmaster b
        ON a.Itemcode = b.itemcode WHERE Trans_ID = '$guid' ";
        $query = $this->db->query($sql);
        return $query;
    }


    public function view_item($guid,$Bin_ID)  
    {  
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.stock_request_item a INNER JOIN backend.itemmaster b
        ON a.Itemcode = b.itemcode WHERE Trans_ID = '$guid' and a.Bin_ID = '$Bin_ID' ORDER BY a.DocDate DESC ";
        $query = $this->db->query($sql);
        return $query;
    }


    public function view_item2($guid)  
    {  
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.stock_request_item a INNER JOIN backend.itemmaster b
        ON a.Itemcode = b.itemcode WHERE Trans_ID = '$guid' ORDER BY a.DocDate DESC ";
        $query = $this->db->query($sql);
        return $query;
    }


    public function view_item_scan()  
    {  
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.stock_request_item a INNER JOIN backend.itemmaster b
        ON a.Itemcode = b.itemcode INNER JOIN backend_warehouse.stock_request c ON a.TRans_ID = c.Trans_ID
        WHERE c.Trans_Date = CURDATE() ORDER BY a.DocDate DESC";
        $query = $this->db->query($sql);
        return $query;
    }


    public function done_view_item()  
    {  
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.stock_request_item a INNER JOIN backend.itemmaster b
        ON a.Itemcode = b.itemcode INNER JOIN backend_warehouse.stock_request c
        ON a.Trans_ID = c.Trans_ID WHERE c.Trans_Date = CURDATE()  ORDER BY a.DocDate DESC ";
        $query = $this->db->query($sql);
        return $query;
    }


    public function ctn_qty()  
    {  
        //data is retrive from this query
        $sql = "SELECT CONCAT(FORMAT(('$qty_request'-('$qty_request1' MOD '$BulkQty')) / '$BulkQty',0),
        ' ctn ', '$qty_request' MOD '$BulkQty',' unit') AS ctnqty";
        $query = $this->db->query($sql);
        return $query;
    }


    public function header_view_item($guid)  
    {  
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.stock_request WHERE Trans_ID = '$guid'";
        $query = $this->db->query($sql);
        return $query;
    }


    public function guid()  
    {   
        //data is retrive from this query
        $sql = "SELECT Trans_ID FROM backend_warehouse.stock_request WHERE Trans_Date = CURDATE()";
        $query = $this->db->query($sql);  
        return $query;  
    }


    public function scanbarcode_data($barcode)  
    {  
       
        //data is retrive from this query
        $sql = "SELECT * FROM backend.itemmaster a1 INNER JOIN (
        SELECT itemlink FROM backend.itemmaster a INNER JOIN backend.itembarcode b ON a.itemcode = b.itemcode 
        WHERE barcode = '$barcode' ) a2 ON a1.itemlink = a2.itemlink";
        $query = $this->db->query($sql);  
        return $query;  
    }


    public function scanbarcode_data1($barcode)  
    {  
       
        //data is retrive from this query
        $sql = "SELECT * FROM backend.itemmaster a1 INNER JOIN (
        SELECT itemlink FROM backend.itemmaster a INNER JOIN backend.itembarcode b ON a.itemcode = b.itemcode 
        WHERE barcode = '$barcode' ) a2 ON a1.itemlink = a2.itemlink WHERE a1.Itemcode = a1.ItemLink ";
        $query = $this->db->query($sql);  
        return $query;  
    }


    public function qty_balance($barcode)  
    {  
       
        //data is retrive from this query
        $sql = "SELECT * FROM backend.itemmaster a1 INNER JOIN ( 
        SELECT itemlink FROM backend.itemmaster a INNER JOIN backend.itembarcode b ON a.itemcode = b.itemcode 
        WHERE barcode = '$barcode') a2 ON a1.itemlink = a2.itemlink 
        INNER JOIN backend_warehouse.stock_request_item c ON c.Itemcode = a1.Itemcode INNER JOIN 
        backend_warehouse.stock_request d ON d.Trans_ID = c.Trans_ID WHERE d.Trans_Date = CURDATE() ";
        $query = $this->db->query($sql);  
        return $query;  
    }


    public function add_request($guid, $itemcode, $description, $itemlink, $qoh, $qty_request, $qty_balance, $qty_requested)  
    {  
        //data is retrive from this query
        $BulkQty = $this->input->post('BulkQty');
        $PackSize = $this->input->post('PackSize');
        $Itemcode = $this->input->post('Itemcode');
        $qty_request = $this->input->post('qty_request');
        $OnHandQty = $this->input->post('OnHandQty');
        $Description = $this->input->post('Description');
        $ItemLink = $this->input->post('ItemLink');
        $guid = $this->input->post('guid');

        $Itemcode1 = $this->input->post('Itemcode1');
        $OnHandQty1 = $this->input->post('OnHandQty1');
        $Description1 = $this->input->post('Description1');
        $ItemLink1 = $this->input->post('ItemLink1');
        $qty_balance = $this->input->post('qty_balance');
        $qty_requested = $this->input->post('qty_requested');

        
        $data = [];

        foreach($Itemcode as $i => $id) {

            $total[] = (int)$qty_request[$i] * (int)$PackSize[$i];
            $totalall = array_sum($total);
            $total_qty_balance = (int)$totalall + (int)$qty_balance;
            $total_qty_request = array_sum($total) + (int)$qty_requested;
            
        }

        foreach($guid as $i => $id) {
        $data[] = ['stock_request_item.qty_request' => array_sum($total),
        'stock_request_item.Qoh' => $OnHandQty1, 'stock_request_item.Trans_ID' => $guid[$i], 
        'stock_request_item.Itemlink' => $ItemLink1, 'stock_request_item.Itemcode' => $Itemcode1, 
        'stock_request_item.Description' => $Description1, ];
        }

        $bin_ID = $this->session->userdata('bin_ID');
        $sql = "REPLACE INTO backend_warehouse.stock_request_item 
        (Trans_ID, Bin_ID, DocDate, Itemcode, Itemlink, Description, Qoh, qty_request, qty_balance)
        VALUES 
        ( '$guid[$i]', '$bin_ID',  NOW(), '$Itemcode1', '$ItemLink1', '', '$OnHandQty1', '$total_qty_request', '$total_qty_balance' )";
        $query = $this->db->query($sql);
        return $query;
        echo $this->db->last_query();die; 
    }


    public function update_desc()//add 'qty_actual' to po_ex_c  
    {
        //data is retrive from this query
        $sql = "UPDATE backend_warehouse.stock_request_item a INNER JOIN backend.itemmaster b
        ON a.Itemcode = b.Itemcode SET a.Description = b.Description where a.Description = '' ";
        $query = $this->db->query($sql);
        return $query;
    }

// not use
    public function add_request2($guid, $itemcode, $description, $itemlink, $qoh, $qty_request)  
    {  
        //data is retrive from this query
        $BulkQty = $this->input->post('BulkQty');
        $PackSize = $this->input->post('PackSize');
        $Itemcode = $this->input->post('Itemcode');
        $qty_request = $this->input->post('qty_request');
        $OnHandQty = $this->input->post('OnHandQty');
        $Description = $this->input->post('Description');
        $ItemLink = $this->input->post('ItemLink');
        $guid = $this->input->post('guid');

        $Itemcode1 = $this->input->post('Itemcode1');
        $OnHandQty1 = $this->input->post('OnHandQty1');
        $Description1 = $this->input->post('Description1');
        $ItemLink1 = $this->input->post('ItemLink1');

        
        $data = [];

        foreach($Itemcode as $i => $id) {

            $total[] = (int)$qty_request[$i] * (int)$PackSize[$i];
            $totalall = array_sum($total);
        }

        foreach($guid as $i => $id) {
        $data[] = ['stock_request_item.qty_request' => array_sum($total),
        'stock_request_item.Qoh' => $OnHandQty1, 'stock_request_item.Trans_ID' => $guid[$i], 
        'stock_request_item.Itemlink' => $ItemLink1, 'stock_request_item.Itemcode' => $Itemcode1, 
        'stock_request_item.Description' => $Description1, ];
        }

        $sql = "REPLACE INTO backend_warehouse.stock_request_item (Trans_ID, Itemcode, Itemlink, Description, Qoh, qty_request)
                VALUES ( '$guid[$i]', '$Itemcode1', '$ItemLink1', '$Description1', '$OnHandQty1', '$totalall' )";
        $query = $this->db->query($sql);
        return $query;
        echo $this->db->last_query();die; 
    }


    public function TransID($TransID)  
    {  
        //data is retrive from this query
        $sql = "SELECT Trans_ID FROM backend_warehouse.stock_request WHERE Trans_ID = '$TransID' ";
        $query = $this->db->query($sql);
        return $query;
    }


    public function scan_item_request($barcode, $TransID)  
    {  
        //data is retrive from this query
        $sql = "SELECT * FROM backend.itemmaster a1 INNER JOIN (
        SELECT itemlink FROM backend.itemmaster a INNER JOIN backend.itembarcode b ON a.itemcode = b.itemcode 
        WHERE barcode = '$barcode') a2 ON a1.itemlink = a2.itemlink INNER JOIN backend_warehouse.stock_request_item c
        ON a1.Itemcode = c.Itemcode WHERE c.Trans_ID = '$TransID'";
        $query = $this->db->query($sql);
        return $query;
    }


    public function add_qty_pick($Itemcode, $qty_pick, $Trans_ID, $qty_request, $qty_balance)  
    {
        $Itemcode = $this->input->post('Itemcode');
        $qty_request = $this->input->post('qty_request');
        $qty_pick = $this->input->post('qty_pick');
        $qty_balance = $this->input->post('qty_balance');

        $data = [];

        foreach($Itemcode as $i => $id) {

            $total[] = (int)$qty_balance[$i] - (int)$qty_pick[$i];
            
        }

        foreach($Itemcode as $i => $id) {
         $data[] = [ 'stock_request_item.Itemcode' => $id, 'stock_request_item.qty_pick' => $qty_pick[$i], 
         'stock_request_item.qty_balance' => $total[$i], ];
        }

        $this->db->where_in('Trans_ID', $Trans_ID);
        //$this->db->join('stock_count', 'stock_count.TRANS_GUID = stock_count_item.TRANS_GUID');
        $this->db->update_batch('backend_warehouse.stock_request_item', $data, 'stock_request_item.Itemcode');
        //$this->db->update('stock_count', $array);
        //echo $this->db->last_query();die;
        
    }

}
?> 

        <!--


        succeed 2
        //data is retrive from this query
        $BulkQty = $this->input->post('BulkQty');
        $Itemcode = $this->input->post('Itemcode');
        $qty_request = $this->input->post('qty_request');
        $OnHandQty = $this->input->post('OnHandQty');
        $Description = $this->input->post('Description');
        $ItemLink = $this->input->post('ItemLink');
        $guid = $this->input->post('guid');

        
        $data = [];

        foreach($Itemcode as $i => $id) {

        $data[] = ['stock_request_item.qty_request' => $qty_request[$i] / $BulkQty[$i], 
        'stock_request_item.Qoh' => $OnHandQty[$i], 'stock_request_item.Trans_ID' => $guid[$i], 
        'stock_request_item.Itemlink' => $ItemLink[$i], 'stock_request_item.Itemcode' => $Itemcode[$i], 
        'stock_request_item.Description' => $Description[$i], ];
        }

         

        //$this->db->where_in('TRANS_GUID', $guid);
        //$this->db->join('stock_count', 'stock_count.TRANS_GUID = stock_count_item.TRANS_GUID');
        $this->db->insert_batch('backend_warehouse.stock_request_item', $data);
        //$this->db->update('stock_count', $array);
        echo $this->db->last_query();die;




        succeed 1
        //data is retrive from this query
        $Itemcode = $this->input->post('Itemcode');
        $qty_request = $this->input->post('qty_request');
        $OnHandQty = $this->input->post('OnHandQty');
        $Description = $this->input->post('Description');
        $ItemLink = $this->input->post('ItemLink');
        $guid = $this->input->post('guid');

        $data = [];

        foreach($Itemcode as $i => $id) {
         $data[] = ['stock_request_item.qty_request' => $qty_request[$i], 
        'stock_request_item.Qoh' => $OnHandQty[$i], 'stock_request_item.Trans_ID' => $guid[$i], 
        'stock_request_item.Itemlink' => $ItemLink[$i], 'stock_request_item.Itemcode' => $Itemcode[$i], 
        'stock_request_item.Description' => $Description[$i], ];
        }

        //$this->db->where_in('TRANS_GUID', $guid);
        //$this->db->join('stock_count', 'stock_count.TRANS_GUID = stock_count_item.TRANS_GUID');
        $this->db->insert_batch('backend_warehouse.stock_request_item', $data);
        //$this->db->update('stock_count', $array);
        echo $this->db->last_query();die;




        $sql = "REPLACE INTO backend_warehouse.stock_request_item (Trans_ID, Itemcode, Itemlink, Description, Qoh, qty_request)
                VALUES ( '$guid', '$itemcode', '$itemlink', '$description', '$qoh', '$qty_request')";
        $query = $this->db->query($sql);  
        return $query;


        $sql = array(); 
        foreach( $data as $row ) {
            $sql[] = '("'.mysql_real_escape_string($row['text']).'", '.$row['category_id'].')';
        }
        mysql_query('INSERT INTO table (text, category) VALUES '.implode(',', $sql));

        
        
        
        $data = [];

        foreach($itemcode as $i => $id) {
         $data[] = [ 'stock_count_item.Itemcode' => $id, 'stock_count_item.qty_order' => $qty[$i], ];
        }

        $this->db->where_in('TRANS_GUID', $guid);
        //$this->db->join('stock_count', 'stock_count.TRANS_GUID = stock_count_item.TRANS_GUID');
        $this->db->update_batch('stock_count_item', $data, 'stock_count_item.Itemcode');
        //$this->db->update('stock_count', $array);
        //echo $this->db->last_query();die;
        -->