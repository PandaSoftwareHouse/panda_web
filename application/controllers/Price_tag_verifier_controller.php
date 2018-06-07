<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class price_tag_verifier_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('price_tag_variance_model');
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
                    $this->load->view('WinCe/price_tag_verifier/index');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('price_tag_verifier/index');
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function scan_binID()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $check_binID = $this->db->query("SELECT * from backend_stktake.set_bin where BIN_NO='".$this->input->post('bin_ID')."' ");

            if($check_binID->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Barcode does not exist'.$this->input->post('bin_ID'));
                    redirect('price_tag_verifier_controller');
            }
            else
            {
                $_SESSION['get_binID']=strtoupper($this->input->post('bin_ID'));
                redirect('price_tag_verifier_controller/barcode_scan');
            }
        }
        else
        {
           redirect('main_controller');
        }
    }


    public function barcode_scan()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/price_tag_verifier/barcode_scan');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('price_tag_verifier/barcode_scan');
                    $this->load->view('footer');
                }
        }
        else
        {
            redirect('main_controller');
        }

    }

    
    public function barcode_scan_result()
    {
        if ($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $scanned_barcode = $this->input->post('barcode');
            if(strpos($scanned_barcode,'*'))
            {
                $decode_barcode = $this->price_tag_variance_model->decode_barcode($scanned_barcode);
                $decode_price = $this->price_tag_variance_model->decode_price($scanned_barcode);
            }
            else
            {
                $decode_barcode = $scanned_barcode;
                $decode_price = $this->price_tag_variance_model->get_price($decode_barcode);
            }
            

            $check_barcode = $this->db->query("SELECT * from backend.itembarcode where barcode='".$decode_barcode."'");

            if($check_barcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Barcode does not exist: '.$this->input->post('barcode'));
                    redirect('price_tag_verifier_controller/barcode_scan');
            }
            else
            {
                $this->shelf_print($scanned_barcode,$decode_barcode,$decode_price);
            }
        }
        else
        {
            redirect('main_controller');
        }

    }

    
    public function shelf_print($scanned_barcode,$decode_barcode,$decode_price)
    {
        if ($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {   
            $scanned_barcode = $scanned_barcode;
            $barcode = $decode_barcode; 
            $price = $decode_price;

            $check_variance_price = $this->price_tag_variance_model->check_variance($barcode,$price);

            if ($check_variance_price == '0')
            {   
                $get_item_info = $this->price_tag_variance_model->get_variance_info($barcode,$price);
                $this->session->set_flashdata('variance', 'Price Got Variance With System Price');

                $data =array(
                'bin_id' => $_SESSION['get_binID'],
                'barcode' => $scanned_barcode,
                'actual_barcode' => $barcode,
                'description' => $get_item_info->row('Description'),
                'price' => $get_item_info->row('Price'),
                'save' => '1',
                );
            }
            else
            {   
                $get_item_info = $this->price_tag_variance_model->get_item_info($barcode,$price);

                $data =array(
                'bin_id' => $_SESSION['get_binID'],
                'barcode' => $scanned_barcode,
                'description' => $get_item_info->row('Description'),
                'price' => $get_item_info->row('Price'),
                'save' => '0',
                );
            }

            if(!isset($_SESSION['formatButton']))
                {
                    $_SESSION['formatButton'] = '0';
                };
            
            
                
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/price_tag_verifier/shelf_print', $data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('price_tag_verifier/shelf_print', $data);
                        $this->load->view('footer');
                    }  
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function update_printflag()
    {
        if ($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $this->db->query("UPDATE backend_stktake.shelf_label_variance_price set Print_now=1 where Print_now=0 and Bin_Code='".$_SESSION['get_binID']."'");
            redirect('shelveLabel_controller');
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function save()
    {
        if ($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {   
            $barcode = $this->input->post('barcode');
            $actual_barcode = $this->input->post('actual_barcode');
            $price = $this->input->post('price');

            $check_barcode = $this->db->query("SELECT a.Itemcode,a.Description,'$price' AS Price,  a.price_include_tax ,articleno,Remark,barcode,a.PackSize,a.Size FROM itemmaster a INNER JOIN itembarcode b ON a.Itemcode=b.itemcode WHERE b.barcode = '".$actual_barcode."'");

            $_SESSION['formatButton'] = $this->input->post('format');

            $shelf_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid');

            $data = array(
                'shelf_guid' => $shelf_guid,
                'Bin_Code' => $_SESSION['get_binID'],
                'itemcode' => $check_barcode->row('Itemcode'),
                'PackSize' => $check_barcode->row('PackSize'),
                'Size' => $check_barcode->row('Size'),
                'Description' => $check_barcode->row('Description'),
                'LabelPrice' => $check_barcode->row('Price'),
                'SystemPrice' => $check_barcode->row('price_include_tax'),
                'articleno' => $check_barcode->row('articleno'),
                'Remark' => $check_barcode->row('Remark'),
                'Print_now' => '0',
                'scanned_barcode' => $barcode,
                'actual_barcode' => $actual_barcode,
                'Label_Format' => $this->input->post('format'),
                'created_at' => $this->db->query("SELECT NOW() as now")->row('now'),     
                );
            
            $this->price_tag_variance_model->save($data);

            $data2 = array(
                'shelf_guid' => $shelf_guid,
                'Bin_Code' => $_SESSION['get_binID'],
                'itemcode' => $check_barcode->row('Itemcode'),
                'PackSize' => $check_barcode->row('PackSize'),
                'Size' => $check_barcode->row('Size'),
                'Description' => $check_barcode->row('Description'),
                'Price' => $check_barcode->row('price_include_tax'),
                'articleno' => $check_barcode->row('articleno'),
                'Remark' => $check_barcode->row('Remark'),
                'Print_now' => '0',
                'barcode' => $actual_barcode,
                'Label_Format' => $this->input->post('format'),
                'created_at' => $this->db->query("SELECT NOW() as now")->row('now'),     
                );

            $this->price_tag_variance_model->save_shelf_label($data2);
            
            redirect('price_tag_verifier_controller/barcode_scan');
        }
        else
        {
            redirect('main_controller');
        }
    }

}
?>