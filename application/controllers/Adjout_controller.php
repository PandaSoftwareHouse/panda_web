<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class adjout_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('adjout_model');
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

            $acc_code_Data = array(
                    'aotype' =>$_REQUEST['type']
                    );
            $this->session->set_userdata($acc_code_Data);

            $data['result']=$this->adjout_model->main();

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/adjout/main', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('adjout/main', $data);
                    $this->load->view('footer');                    
                }    

        }
        else
        {
            $this->load->database();
            $this->load->model('Main_Model'); 
            $data['location']=$this->Main_Model->location();

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('header');
                    $this->load->view('index',$data);                
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('index',$data);
                    $this->load->view('footer');
                }    
        }
    }


    public function itemlist()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
                $web_guid = $_REQUEST['web_guid'];
                $acc_code_Data = array(
                    'web_guid' =>$_REQUEST['web_guid']
                    );
               $this->session->set_userdata($acc_code_Data);
               
            $data['result']=$this->adjout_model->itemlist($web_guid);
            $data['header'] = $this->adjout_model->item_in_so_header($web_guid);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/adjout/itemlist', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('adjout/itemlist', $data);
                    $this->load->view('footer');

                }    
        }
        else
        {
            $this->load->database();
            $this->load->model('Main_Model'); 
            $data['location']=$this->Main_Model->location();

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/index',$data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('index',$data);
                    $this->load->view('footer');
                }    
        }
    }


    public function edit_item()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $web_guid = $_REQUEST['web_guid'];
            $itemcode = $_REQUEST['itemcode'];
               
            $data['result']=$this->adjout_model->edit_item($web_guid, $itemcode);
            $this->load->view('header');
            $this->load->view('adjout/edit_item', $data);
            $this->load->view('footer');
        }
        else
        {
            $this->load->database();
            $this->load->model('Main_Model'); 
            $data['location']=$this->Main_Model->location();
            $this->load->view('header');
            $this->load->view('index');
            $this->load->view('footer');
        }

    }

    
    public function add_remarks()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];

            if($_SESSION['aotype'] == 'AO')
            {
                $q1 = $this->db->query("SELECT code_desc FROM set_master_code
                                WHERE code_group IN ('','ADJUSTMENT') and trans_type = 'adjust_reason'  ORDER BY code_group, code_desc  ");
            };

            if($_SESSION['aotype'] == 'DP')
            {
                $q1 = $this->db->query("SELECT code_desc FROM set_master_code
                                WHERE code_group IN ('DISPOSAL') and trans_type = 'adjust_reason'  ORDER BY code_group, code_desc  ");
            };

            if($_SESSION['aotype'] == 'OU')
            {
                $q1 = $this->db->query("SELECT code_desc FROM set_master_code
                                WHERE code_group IN ('Own Use') and trans_type = 'adjust_reason'  ORDER BY code_group, code_desc  ");
            };

            if(strpos($browser_id,"Windows CE"))
                {
                    $data['reason'] = $q1;
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/adjout/add_remarks',$data);
                }
            else
                {
                    $data['reason'] = $q1;
                    $this->load->view('header');
                    $this->load->view('adjout/add_remarks', $data);
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

                $result = $this->adjout_model->add_process($remarks, $reason);
                if($result > 0)
                {
                    echo "<script>
                    alert('Succesfully Add.');
                    document.location='" . base_url() . "/index.php/adjout_controller/main?type=".$_SESSION['aotype']."'
                    </script>";
                }
                else
                {
                    echo "<script>
                    alert('Failed to Add.');
                    document.location='" . base_url() . "/index.php/adjout_controller/main?type=".$_SESSION['aotype']."'
                    </script>";
                }

        }
        else
        {
            redirect('main_controller');
        }
    }

    // 2017-01-20

    
    public function scan_item()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $acc_code = $this->input->post('acc_code');
            $web_guid = $this->input->post('web_guid');

            $acc_code_Data = array(

                'acc_code' => $acc_code,
                'web_guid' => $web_guid
            );
            $this->session->set_userdata($acc_code_Data);
            $this->load->view('header');
            $this->load->view('adjout/scan_item');
            $this->load->view('footer');
            
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
            $data['result']=$this->adjout_model->itemlist($web_guid);
            $data['header'] = $this->adjout_model->item_in_so_header($web_guid);
            $this->general_scan_model->reloadbillamt($web_guid);
            //header("Refresh:0");
            $this->load->view('header');
            $this->load->view('adjout/itemlist',$data);
            $this->load->view('footer');

        } 
        else
        {
            redirect('main_controller');
        }
    }

  
}
?>