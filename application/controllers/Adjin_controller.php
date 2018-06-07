<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class adjin_controller extends CI_Controller {
    /*test22*/
    public function __construct()
	{
		parent::__construct();
        $this->load->model('adjin_model');
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
            $data['result']=$this->adjin_model->main();
            $_SESSION['web_guid'] = '';
            $_SESSION['web_c_guid'] = '';

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/adjin/main', $data);
        
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('adjin/main', $data);
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
                'result' => $this->adjin_model->itemlist($web_guid),
                'header' => $this->adjin_model->item_in_so_header($web_guid),
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/adjin/itemlist', $data);
                } 
            else
                {
                    $this->load->view('header');
                    $this->load->view('adjin/itemlist', $data);
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
               
            $data['result']=$this->adjin_model->edit_item($web_guid, $itemcode);
            $this->load->view('header');
            $this->load->view('adjin/edit_item', $data);
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
                    $data['reason'] = $this->db->query("SELECT code_desc FROM backend.set_master_code
                                WHERE code_group IN ('','ADJUSTMENT') and trans_type = 'ADJUST_REASON' ORDER BY code_group, code_desc ");
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/adjin/add_remarks',$data);
                }
            else
                {
                    $data['reason'] = $this->db->query("SELECT code_desc FROM backend.set_master_code
                                WHERE code_group IN ('') and trans_type = 'ADJUST_REASON' ORDER BY code_group, code_desc ");
                    $this->load->view('header');
                    $this->load->view('adjin/add_remarks', $data);
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

                $remarks = addslashes($this->input->post('remarks'));
                $reason = addslashes($this->input->post('reason'));

                $result = $this->adjin_model->add_process($remarks, $reason);
                if($result > 0)
                {
                    echo "<script>
                    alert('Succesfully Add.');
                    document.location='" . base_url() . "/index.php/adjin_controller/main'
                    </script>";
                }
                else
                {
                    echo "<script>
                    alert('Failed to Add.');
                    document.location='" . base_url() . "/index.php/adjin_controller/main'
                    </script>";
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
            $data['result']=$this->adjin_model->itemlist($web_guid);
            $data['header'] = $this->adjin_model->item_in_so_header($web_guid);
            $this->general_scan_model->reloadbillamt($web_guid);
            //header("Refresh:0");
            $this->load->view('header');
            $this->load->view('adjin/itemlist',$data);
            $this->load->view('footer');

        } 
        else
        {
            redirect('main_controller');
        }
        
    }

}
?>
