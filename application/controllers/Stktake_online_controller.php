<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class stktake_online_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('stktake_online_model');
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
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $query = $this->db->query('SELECT CURDATE() as curdate');
            $curdate['curdate'] = $query->row('curdate');
            $sessiondata = array(
                'stktake_date' => $query->row('curdate'));

            $this->session->set_userdata($sessiondata);
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/stktake_online/main', $sessiondata);
           
                 }
            else
                {
                    $this->load->view('header');
                    $this->load->view('stktake_online/main', $sessiondata);
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
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        { 
            // $stktake_date = $_REQUEST['stktake_date'];
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/stktake_online/scan_item');
                    
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('stktake_online/scan_item');
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
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        { 
        
        $barcode = $this->input->post('barcode');

        $check_barcode = $this->db->query("SELECT a.itemlink,a.packsize,a.itemcode,a.price_include_tax,a.description,b.barcode 
        FROM backend.itemmaster a INNER JOIN backend.itembarcode b ON a.itemcode=b.itemcode 
        WHERE b.barcode='$barcode'");

            if($check_barcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Barcode Not Exist. ');
                redirect('stktake_online_controller/scan_item');
            };

            $_SESSION['stktake_itemlink'] = $check_barcode->row('itemlink');
            $_SESSION['stktake_packsize'] = $check_barcode->row('packsize');
            $_SESSION['stktake_itemcode'] = $check_barcode->row('itemcode');
            $_SESSION['stktake_description'] = $check_barcode->row('description');
            $_SESSION['stktake_barcode'] = $check_barcode->row('barcode');
            $_SESSION['stktake_price_include_tax'] = $check_barcode->row('price_include_tax');

        $check_itemlink = $this->db->query("SELECT * from backend.stk_take_online where POSTED=0 and ITEMLINK='".$_SESSION['stktake_itemlink']."' and LOCATION='".$_SESSION['location']."' and BIZDATE='".$_SESSION['stktake_date']."' "); 

            if($check_itemlink->num_rows() == 0)
            {
                redirect('stktake_online_controller/itemlink_create');
            }   
            else
            {
                redirect('stktake_online_controller/itemlink_list');
            }

        }
        else
        {
           redirect('main_controller');
        }
    }

    public function itemlink_list()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        { 
            $itemlink = $_SESSION['stktake_itemlink'];
            $description = $_SESSION['stktake_description'];
            $packsize = $_SESSION['stktake_packsize'];
            $session_Data = array(
                                      
                    'itemlink' => $itemlink,
                    'description' => $description,
                    'packsize' => $packsize, 
                    );
            $this->session->set_userdata($session_Data);
            $check_qoh = $this->stktake_online_model->check_qoh($itemlink);
            $check_qty_actual = $this->stktake_online_model->check_qty_actual($itemlink);

            if($check_qoh->num_rows() == 0)
            {
                $data=array(
                    'QOH' => '0',
                    'Act' => (string)round((float)$check_qty_actual->row('QTY_ACTUAL')/
                                    (float)$packsize,2),
                    'Diff' => round((float)$check_qty_actual->row('QTY_ACTUAL')/(float)$packsize,2)
                  -round((float)$check_qoh->row('OnHandStock')/(float)$packsize,2)
                    );
            }
            else
            {
                $data=array(
                    'QOH' => round((float)$check_qoh->row('OnHandStock')/(float)$packsize,2),
                    'Act' => (string)round((float)$check_qty_actual->row('QTY_ACTUAL')/
                                    (float)$packsize,2),
                    'Diff' => round((float)$check_qty_actual->row('QTY_ACTUAL')/(float)$packsize,2)
                  -round((float)$check_qoh->row('OnHandStock')/(float)$packsize,2)
                    );
            }
            $data['itemlink'] = $this->stktake_online_model->itemlink_list($itemlink);
           
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/stktake_online/itemlink_list', $data, $session_Data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('stktake_online/itemlink_list', $data, $session_Data);
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function itemlink_create()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $check_qoh = $this->db->query("SELECT b.itemlink,if(sum(a.OnHandQty*b.packsize) is null,0,round(sum(a.OnHandQty*b.packsize),3)) as OnHandStock from locationstock a inner join itemmaster b on a.itemcode=b.itemcode where b.itemlink='".$_SESSION['stktake_itemlink']."' and a.location='".$_SESSION['location']."' group by b.itemlink");

            // $check_qoh = $this->stktake_online_model->check_qoh($itemlink);

            if($check_qoh->num_rows() == 0)
            {
                $_SESSION['qoh_itemlink'] = '0';
                $QOH = '0';
            }
            else
            {
                $_SESSION['qoh_itemlink'] = $check_qoh->row('OnHandStock');
                $QOH = round((float)$_SESSION['qoh_itemlink']/(float)$_SESSION['stktake_packsize'],2);
            }

            $check_qoh_itemlink = $this->db->query("SELECT b.itemlink,b.price_include_tax,round('".$_SESSION['qoh_itemlink']."'/b.packsize,2) as OnHandQty,b.packsize,b.description,b.itemcode from locationstock a inner join itemmaster b on a.itemcode=b.itemcode where b.itemlink='".$_SESSION['stktake_itemlink']."' and a.location='".$_SESSION['location']."'  group by b.itemlink");

            $data = array(
                'description' => $_SESSION['stktake_description'],
                'packsize' => $_SESSION['stktake_packsize'],
                'QOH' => $QOH,
                'result_itemlink' => $check_qoh_itemlink
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/stktake_online/itemlink_create', $data);
                
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('stktake_online/itemlink_create', $data);
                    $this->load->view('footer');
                }    
            
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function itemlink_create_insert()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $result = $this->db->query("SELECT b.itemlink,round('".$_SESSION['qoh_itemlink']."'/b.packsize,2) as OnHandQty,b.packsize,b.description,b.itemcode from locationstock a inner join itemmaster b on a.itemcode=b.itemcode where b.itemlink='".$_SESSION['stktake_itemlink']."' and a.location='".$_SESSION['location']."'");
            //echo $this->db->last_query();die;
            if($result->num_rows() != 0)// have item inside
            {   
                foreach ($result->result() as $value) 
                {

                $data = array(
                    'TRANS_GUID' =>  $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid'),
                    'BIZDATE' => $_SESSION['stktake_date'] ,
                    'LOCATION' =>  $_SESSION['location'] ,
                    'ITEMCODE' =>  $value->itemcode,
                    'ITEMLINK' =>  $value->itemlink,
                    'PACKSIZE' =>  $value->packsize,
                    'DESCRIPTION' =>  addslashes($value->description) ,
                    'QTY_CURR' =>  $value->OnHandQty,
                    'QTY_ACTUAL' =>  '0' ,
                    'QTY_DIFF' =>  (string)(-1*(float)$value->OnHandQty),
                    'BARCODE' =>  $_SESSION['stktake_barcode'],

                    'CREATED_AT' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                    'CREATED_BY' => $_SESSION['username'],
                    'UPDATED_AT' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                    'UPDATED_BY' => $_SESSION['username'],

                    'POSTED' =>'0',
                    'NOT_IN_STOCK' =>'0',
                    'ADJUST_REFNO' =>'', 
                    );
                $this->stktake_online_model->itemlink_create_insert($data);

                } 

                $this->db->query("UPDATE stk_take_online a INNER JOIN itemmaster b ON a.itemcode=b.itemcode SET a.AverageCost=b.AverageCost, a.LastCost=b.LastCost where BIZDATE='".$_SESSION['stktake_date']."' ");
                   //die;
                     redirect('stktake_online_controller/itemlink_list');
            }
            
            else
            {
                redirect('stktake_online_controller/itemlink_notin_locationstock');
            }
          
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function itemlink_notin_locationstock()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            //Creating Stock that NOT Exist in Location Stock
            $result = $this->db->query("SELECT a.itemlink,round('".$_SESSION['qoh_itemlink']."'/a.packsize,2) as OnHandQty,a.packsize,a.description,a.itemcode from itemmaster a left join (select itemcode from stk_take_online where BIZDATE='".$_SESSION['stktake_date']."' and itemlink='".$_SESSION['stktake_itemlink']."' and location='".$_SESSION['location']."') b on a.itemcode=b.itemcode where b.itemcode is null and itemlink='".$_SESSION['stktake_itemlink']."' ");

           // echo $this->db->last_query();die;
            
            if($result->num_rows() != 0)
            {   
                foreach ($result->result() as $value) {
                   // print_r($value);
                $data = array(
                    'TRANS_GUID' =>  $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid'),
                    'BIZDATE' => $_SESSION['stktake_date'] ,
                    'LOCATION' =>  $_SESSION['location'] ,
                    'ITEMCODE' =>  $value->itemcode,
                    'ITEMLINK' =>  $value->itemlink,
                    'PACKSIZE' =>  $value->packsize,
                    'DESCRIPTION' =>  addslashes($value->description),
                    'QTY_CURR' =>  $value->OnHandQty,
                    'QTY_ACTUAL' =>  '0' ,
                    'QTY_DIFF' =>  (string)(-1*(float)$value->OnHandQty),
                    'BARCODE' =>  $_SESSION['stktake_barcode'],

                    'CREATED_AT' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                    'CREATED_BY' => $_SESSION['username'],
                    'UPDATED_AT' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                    'UPDATED_BY' => $_SESSION['username'],

                    'POSTED' =>'0',
                    'NOT_IN_STOCK' =>'0',
                    'ADJUST_REFNO' =>'', 
                    );
                    
                    $this->stktake_online_model->itemlink_create_insert($data);
                }
            };

            
            $this->db->query("UPDATE stk_take_online a LEFT JOIN locationstock b ON a.`ITEMCODE`=b.`Itemcode` AND a.`LOCATION`=b.`Location` SET a.`QTY_CURR`=IF(b.`OnHandQty` IS NULL,0,b.OnHandQty), a.`QTY_DIFF`= IF(b.`OnHandQty` IS NULL,0,b.OnHandQty) WHERE a.BIZDATE='".$_SESSION['stktake_date']."' and a.location='".$_SESSION['location']."' and a.ITEMLINK='".$_SESSION['stktake_itemlink']."' ");
             redirect('stktake_online_controller/itemlink_list');
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function item_edit()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $check_item = $this->db->query("SELECT * from stk_take_online where TRANS_GUID='".$_REQUEST['trans_guid']."'");
            
            $data = array(
                'OnHand' => $check_item->row('QTY_CURR'),
                'Size' => $check_item->row('PACKSIZE'),
                'Desc' => $check_item->row('DESCRIPTION'),
                'Actual' => $check_item->row('QTY_ACTUAL'),
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/stktake_online/item_edit', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('stktake_online/item_edit', $data);
                    $this->load->view('footer');
                }    
            

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function item_edit_save()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $data = array(

                'QTY_ACTUAL' => (string)((float)$this->input->post('qty_actual') + (float)$this->input->post('qty_add')),
                'QTY_DIFF' => (string) (((float)$this->input->post('qty_actual') + (float)$this->input->post('qty_add'))-(float)$this->input->post('qty_curr')),

                'UPDATED_AT' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                'UPDATED_BY' => $_SESSION['username'],
                );
            $trans_guid = $this->input->post('trans_guid');
            $this->stktake_online_model->update_item($data, $trans_guid);
            redirect('stktake_online_controller/itemlink_list');

        }
        else
        {
            redirect('main_controller');
        }
    }
    
}
?>