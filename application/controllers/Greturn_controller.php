<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class greturn_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('greturn_model');
        $this->load->model('main_model');
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
        $this->load->library('form_validation');

	}

    public function dn_add()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $datetime = $this->db->query("SELECT NOW() AS datetime");
            $date = $this->db->query("SELECT CURDATE() as date");
            $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid");

            $check_sysrun = $this->db->query("SELECT * from backend_warehouse.set_sysrun where run_type='DNBATCH'");

            $run_year = $this->db->query("SELECT YEAR(CURRENT_TIMESTAMP) as year");
            $run_month = $this->db->query("SELECT MONTH(CURRENT_TIMESTAMP) as month");
            $run_day = $this->db->query("SELECT DAY(CURRENT_TIMESTAMP) as day");

            if($check_sysrun->row('run_date') == '')
            {
                $data = array(

                    'run_type' => 'DNBATCH',
                    'run_code' => 'GW',
                    'run_year' => $run_year->row('year'),
                    'run_month' => $run_month->row('month'),
                    'run_day' => $run_day->row('day'),
                    'run_date' => $date->row('date'),
                    'run_currentno' => '0',
                    'run_digit' => '4',
                    );
                $this->greturn_model->insert_sysrun($data);
                $get_run_date = $this->db->query("SELECT * from backend_warehouse.set_sysrun where run_type='DNBATCH'");
            };

            if($check_sysrun->row('run_date') < $date->row('date'))
            {
                $data= array(
                    'run_date' => $date->row('date'),
                    'run_currentno' => 1,
                    );
                $this->greturn_model->update_sysrun($data);
            }
            else
            {
                $data= array(
                    'run_currentno' => $check_sysrun->row('run_currentno')+1,
                    );
                $this->greturn_model->update_sysrun($data);
            }

            $getRefNo = $this->db->query("SELECT CONCAT(run_code, REPLACE(RIGHT(run_date,8), '-', ''), REPEAT(0,run_digit-LENGTH(run_currentno + 1)), run_currentno, LPAD(FLOOR(RAND() * 99),2,0))
                AS refno FROM backend_warehouse.set_sysrun WHERE run_type = 'DNBATCH' ");

            $data = array(

                'dn_guid' => $guid->row('guid'),
                'refno' => $getRefNo->row('refno'),
                'trans_type' => 'DNBATCH',
                'loc_group' => $_SESSION['loc_group'],
                'location' => $_SESSION['location'],
                'sublocation' => $_SESSION['sub_location'],
                'send_print' => '0',
                'converted' => '0',

                'created_at' => $datetime->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at' => $datetime->row('datetime'),
                'updated_by' => $_SESSION['username'],
            );
            $this->greturn_model->dn_add_insert($data);
            $this->session->set_flashdata('message', 'Succesfully Added: ' .$getRefNo->row('refno'));
            redirect('greturn_controller/dn_scan_item');

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function dn_scan_item()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greturn/dn_scan_item');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greturn/dn_scan_item');
                    $this->load->view('footer');
                }    
            
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function scan_item_result()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $datetime = $this->db->query("SELECT NOW() AS datetime");
            $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid");

            // $barcode = $this->input->post('barcode');
            if(isset($_REQUEST['barcode']))
            {
                $barcode = $_REQUEST['barcode'];
            }
            else
            {
                $barcode = $this->input->post('barcode');
            }

            $barcode = $this->main_model->decode_barcode_general($barcode);
           
            

            $check_barcode = $this->db->query("SELECT if(b.none_return = 1, 999, b.none_return) as sort,priority_vendor, none_return,a.* from backend.itembarcode a  inner join backend.itemmastersupcode b on a.itemcode = b.itemcode where barcode ='$barcode' order by sort asc, priority_vendor asc limit 1");

            if($check_barcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Bar Code does not exist : ' .$barcode);
                redirect('greturn_controller/dn_scan_item');
            };

            if($check_barcode->row('none_return') == '1')
            {
                $this->session->set_flashdata('message', 'Item is mark as none return: ' .$barcode);
                redirect('greturn_controller/dn_scan_item');
            };

            $itemcode = $check_barcode->row('Itemcode');
            $code = '';
            $result_barcode = $this->db->query("
                    SELECT '$code'=a.code AS CODE,a.name, concat(a.code, ' -> ' , a.name) as supplier, a.suplastprice
                    FROM
                    (
                    SELECT a.*
                    FROM
                    (
                    SELECT a.refno,b.grdate,a.itemcode,b.code,b.name, unitprice as suplastprice
                    FROM backend.grchild a
                    INNER JOIN backend.grmain b
                        ON a.refno=b.refno
                    WHERE itemcode='$itemcode' AND b.billstatus=1
                    ORDER BY grdate DESC
                    )a
                    LEFT JOIN backend.itemmastersupcode b
                        ON a.itemcode=b.itemcode AND a.code=b.code
                    WHERE b.code<>''
                    ORDER BY grdate DESC
                    )a
                    GROUP BY itemcode

                    UNION ALL

                    SELECT z.CODE,z.NAME, concat(z.CODE, ' -> ' , z.NAME) as supplier, z.suplastprice
                    FROM
                    backend.itemmastersupcode AS z
                    INNER JOIN backend.supcus AS m
                    ON z.code= m.code
                    WHERE itemcode='$itemcode' AND m.CODE<>'$code'
                    AND TYPE='S' 
                    AND stock_returnable=1
                    AND none_return=0 ;");

            if($result_barcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Do not have default supplier : ' .$barcode);
                redirect('greturn_controller/dn_scan_item');
            };
            
            $result_itemmaster = $this->db->query("SELECT * from backend.itemmaster where Itemcode ='$itemcode'");
            $getDept = $this->db->query('SELECT description FROM backend.department WHERE CODE="'.$result_itemmaster->row('Dept').'"');

            $getReason = $this->db->query('SELECT code_desc FROM backend.set_master_code WHERE TRANS_TYPE="DN_REASON" ORDER BY code_Desc');

            $data = array(
                'description' => $check_barcode->row('barDesc'),
                'dept' => $getDept->row('description'),
                'sup_name' => $result_barcode,
                'reason' => $getReason,
                'edit_mode' => 'new',
                'barcode' => $barcode,
                'qty' => $_SESSION['decode_qty'],
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greturn/dn_item_fast_add', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greturn/dn_item_fast_add', $data);
                    $this->load->view('footer');
                }    
                        
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function dn_item_fast_add()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $datetime = $this->db->query("SELECT NOW() AS datetime");
            $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid");

            $supplier = explode(' -> ', $this->input->post('supplier'));
            $barcode = $this->input->post('barcode');

            $check_barcode = $this->greturn_model->check_barcode($barcode);

            $itemcode = $check_barcode->row('Itemcode');
            
            $result_barcode = $this->greturn_model->result_barcode($itemcode);
            $result_itemmaster = $this->greturn_model->result_itemmaster($itemcode);

            if( $this->input->post('reason') == '')
            {
                $_SESSION['dnbarcode'] ==  $this->input->post('barcode');
                $this->session->set_flashdata('message', 'Item not added. Please key in qty again and select a reason.');
                redirect('greturn_controller/scan_item_result?barcode='.$barcode);
            };

            $item_guid = $guid->row('guid');
            $data = array(
                'item_guid' => $item_guid,
                'location_from' => $_SESSION['location'],
                'location_to' => $_SESSION['location'],
                
                'itemcode' => $check_barcode->row('Itemcode'),
                'description' => addslashes($check_barcode->row('barDesc')),
                
                'itemlink' => $result_itemmaster->row('ItemLink'),
                'packsize' => $result_itemmaster->row('PackSize'),
                'dept' => $result_itemmaster->row('Dept'),
                'subdept' => $result_itemmaster->row('SubDept'),
                'category' => $result_itemmaster->row('Category'),
                'AverageCost' => $result_itemmaster->row('AverageCost'),
                'um' => $result_itemmaster->row('UM'),
                
                'sup_code' => $supplier[0],
                'sup_name' => addslashes($supplier[1]),
                'lastcost' => $this->db->query("SELECT suplastprice FROM backend.`itemmastersupcode` WHERE itemcode = '$itemcode' AND CODE = '$supplier[0]' ")->row('suplastprice'),

                'qty' => $this->input->post('qty'),
                'reason' => $this->input->post('reason'),
                'scan_barcode' => $barcode,

                'created_at' => $datetime->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at' => $datetime->row('datetime'),
                'updated_by' => $_SESSION['username'],
                );


            $this->greturn_model->insert_item($data);
            $this->db->query("UPDATE dbnote_basket a INNER JOIN itemmaster b ON a.itemcode=b.itemcode SET a.itemlink=b.itemlink,a.packsize=b.packsize,a.description=b.description, a.dept=b.dept,a.subdept=b.subdept,a.category=b.category,a.averageCost=b.averagecost, a.lastcost=b.lastcost,a.um=b.um,a.sellingprice=b.sellingprice WHERE item_guid='$item_guid' ");
            unset($_SESSION['decode_qty']);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', 'Success.');
                redirect('greturn_controller/dn_scan_item');
            }
            else
            {
                $this->session->set_flashdata('message', 'Failed.');
                redirect('greturn_controller/dn_scan_item');
            }

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function dn_item_edit()
    {
        $dbnote_item = $this->db->query("SELECT * from backend.dbnote_basket where item_guid='".$_REQUEST['item_guid']."'");

        $result_itembarcode = $this->db->query("SELECT * from backend.itembarcode where barcode ='".$dbnote_item->row('scan_barcode')."'");

        $result_itemmaster = $this->db->query("SELECT * from backend.itemmaster where Itemcode ='".$result_itembarcode->row('Itemcode')."'");

        if($dbnote_item->num_rows() > 0)
        {
            $qty = $dbnote_item->row('qty');
        }
        else
        {
            $qty = '';
        }

        $itemcode = $result_itembarcode->row('Itemcode'); 
        $code = '';
        $result_barcode = $this->db->query("
                    SELECT '$code'=a.code AS CODE,a.name, concat(a.code, ' -> ' , a.name) as supplier, a.suplastprice
                    FROM
                    (
                    SELECT a.*
                    FROM
                    (
                    SELECT a.refno,b.grdate,a.itemcode,b.code,b.name, unitprice as suplastprice
                    FROM backend.grchild a
                    INNER JOIN backend.grmain b
                        ON a.refno=b.refno
                    WHERE itemcode='$itemcode' AND b.billstatus=1
                    ORDER BY grdate DESC
                    )a
                    LEFT JOIN backend.itemmastersupcode b
                        ON a.itemcode=b.itemcode AND a.code=b.code
                    WHERE b.code<>''
                    ORDER BY grdate DESC
                    )a
                    GROUP BY itemcode

                    UNION ALL

                    SELECT z.CODE,z.NAME, concat(z.CODE, ' -> ' , z.NAME) as supplier, z.suplastprice
                    FROM
                    backend.itemmastersupcode AS z
                    INNER JOIN backend.supcus AS m
                    ON z.code= m.code
                    WHERE itemcode='$itemcode' AND m.CODE<>'$code'
                    AND TYPE='S' 
                    AND stock_returnable=1
                    AND none_return=0 ;");

        $getReason = $this->db->query('SELECT code_desc FROM backend.set_master_code WHERE TRANS_TYPE="DN_REASON" ORDER BY code_Desc');

        $data = array(
                'last_supplier' => $this->db->query("SELECT CONCAT(sup_code, ' -> ', sup_name ) AS supplier FROM backend.dbnote_basket WHERE item_guid='".$_REQUEST['item_guid']."' ")->row('supplier'),
                'last_reason' => $this->db->query("SELECT reason FROM backend.dbnote_basket WHERE item_guid='".$_REQUEST['item_guid']."' ")->row('reason'),
                'description' => $result_itembarcode->row('barDesc'),
                'sup_name' => $result_barcode,
                'reason' => $getReason,
                'edit_mode' => $_REQUEST['edit_mode'],
                'barcode' => $dbnote_item->row('scan_barcode'),
                'itemcode' => $result_itembarcode->row('Itemcode'),
                'qty' => $qty,
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greturn/dn_item_edit', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greturn/dn_item_edit', $data);
                    $this->load->view('footer');
                }    
            
    }

    public function dn_item_edit_update()
    {
        $item_guid = $this->input->post('item_guid');
        $supplier = explode(' -> ', $this->input->post('supplier'));
        $datetime = $this->db->query("SELECT NOW() AS datetime");
        $getSupplier = $this->db->query("SELECT b.Name,b.Code FROM backend.itemmastersupcode a INNER JOIN backend.supcus b ON a.CODE=b.CODE AND b.TYPE='S' WHERE a.itemcode='".$this->input->post('itemcode')."' AND b.Name='".addslashes($this->input->post('supplier'))."';");

        $data = array(

            'sup_code' => $supplier[0],
            'sup_name' => addslashes($supplier[1]),
            'lastcost' => $this->db->query("SELECT suplastprice FROM backend.`itemmastersupcode` WHERE itemcode = '$itemcode' AND CODE = '$supplier[0]' ")->row('suplastprice'),

            'reason'=> $this->input->post('reason'),
            'qty'=> $this->input->post('qty'),

            'updated_at' => $datetime->row('datetime'),
            'updated_by' => $_SESSION['username'],
            );

        $this->greturn_model->edit_item($data, $item_guid);
        if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', 'Success.');
                redirect('greturn_controller/dn_item_list?sup_code='.$supplier[0]);
            }
            else
            {
                $this->session->set_flashdata('message', 'Failed');
                redirect('greturn_controller/dn_item_list?sup_code='.$supplier[0]);
            }
        
    }


    public function dn_list()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $data['dn_list']=$this->greturn_model->dn_list();
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            	{
            		$this->load->view('WinCe/header');
            		$this->load->view('WinCe/greturn/dn_list', $data);
            	}
            else 
            	{
            		$this->load->view('header');
            		$this->load->view('greturn/dn_list', $data);
            		$this->load->view('footer');
            	}	
            
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function dn_item_list()
    {
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $sup_code = $_REQUEST['sup_code'];

            $data['result']=$this->greturn_model->dn_item_list($sup_code);

  			$browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            	{
            		$this->load->view('WinCe/header');
            		$this->load->view('WinCe/greturn/dn_item_list', $data);
            	}
            else
            	{
            		$this->load->view('header');
            		$this->load->view('greturn/dn_item_list', $data);
            		$this->load->view('footer');
            	}	
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function delete_item()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $item_guid = $_REQUEST['item_guid'];

            $this->greturn_model->delete_item($item_guid);
            if($this->db->affected_rows() > 0)
            {

                $this->session->set_flashdata('message', 'Succesfully Delete. ');
                redirect('greturn_controller/dn_item_list?sup_code='.$_REQUEST['sup_code']);
            }
            else
            {
                $this->session->set_flashdata('message', 'Failed to Delete. ');
                redirect('greturn_controller/dn_item_list?sup_code='.$_REQUEST['sup_code']);
            }

        }
        else
        {
            redirect('main_controller');
        }
    }
    
}
?>