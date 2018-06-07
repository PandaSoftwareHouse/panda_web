<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sipick_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('Sipick_model');
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


    public function index()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {


            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/sipick/scan_reqNO');
            }
            else
            {
                $this->load->view('header');
                $this->load->view('sipick/scan_reqNO');
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
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        { 

            if(isset($_REQUEST['refno']))
            {
                $req_NO = $_REQUEST['refno'];
            }
            else
            {
                $req_NO = $this->input->post('req_NO');
            }

            $result = $this->db->query("SELECT refno,BillStatus FROM somain WHERE refno='$req_NO'");

            if($result->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'SI Doc No not found : '.$req_NO);
                redirect('sipick_controller');
            };

            if($result->row('BillStatus') == '0')
            {
                $this->session->set_flashdata('message', 'SI Doc No not posted yet : '.$req_NO);
                redirect('sipick_controller');
            };

            $_SESSION['si_refno'] = $result->row('refno');
            $req_NO = $_SESSION['si_refno'];
            $data = array(
                'si_refno' => $_SESSION['si_refno'],
                'result' => $this->Sipick_model->itemlist($req_NO)
                );


            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))    
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/sipick/scan_item', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('sipick/scan_item', $data);
                    $this->load->view('footer');
                }    
            

        }
        else
        {
            redirect('main_controller');
        }
        
    }

    public function scan_item_error()
    {
        $req_NO = $_SESSION['si_refno'];

        $data = array(
                'si_refno' => $_SESSION['si_refno'],
                'result' => $this->Sipick_model->itemlist($req_NO)
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))    
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/sipick/scan_item', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('sipick/scan_item', $data);
                    $this->load->view('footer');
                }    
            
    }


    public function scan_item_result()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            if(isset($_REQUEST['exist_barcode']))
            {
                $barcode = $_REQUEST['exist_barcode'];
                $_SESSION['scan_barcode'] = $barcode;
            }
            else
            {
                $barcode = $this->input->post('barcode');
                $_SESSION['scan_barcode'] = $barcode;
            }

            $check_barcode = $this->db->query("SELECT a.`itemlink`,a.`itemcode`,a.description FROM itemmaster a INNER JOIN itembarcode b ON a.`itemcode`=b.`itemcode` where b.barcode='$barcode' ");
            
            if($check_barcode->num_rows() == 0)
            {
                $barcode = $this->main_model->decode_barcode_general($barcode);
                if($this->input->post('barcode') == $barcode)
                {
                    $this->session->set_flashdata('message', 'Barcode not found : '.$this->input->post('barcode'));
                    redirect('sipick_controller/scan_item_error');
                }
                else
                {
                    redirect('sipick_controller/scan_item_result?exist_barcode='.$barcode);
                }
            };

            if($check_barcode->num_rows() > 0 && !isset($_REQUEST['exist_barcode']))
            {
                //echo $this->db->last_query();die;
                $_SESSION['decode_qty'] = 0;
            }

            $si_req_child = $this->db->query("SELECT a.line,a.`itemcode`,b.`itemlink`,a.description,a.um,a.BalanceQty,a.qty_mobile,a.packsize FROM sochild a INNER JOIN itemmaster b ON a.`Itemcode`=b.`Itemcode` WHERE a.refno = '".$_SESSION['si_refno']."' and b.itemlink='".$check_barcode->row('itemlink')."'");

            if($si_req_child->num_rows() == 0)
            {
                $this->session->set_flashdata('message', $check_barcode->row('description').': not in request list');
                redirect('sipick_controller/scan_item_error');
            };

            
            $_SESSION['si_itemcode'] = $si_req_child->row('itemcode');
            $_SESSION['si_description'] = $si_req_child->row('description');
            $_SESSION['si_itemlink'] = $si_req_child->row('itemlink');

            $_SESSION['si_um'] = $si_req_child->row('um');
            $_SESSION['si_qty'] = $si_req_child->row('BalanceQty');
            $_SESSION['si_qty_mobile'] = $si_req_child->row('qty_mobile');
            $_SESSION['si_packsize'] = $si_req_child->row('packsize');
            $_SESSION['si_line'] = $si_req_child->row('line');

            $data = array(
                'si_refno' => $_SESSION['si_refno'],
                'si_description' => addslashes($_SESSION['si_description']),
                'iteminfo' => 'P/S: '.$_SESSION['si_packsize'].'   UOM: '.$_SESSION['si_um'],
                'si_qty' => $_SESSION['si_qty'],

                'si_qty_mobile' => $_SESSION['si_qty_mobile']+$_SESSION['decode_qty'],
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE")) 
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/sipick/item_entry', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('sipick/item_entry', $data);
                    $this->load->view('footer');
                }
           
        }

        else
        {
            redirect('main_controller');
        }
    }

    public function item_entry_add()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $qty_mobile = $this->input->post('qty_mobile');
            
            $this->Sipick_model->item_entry_add($qty_mobile);

            $get_item_guid = $this->db->query("SELECT * FROM backend_warehouse.`d_batch_scan_log` a WHERE a.`type` = 'SI PICK' AND a.scan_itemcode = '".$_SESSION['si_itemcode']."'");
            //echo $this->db->last_query();die;
            if($get_item_guid->num_rows() == 0)
            {
                $item_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid');
            }
            else
            {
                $item_guid = $get_item_guid->row('item_guid');
            }

            $data = array(

                'item_guid' => $item_guid ,
                'scan_guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid') ,
                'lineno' => $this->db->query("SELECT COUNT(*)+1 AS reccount FROM backend_warehouse.d_batch_scan_log WHERE item_guid = '$item_guid' ")->row('reccount'),
                'type' => 'SI PICK',
                'refno' => $_SESSION['si_refno'],
                'scan_barcode' => $_SESSION['scan_barcode'],
                'scan_itemcode' => $_SESSION['si_itemcode'],
                'scan_description' => addslashes($_SESSION['si_description']),
                'scan_itemlink' => $_SESSION['si_itemlink'],
                'scan_packsize' => $_SESSION['si_packsize'],
                'scan_as_itemcode' => '0',
                'scan_qty' => $qty_mobile,

                'scan_weight' => '',
                'created_at' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at'=> $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                'updated_by' => $_SESSION['username'],
            );

            $this->db->insert('backend_warehouse.d_batch_scan_log', $data);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', 'Success.');
                redirect('sipick_controller/scan_item_error');
            }
            else
            {
                $this->session->set_flashdata('message', 'Failed.');
                redirect('sipick_controller/scan_item_error');
            }
            
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function itemlist()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $req_NO = $_REQUEST['si_refno'];

            $data['result'] = $this->Sipick_model->itemlist($req_NO);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE")) 
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/sipick/itemlist', $data);
            
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('sipick/itemlist', $data);
                    $this->load->view('footer');
                }    
            
            
        }
        else
        {
            redirect('main_controller');
        }

    }
    
}
?>