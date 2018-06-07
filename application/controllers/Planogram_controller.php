<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class planogram_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('planogram_model');
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
        $this->load->library('form_validation');

	}

    public function scan_binID()
    {
        
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/planogram/scan_binID');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('planogram/scan_binID');
                    $this->load->view('footer');
                }
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function binID_list()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        { 

        if($this->input->post('bin_ID') == 0)
        {
            $bin_ID = $_REQUEST['bin_ID'];
        }
        else
        {
            $bin_ID = $this->input->post('bin_ID');
        }
            
            $result  = $this->planogram_model->check_binID($bin_ID);
            if($result->num_rows() != 0)
            {
                $data['result']=$this->planogram_model->binID_list($bin_ID);
                $bin_ID_Data = array(
                                      
                    'bin_ID' => $bin_ID   
                    );
                $this->session->set_userdata($bin_ID_Data);
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/planogram/binID_list', $data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('planogram/binID_list', $data);
                        $this->load->view('footer');
                    }    
                
            }
            else
            {
                $this->session->set_flashdata('message', 'Bin ID Not Found !');
                redirect('planogram_controller/scan_binID');
            }
            
        }
        else
        {
            redirect('main_controller');
        }
        
    }

    public function row_add()
    {
        
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $bin_ID = $_SESSION['bin_ID'];

            $row_no = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS row_guid,IF(MAX(row_no) IS NULL,0,MAX(row_no))+1 AS next_row FROM backend_stktake.set_bin_row WHERE bin_no='$bin_ID'");
            
            $data = array(
                'row_no' => $row_no->row('next_row'),
                'row_guid' => $row_no->row('row_guid'),
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/planogram/row_add', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('planogram/row_add', $data);
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function row_add_save()
    {
        
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $data = array(
                'row_guid' => $this->input->post('row_guid'),
                'BIN_NO' => $_SESSION['bin_ID'],
                'row_no' => $this->input->post('row_no'),
                'row_w' => $this->input->post('row_w'),
                'row_d' => $this->input->post('row_d'),
                'row_h' => $this->input->post('row_h'),
                );
            $this->planogram_model->insert_row($data);

            $bin_ID = $_SESSION['bin_ID'];
            $row_guid = $this->input->post('row_guid');
            $row_w = $this->input->post('row_w');
            $row_d = $this->input->post('row_d');
            $row_h = $this->input->post('row_h');

            $this->planogram_model->save1($row_guid, $row_w, $row_d, $row_h, $bin_ID);
            $this->planogram_model->save2($row_guid, $row_w, $row_d, $row_h);
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', 'Success.');
                redirect('planogram_controller/binID_list?bin_ID='.$_SESSION['bin_ID']);
            }
            else
            {
                $this->session->set_flashdata('message', 'Failed.');
                redirect('planogram_controller/binID_list?bin_ID='.$_SESSION['bin_ID']);
            }

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function row_item_scan()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {   
            $check_row_no = $this->db->query("SELECT * from backend_stktake.set_bin_row where row_guid='".$_REQUEST['row_guid']."'");

            $_SESSION['row_no'] = $check_row_no->row('row_no');
            $data = array(
                'bin_ID' => $_SESSION['bin_ID'],
                'row_no' => $_SESSION['row_no']
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/planogram/row_item_scan', $data);
                    
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('planogram/row_item_scan', $data);
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function rack_row_item_delete_all()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $delete_all_item = $this->db->query("DELETE from backend_stktake.set_bin_row_item 
             where row_guid='".$_REQUEST['row_guid']."' ");
            $this->session->set_flashdata('message', 'Success');
                redirect('planogram_controller/binID_list?bin_ID='.$_REQUEST['bin_ID']);
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function rack_row_item_delete()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $delete_all_item = $this->db->query("DELETE from backend_stktake.set_bin_row_item where item_guid='". $_SESSION['get_item_guid']."'");
            $this->session->set_flashdata('message', 'Success');
                redirect('planogram_controller/row_item_scan?row_guid='.$_SESSION['row_guid']);
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function row_item_scan_result()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $check_barcode = $this->db->query("SELECT * from backend.itembarcode  where barcode='".$this->input->post('barcode')."'");

            $_SESSION['row_itemcode'] = $check_barcode->row('Itemcode');
            $_SESSION['row_barcode'] = $check_barcode->row('Barcode');
            $_SESSION['row_guid'] = $this->input->post('row_guid');
            
            if($check_barcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Barcode not found : '.$this->input->post('barcode'));
                redirect('planogram_controller/row_item_scan?row_guid='.$this->input->post('row_guid'));
            }
            else
            {
                redirect('planogram_controller/rack_row_item_crud');
            }
        }
        else
        {
            redirect('main_controller');
        }

    }

    public function rack_row_item_crud()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $data_itemmaster = $this->db->query("SELECT itemcode,description from backend.itemmaster where itemcode='".$_SESSION['row_itemcode']."'");

            $volume_master_mode = $this->db->query("SELECT * from backend_stktake.set_item_volume_master where itemcode='".$_SESSION['row_itemcode']."'");
            
            $Qty = '1';
            $Width = '0';
            $Depth = '0';
            $Height = '0';
            $MaxStackable = '1'; 

            //Define volume master mode {update or add new}
            if ($volume_master_mode->num_rows() == 0)
            {
                $_SESSION['row_add_item_volume_master']='1';
            }
            else
            {
                $_SESSION['row_add_item_volume_master']='0';
                $Width = $volume_master_mode->row('item_w');
                $Depth = $volume_master_mode->row('item_d');
                $Height = $volume_master_mode->row('item_h');
                $MaxStackable = $volume_master_mode->row('stackable_max'); 
            };

            //Search for existing row item
            $row_item = $this->db->query("SELECT a.* from backend_stktake.set_bin_row_item a where itemcode='".$_SESSION['row_itemcode']."' and row_guid='".$_SESSION['row_guid']."'");

            if($row_item->num_rows() == 0)
            {
                $_SESSION['row_add_item']='1';
                $deletebutton = '0';
                $_SESSION['get_item_guid'] = $this->db->query('SELECT REPLACE(UPPER(UUID()),"-","") AS item_guid')->row('item_guid');
            }
            else
            {
                $_SESSION['row_add_item']='0';
                $deletebutton = '1';
                $Qty = $row_item->row('qty');
                $_SESSION['get_item_guid'] = $row_item->row('item_guid');
            };

            $data = array(
                'Qty' => $Qty,
                'Width' => $Width,
                'Depth' => $Depth,
                'Height' => $Height,
                'MaxStackable' => $MaxStackable, 

                'itemcode' => $_SESSION['row_itemcode'],
                'barcode' => $_SESSION['row_barcode'],
                'description' => $data_itemmaster->row('description'),

                'deletebutton' => $deletebutton,
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/planogram/row_item_crud', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('planogram/row_item_crud', $data);
                    $this->load->view('footer');
                }    
            
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function rack_row_item_crud_save()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {

            if ($_SESSION['row_add_item']=='1')  //new record (item)
            {
                $data = array(
                   'item_guid' => $_SESSION['get_item_guid'] ,
                   'row_guid' => $_SESSION['row_guid'] ,
                   'itemcode' => $_SESSION['row_itemcode'] ,

                   'qty' => $this->input->post('Qty') ,

                   'item_w' => $this->input->post('Width') ,
                   'item_d' => $this->input->post('Depth'),
                   'item_h' => $this->input->post('Height'),
                   'stackable_max' => $this->input->post('MaxStackable'),

                   'created_at' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                   'created_by' => $_SESSION['username'],
                   'updated_at' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                   'updated_by' => $_SESSION['username'],
                    );
               $this->planogram_model->insert_row_item($data);

            }
            else //update only  (item)
            {
               $data = array(
                    'qty' => $this->input->post('Qty'),

                    'item_w' => $this->input->post('Width'),
                    'item_d' => $this->input->post('Depth'),
                    'item_h' => $this->input->post('Height'),
                    'stackable_max' => $this->input->post('MaxStackable'),

                    'updated_at' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                    'updated_by' => $_SESSION['username'],
                );
               $this->planogram_model->update_row_item($data);
            };

               //round w,d,h value to 2 digit
               $this->db->query("UPDATE backend_stktake.set_bin_row_item set item_w=round(item_w,2),item_d=round(item_d,2),item_h=round(item_h,2) where item_guid='".$_SESSION['get_item_guid']."' ");

               $this->db->query("UPDATE backend_stktake.set_bin_row_item set item_volume=round(item_w*item_d*item_h,2) where item_guid='".$_SESSION['get_item_guid']."' ");


               if ($_SESSION['row_add_item_volume_master']=='1') //add master
               {
                   $data = array(
                        'itemcode' => $_SESSION['row_itemcode'],
                        'item_w' => $this->input->post('Width'),
                        'item_d' => $this->input->post('Depth'),
                        'item_h' => $this->input->post('Height'),
                        'stackable_max' => $this->input->post('MaxStackable'),

                        'created_at' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                        'created_by' => $_SESSION['username'],
                        'updated_at' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                        'updated_by' => $_SESSION['username'],
                    );
                   
                    $this->planogram_model->insert_row_item_master($data);

               }
               else //update master
               {
                    $data = array(
                        'item_w' => $this->input->post('Width'),
                        'item_d' => $this->input->post('Depth'),
                        'item_h' => $this->input->post('Height'),
                        'stackable_max' => $this->input->post('MaxStackable'),

                        'updated_at' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                        'updated_by' => $_SESSION['username'],
                    );
                    $this->planogram_model->update_row_item_master($data);
                };

                    //round w,d,h value to 2 digit
                    $this->db->query("UPDATE backend_stktake.set_item_volume_master set item_w=round(item_w,2),item_d=round(item_d,2),item_h=round(item_h,2) where itemcode='".$_SESSION['row_itemcode']."'");

                    //getting volume
                    $this->db->query("UPDATE backend_stktake.set_item_volume_master set item_volume=round(item_w*item_d*item_h,2) where itemcode='".$_SESSION['row_itemcode']."' ");

                    $this->session->set_flashdata('message', 'Success');
                redirect('planogram_controller/row_item_scan?row_guid='.$_SESSION['row_guid']);

        }
        else
        {
            redirect('main_controller');
        }
    }
    
}
?>