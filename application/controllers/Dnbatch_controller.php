<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dnbatch_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('dnbatch_model');
        $this->load->model('general_scan_model');
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

    public function main()
    {
        if($this->session->userdata('login') == false)
        {
            $data = array( 
                'result' => $this->db->query("SELECT * FROM dbnote_batch WHERE converted=0 AND canceled=0 
                 AND DATE(created_at)=DATE(NOW()) 
                 AND created_by='".$_SESSION['username']."'  ORDER BY created_at DESC"),
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/dnbatch/main', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('dnbatch/main', $data);
                    $this->load->view('footer');
                }    
        }
        else
        {
           redirect('main_controller');
        }
    }

    public function scan_supplier()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/dnbatch/scan_supplier');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('dnbatch/scan_supplier');
                    $this->load->view('footer');
                }    
        }  
        else
        {
          redirect('main_controller');
        } 
    }

     public function scan_supresult()
    {
        
        if($this->session->userdata('loginuser')== true)
        {
            
            $check_supbarcode = $this->db->query("SELECT a.itemcode,a.barcode,a.bardesc, c.description,b.name,b.code FROM itembarcode a INNER JOIN itemmastersupcode b ON a.itemcode=b.itemcode INNER JOIN itemmaster c ON c.itemcode=b.itemcode WHERE barcode='".$this->input->post('barcode')."' GROUP BY b.code");

            if ($check_supbarcode->num_rows() == 1)
            {

            $data = array(
                'dnbatch_itemcode' => $check_supbarcode->row('itemcode'),
                'dnbatch_barcode' => $this->input->post('barcode'),
                'dnbatch_sup_code' => addslashes($check_supbarcode->row('code')),
                'dnbatch_sup_name' => addslashes($check_supbarcode->row('name')),
                'dnbatch_description' => addslashes($check_supbarcode->row('description')),
                );
            $this->session->set_userdata($data);
            redirect('dnbatch_controller/scan_supconfirm?sup_code='.$check_supbarcode->row('code'));
            }
            elseif ($check_supbarcode->num_rows() > 1)
            {

            $data = array(
                'dnbatch_itemcode' => $check_supbarcode->row('itemcode'),
                'dnbatch_barcode' => $this->input->post('barcode'),
                'dnbatch_description' => addslashes($check_supbarcode->row('description')),
                );
            $supplier_result = array (
                'result' => $this->db->query("SELECT a.itemcode,a.barcode,a.bardesc, c.description,b.name,b.code FROM itembarcode a INNER JOIN itemmastersupcode b ON a.itemcode=b.itemcode INNER JOIN itemmaster c ON c.itemcode=b.itemcode WHERE barcode='".$this->input->post('barcode')."' GROUP BY b.code"),
                );
            $this->session->set_userdata($data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/dnbatch/scan_suplist', $supplier_result);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('dnbatch/scan_suplist', $supplier_result);
                    $this->load->view('footer');
                }    

            }
            else 
            {   
                $this->session->set_flashdata('message', 'Supplier not found : '.$this->input->post('barcode'));
                $_SESSION['dnbatch_itemcode'] = '';
                $_SESSION['dnbatch_barcode'] = '';
                $_SESSION['dnbatch_sup_code'] = '';
                $_SESSION['dnbatch_sup_name'] = '';
                $_SESSION['dnbatch_description'] = '';
                redirect('dnbatch_controller/scan_supplier');
            }
        } 
        else
        {
           redirect('main_controller/home');
        } 
    }

    public function scan_supconfirm()
    {
        if($this->session->userdata('loginuser')== true)
        {
        $supdetail = $this->db->query("SELECT * FROM supcus WHERE TYPE= 'S' AND CODE = '".$_REQUEST['sup_code']."'");
        $data = array(
            'supdetail' => $supdetail,
            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/dnbatch/scan_supconfirm', $data);
            }
        else
            {
                $this->load->view('header');
                $this->load->view('dnbatch/scan_supconfirm', $data);
                $this->load->view('footer');
            }    
        }
        else
        {
            redirect('main_controller');
        }

    }

    public function create_batch()
    {
        if($this->session->userdata('loginuser')== true)
        {
        $supdetail = $this->db->query("SELECT code,name FROM supcus WHERE TYPE= 'S' AND CODE = '".$_REQUEST['sup_code']."'");
        $checkdate = $this->db->query("SELECT YEAR(NOW()) AS getYear,MONTH(NOW()) AS getMonth");
        $checkDNBAT = $this->db->query("SELECT * from sysrun where type='DNBAT'");

        if($checkDNBAT->num_rows() == 0)
        {
             $this->dnbatch_model->insertsysrun();
        };
        if($checkDNBAT->row('YYYY') != $checkdate->row('getYear') || $checkDNBAT->row('MM') != $checkdate->row('getMonth') )
        {
            $this->dnbatch_model->updatesysrun();
        };

        $this->dnbatch_model->updaterunningnum();
        $resultDNBAT = $this->db->query("SELECT * from sysrun where type='DNBAT'");

        $data = array(
            'batch_no' =>$this->db->query("SELECT CONCAT(Code, YYYY, LPAD(MM,2,0) ,LPAD(CurrentNo, NoDigit, 0)) as batch_no FROM sysrun WHERE TYPE = 'DNBAT'")->row('batch_no') ,
            'dnbatch_sup_code' => $supdetail->row('code'),
            'dnbatch_sup_name' => addslashes($supdetail->row('name')),

            );
        $this->session->set_userdata($data);
        $this->dnbatch_model->insert_batchno();

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                redirect("dnbatch_controller/itemlist?batch_no=".$_SESSION['batch_no']);
            }
        else
            {
                $this->load->view('header');
                redirect("dnbatch_controller/itemlist?batch_no=".$_SESSION['batch_no']);
                $this->load->view('footer');
            }    
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function itemlist()
    {
        if($this->session->userdata('loginuser')== true)
        {
        $checkbatch = $this->db->query("SELECT * from dbnote_batch WHERE batch_no='".$_REQUEST['batch_no']."'");

        $data = array(
            'result' => $this->db->query("SELECT IF(b.item_guid IS NOT NULL ,'BATCH','QTY') AS scan_type,b.scan_guid,b.item_guid,a.*    
                FROM 
                (SELECT qty, description, dbnote_guid, dbnote_c_guid , itemcode , created_at
                 FROM backend.dbnote_batch_c 
                 WHERE dbnote_guid='".$checkbatch->row('dbnote_guid')."') a
                LEFT JOIN (
                SELECT * FROM backend_warehouse.`d_batch_scan_log` WHERE `type` = 'Dn Batch' AND deleted = '0')b 
                ON a.itemcode = b.scan_itemcode 
                GROUP BY a.itemcode ORDER BY a.created_at DESC"),
            );

        $session = array (
            'dbnote_guid' => $checkbatch->row('dbnote_guid'),
            'batch_no' => $checkbatch->row('batch_no'),
            'sup_code' => $checkbatch->row('sup_code'),
            'sup_name' => addslashes($checkbatch->row('sup_name')),
            );
        $this->session->set_userdata($session);

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/dnbatch/itemlist', $data);
            }
        else
            {
                $this->load->view('header');
                $this->load->view('dnbatch/itemlist', $data);
                $this->load->view('footer');
            }    
        }
        else
        {
            redirect('main_controller');
        }
    }

    
    public function scan_item()
    {
        if($this->session->userdata('loginuser')== true)
        {
            
            $batch_no = $_SESSION['batch_no'];

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/dnbatch/scan_item');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('dnbatch/scan_item');
                    $this->load->view('footer');
                }    
        }  
        else
        {
          redirect('main_controller');
        } 
    }

    public function scan_itemresult()
    {
        
        if($this->session->userdata('loginuser')== true)
        {
            if ($this->input->post('barcode') != '')
            {
                //$barcode = $this->input->post('barcode');
                $barcode = $this->main_model->decode_barcode_general($this->input->post('barcode'));
    
            }
            else
            {
                $barcode = $this->db->query("SELECT scan_barcode from dbnote_batch_c where dbnote_c_guid = '".$_REQUEST['dbnote_c_guid']."'")->row('scan_barcode');
            }
            // $check_barcode = $this->db->query("SELECT a.itemcode,a.barcode,a.bardesc, c.description,b.name,b.code,c.tax_code_supply FROM itembarcode a INNER JOIN itemmastersupcode b ON a.itemcode=b.itemcode INNER JOIN itemmaster c ON c.itemcode=b.itemcode WHERE barcode='$barcode' AND b.code='".$_SESSION['sup_code']."' GROUP BY b.code");
            
            $check_barcode = $this->db->query("SELECT * FROM (
                SELECT a.itemcode,a.barcode,a.bardesc, c.description,b.name,b.code , c.`tax_code_supply`,c.tax_code_purchase
                FROM itembarcode a 
                INNER JOIN itemmastersupcode b ON a.itemcode=b.itemcode 
                INNER JOIN itemmaster c ON c.itemcode=b.itemcode 
                WHERE barcode='$barcode' AND b.code='".$_SESSION['sup_code']."' GROUP BY b.code ) a

                LEFT JOIN 

                (SELECT a.refno , a.podate , b.barcode
                FROM backend.pomain AS a
                LEFT JOIN 
                pochild AS b
                ON a.refno = b.refno
                WHERE b.barcode = '$barcode'
                AND a.billstatus = '1' 
                ORDER BY a.podate DESC
                LIMIT 1)ab
                ON a.barcode =ab.barcode");


            $sup_name = $this->db->query("SELECT a.itemcode,a.barcode,a.bardesc, c.description,b.name,b.code FROM itembarcode a INNER JOIN itemmastersupcode b ON a.itemcode=b.itemcode INNER JOIN itemmaster c ON c.itemcode=b.itemcode WHERE barcode='$barcode' AND b.code='".$_SESSION['sup_code']."' GROUP BY b.code")->row('name');
            
            if(isset($_SESSION['decode_qty']))
            {
                $scan_qty = $_SESSION['decode_qty'];
            }
            else
            {
                $scan_qty = 0;
            }

            $qty_default = $this->db->query("SELECT qty FROM dbnote_batch_c where scan_barcode = '$barcode' AND dbnote_guid = '".$_SESSION['dbnote_guid']."'")->row('qty');

            if ($check_barcode->num_rows() > 0)
            {
                $data = array(
                    'item' => $check_barcode,
                    'qty'=> $qty_default+$scan_qty,
                    'scan_barcode' => $this->input->post('barcode'),
                    );

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/dnbatch/scan_itemresult', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('dnbatch/scan_itemresult', $data);
                    $this->load->view('footer');
                }    
            }
            else 
            {   
                $this->session->set_flashdata('message', 'Barcode '.$barcode.' not found in supplier : '.$sup_name);
                redirect('Dnbatch_controller/scan_item');
            }
        } 
        else
        {
           redirect('main_controller/home');
        } 
    } 

    public function add_qty()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $itemcode = $this->input->post('itemcode');
            $barcode = $this->input->post('barcode');
            $iqty = $this->input->post('iqty');
            $batch_no = $this->input->post('batch_no');
            $description = $this->input->post('description');
            $scan_barcode = $this->input->post('scan_barcode');
            $decode_qty = $this->input->post('decode_qty');
            $dbnote_c_guid = $this->db->query("SELECT dbnote_c_guid FROM dbnote_batch_c where scan_barcode = '$barcode' AND dbnote_guid = '".$_SESSION['dbnote_guid']."'")->row('dbnote_c_guid');

        if (strpos($scan_barcode , '*')) 
            {
                if ($dbnote_c_guid != '')
                {
                    $this->dnbatch_model->update_qty($dbnote_c_guid,$iqty);
                    $this->dnbatch_model->update_dbnote_c();
                }
                else
                {   
                    $dbnote_c_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid');
                    $this->dnbatch_model->insert_dbnote_c($dbnote_c_guid,$itemcode, $iqty, $barcode);
                    $this->dnbatch_model->update_dbnote_c();            
                }

                $item_guid = $dbnote_c_guid;

                $data = array(

                        'item_guid' => $item_guid,
                        'scan_guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid') ,
                        'lineno' => $this->db->query("SELECT COUNT(*)+1 AS reccount FROM backend_warehouse.d_batch_scan_log WHERE item_guid = '$item_guid' ")->row('reccount'),
                        'type' => 'Dn Batch',
                        'refno' => $batch_no,
                        'scan_barcode' => $scan_barcode,
                        'scan_itemcode' =>  $itemcode,
                        'scan_description' => $description,
                        'scan_itemlink' => $this->db->query("SELECT itemlink FROM backend.`itemmaster` WHERE itemcode = '$itemcode'")->row('itemlink'),
                        'scan_packsize' => '0',
                        'scan_as_itemcode' => '0',
                        'scan_qty' => $decode_qty,
                        'scan_weight' => '',
                        'created_at' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                        'created_by' => $_SESSION['username'],
                        'updated_at'=> $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                        'updated_by' => $_SESSION['username'],
                );
                $this->db->insert('backend_warehouse.d_batch_scan_log', $data);
                unset($_SESSION['decode_qty']);
            }
        else
            {
                if ($dbnote_c_guid != '')
                {
                    $this->dnbatch_model->update_qty($dbnote_c_guid,$iqty);
                    $this->dnbatch_model->update_dbnote_c();
                }
                else
                {
                    $dbnote_c_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid');
                    $this->dnbatch_model->insert_dbnote_c($dbnote_c_guid,$itemcode, $iqty, $barcode);
                    $this->dnbatch_model->update_dbnote_c();            
                }
            }

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/dnbatch/scan_item');
            }
        else
            {
                $this->load->view('header');
                $this->load->view('dnbatch/scan_item');
                $this->load->view('footer');
            }    
        }
        else
        {
           redirect('main_controller');
        }
    }


    public function scan_log()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $data = array(
                'result' => $this->db->query("SELECT * FROM backend_warehouse.`d_batch_scan_log` WHERE `type` = 'Dn Batch' AND refno = '".$_REQUEST['batch_no']."' AND deleted = '0'"),
                'back_button' => site_url('Dnbatch_controller/itemlist?batch_no='.$_REQUEST['batch_no'])
            );


            $this->load->view('header');
            $this->load->view('dnbatch/scan_log' , $data);
            $this->load->view('footer');
        }
        else
        {
           redirect('main_controller');
        }    
    }

    public function delete_scan_log()
    {
        if($this->session->userdata('loginuser')== true)
        {   

            $get_scan_qty = $this->db->query("SELECT scan_qty FROM backend_warehouse.`d_batch_scan_log` WHERE scan_guid = '".$_REQUEST['scan_guid']."'")->row('scan_qty');
            $dbnote_batch_c = $this->db->query("UPDATE dbnote_batch_c SET qty = qty-$get_scan_qty WHERE dbnote_c_guid = '".$_REQUEST['item_guid']."' ");
            $scan_log_c = $this->db->query("UPDATE backend_warehouse.`d_batch_scan_log` SET deleted = '1' , deleted_at = NOW() , deleted_by = '".$_SESSION['username']."' WHERE scan_guid = '".$_REQUEST['scan_guid']."'");
            $check_dbnote_batch_c = $this->db->query("SELECT qty FROM dbnote_batch_c WHERE dbnote_c_guid = '".$_REQUEST['item_guid']."'");

            if($check_dbnote_batch_c->row('qty') == '0')
            {
                $this->db->query("DELETE FROM dbnote_batch_c WHERE dbnote_c_guid = '".$_REQUEST['item_guid']."'");
                redirect('Dnbatch_controller/itemlist?batch_no='.$_REQUEST['batch_no']);
            }
            else
            {
                redirect('Dnbatch_controller/scan_log?batch_no='.$_REQUEST['batch_no']); 
            }

             
        }
        else
        {
           redirect('main_controller');
        }    
    }

     public function delete_batch()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $dbnote_guid = $_REQUEST['dbnote_guid'];
            $deletem = $this->db->query("DELETE FROM dbnote_batch where dbnote_guid = '$dbnote_guid'");
            $deletec = $this->db->query("DELETE FROM dbnote_batch_c where dbnote_guid = '$dbnote_guid'");
            redirect('Dnbatch_controller/main');
        }
         else
        {
           redirect('main_controller');
        } 
    }

         public function delete_item()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $dbnote_c_guid = $_REQUEST['dbnote_c_guid'];
            $dbnote_guid = $_REQUEST['dbnote_guid'];
            $batch_no = $this->db->query("SELECT batch_no from dbnote_batch where dbnote_guid = '$dbnote_guid'")->row('batch_no');
            $deletec = $this->db->query("DELETE FROM dbnote_batch_c where dbnote_c_guid = '$dbnote_c_guid'");
            redirect('Dnbatch_controller/itemlist?batch_no='.$batch_no);
        }
         else
        {
           redirect('main_controller');
        } 
    }


    public function print_job()
    {
         if($this->session->userdata('loginuser')== true)
        {
            $printed = $this->db->query("UPDATE dbnote_batch SET send_print='1' WHERE dbnote_guid='".$_SESSION['dbnote_guid']."'");
            redirect('Dnbatch_controller/itemlist?batch_no='.$_SESSION['batch_no']);
        }
    }

    public function search_refno()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $batch_no = $this->input->post('batch_no');
            $checkrecord = $this->db->query("SELECT * FROM dbnote_batch where batch_no ='$batch_no'");
            if($checkrecord->num_rows() > 0)
            {
                $data = array ( 
                    'result' => $checkrecord,
                    );

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        redirect("dnbatch_controller/itemlist?batch_no=$batch_no");
                    }
                else
                    {
                        $this->load->view('header');
                        redirect("dnbatch_controller/itemlist?batch_no=$batch_no");
                        $this->load->view('footer');
                    }    
            }
            else
            {
                $this->session->set_flashdata('message', 'Batch No. not found :'.$this->input->post('batch_no'));
                $data = array( 
                'result' => $this->db->query("SELECT * FROM dbnote_batch WHERE converted=0 AND canceled=0 
                 AND DATE(created_at)=DATE(NOW()) 
                 AND created_by='".$_SESSION['username']."'  ORDER BY created_at DESC"),
                );

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/dnbatch/main', $data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('dnbatch/main', $data);
                        $this->load->view('footer');
                    }    
            }
        }

    }

}
?>