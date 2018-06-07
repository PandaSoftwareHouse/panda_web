<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class shelveLabel_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('shelveLabel_model');
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
                    $this->load->view('WinCe/shelveLabel/index');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('shelveLabel/index');
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
                    redirect('shelveLabel_controller');
            }
            else
            {
                $_SESSION['get_binID']=strtoupper($this->input->post('bin_ID'));
                redirect('shelveLabel_controller/barcode_scan');
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
                    $this->load->view('WinCe/shelveLabel/barcode_scan');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('shelveLabel/barcode_scan');
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

            $check_barcode = $this->db->query("SELECT * from backend.itembarcode where barcode='".$this->input->post('barcode')."'");

            if($check_barcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Barcode does not exist: '.$this->input->post('barcode'));
                    redirect('shelveLabel_controller/barcode_scan');
            }
            else
            {
                $_SESSION['get_barcode']=strtoupper($this->input->post('barcode'));
                redirect('shelveLabel_controller/shelf_print');
            }
        }
        else
        {
            redirect('main_controller');
        }

    }

    
    public function shelf_print()
    {
        if ($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $check_barcode = $this->db->query("SELECT a.Itemcode,a.Description,a.price_include_tax AS Price,articleno,Remark,barcode,a.PackSize,a.Size FROM itemmaster a INNER JOIN itembarcode b ON a.Itemcode=b.itemcode WHERE b.barcode = '".$_SESSION['get_barcode']."'");
            
            if(!isset($_SESSION['formatButton']))
            {
                $_SESSION['formatButton'] = '0';
            };
            
            $data =array(
                'bin_id' => $_SESSION['get_binID'],
                'barcode' => $_SESSION['get_barcode'],
                'description' => $check_barcode->row('Description'),
                'price' => $check_barcode->row('Price')
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/shelveLabel/shelf_print', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('shelveLabel/shelf_print', $data);
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
            $this->db->query("UPDATE backend_stktake.shelf_label set Print_now=1 where Print_now=0 and Bin_Code='".$_SESSION['get_binID']."'");
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
            $check_barcode = $this->db->query("SELECT a.Itemcode,a.Description,a.price_include_tax AS Price,articleno,Remark,barcode,a.PackSize,a.Size FROM itemmaster a INNER JOIN itembarcode b ON a.Itemcode=b.itemcode WHERE b.barcode = '".$_SESSION['get_barcode']."'");

            $_SESSION['formatButton'] = $this->input->post('format');
            $data = array(
                'shelf_guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid'),
                'Bin_Code' => $_SESSION['get_binID'],
                'itemcode' => $check_barcode->row('Itemcode'),
                'PackSize' => $check_barcode->row('PackSize'),
                'Size' => $check_barcode->row('Size'),
                'Description' => $check_barcode->row('Description'),
                'Price' => $check_barcode->row('Price'),
                'articleno' => $check_barcode->row('articleno'),
                'Remark' => $check_barcode->row('Remark'),
                'Print_now' => '0',
                'barcode' => $_SESSION['get_barcode'],
                'Label_Format' => $this->input->post('format'),
                'created_at' => $this->db->query("SELECT NOW() as now")->row('now'),     
                );
            $this->shelveLabel_model->save($data);
            redirect('shelveLabel_controller/barcode_scan');
        }
        else
        {
            redirect('main_controller');
        }
    }

}
?>