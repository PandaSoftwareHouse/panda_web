<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class simpleso_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('simpleso_model');
        $this->load->model('general_scan_model');
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
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $data['result']=$this->simpleso_model->main();
            $_SESSION['web_guid'] = '';
            $_SESSION['web_c_guid'] = '';

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/simpleso/main', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('simpleso/main', $data);
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
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $web_guid = $_REQUEST['web_guid'];

                $acc_code_Data = array(
                    'web_guid' =>$_REQUEST['web_guid'],
                    );
               $this->session->set_userdata($acc_code_Data);
               $data = array(
                'result' => $this->simpleso_model->itemlist($web_guid),
                'header' => $this->simpleso_model->item_in_so_header($web_guid),
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/simpleso/itemlist', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('simpleso/itemlist', $data);
                    $this->load->view('footer');
                }    
        }
        else
        {
           redirect('main_controller');
        }
    }


    public function edit_item()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $web_guid = $_REQUEST['web_guid'];
            $itemcode = $_REQUEST['itemcode'];
               
            $data['result']=$this->simpleso_model->edit_item($web_guid, $itemcode);
            $this->load->view('header');
            $this->load->view('simpleso/edit_item', $data);
            $this->load->view('footer');
        }
        else
        {
            redirect('main_controller');
        }

    }

    
    public function add_remarks()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/simpleso/add_remarks');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('simpleso/add_remarks');
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }

    }


    public function add_process()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {

            if($this->input->post('remarks') != '')
            {
                $remarks = addslashes($this->input->post('remarks'));

                $result = $this->simpleso_model->add_process($remarks);
                if($result > 0)
                {
                    echo "<script>
                    alert('Succesfully Add.');
                    document.location='" . base_url() . "/index.php/simpleso_controller/main'
                    </script>";
                }
                else
                {
                    echo "<script>
                    alert('Failed to Add.');
                    document.location='" . base_url() . "/index.php/simpleso_controller/main'
                    </script>";
                }

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
            /*$web_guid = $this->input->post('guid');*/
            $web_c_guid = $_REQUEST['web_c_guid'];
            $web_guid = $_REQUEST['web_guid'];
           
            $delete = $this->general_scan_model->delete_item($web_c_guid);
            $data['result']=$this->simpleso_model->itemlist($web_guid);
            $data['header'] = $this->simpleso_model->item_in_so_header($web_guid);
            $this->general_scan_model->reloadbillamt($web_guid);
            //header("Refresh:0");
            $this->load->view('header');
            $this->load->view('simpleso/itemlist',$data);
            $this->load->view('footer');

        } 
        else
        {
            redirect('main_controller');
        }
        
    }

}
?>