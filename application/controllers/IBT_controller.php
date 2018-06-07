<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IBT_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('IBT_model');
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
        
        $data['IBT']=$this->IBT_model->main();
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/IBTrequest/IBT_main',$data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('IBTrequest/IBT_main', $data);
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


    public function search_branch()
    {
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $data = array (
                'supplier' => $this->db->query("SELECT branch_code AS CODE,branch_name AS NAME,CONCAT(branch_code,' => ', branch_name) AS dname FROM backend.cp_set_branch ORDER BY branch_code "),
                'selected' => $this->db->query("SELECT branch_code AS CODE,branch_name AS NAME,CONCAT(branch_code,' => ', branch_name) AS dname FROM backend.cp_set_branch where branch_code = '".$_SESSION['loc_group']."'")->row('dname'),
                );


            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                       $this->load->view('WinCe/header');
                       $this->load->view('WinCe/IBTrequest/IBT_search',$data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('IBTrequest/IBT_search',$data);
                    $this->load->view('footer');
                }    
       
        }
        else
        {
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                     redirect('main_controller/main');
                }
            else
                {
                     redirect('main_controller/main');
                }    
        }
    }


    public function add_trans()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        { 
            $frombranch = explode(" => ", $this->input->post('frombranch'));
            $fcode = $frombranch[0];
            //$fname = addslashes($frombranch[1]);

            $tobranch = explode(" => ", $this->input->post('tobranch'));
            $tcode = $tobranch[0];
            $tname = addslashes($tobranch[1]);


            if($fcode == $tcode)
            {
                $this->session->set_flashdata('message', '<span class="label label-warning" style="font-size: 14px;">Location From and Location To cannot be the same</span><br>');
                redirect('IBT_controller/search_branch');
            };
            
            $this->IBT_model->add_trans($fcode,$tcode,$tname);
            $web_guid = $this->db->query("SELECT web_guid from backend.web_trans where module_desc = 'IBT Req' order by created_at desc limit 1")->row('web_guid');

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    redirect('IBT_controller/item_in_IBT?web_guid='.$web_guid);
                }
            else
                {
                    redirect('IBT_controller/item_in_IBT?web_guid='.$web_guid);
                }
        }
        else
        {
            redirect('main_controller/main');
        }

    }


    public function item_in_IBT()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            //$web_guid = $this->input->post('guid');
            $web_guid = $_REQUEST['web_guid'];
            $data['item'] = $this->IBT_model->item_in_IBT($web_guid);
            $data['header'] = $this->IBT_model->item_in_IBT_header($web_guid);
            $data['count'] = $this->db->query("SELECT count(web_c_guid) as web from backend.web_trans_c where web_guid = '$web_guid' ")->row('web');


             $acc_code_Data = array(
                'web_guid' => $web_guid,
            );
            $this->session->set_userdata($acc_code_Data);
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/IBTrequest/item_in_IBT', $data);
                  
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('IBTrequest/item_in_IBT', $data);
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



       public function delete_item()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            //$web_guid = $this->input->post('guid');
            $web_c_guid = $_REQUEST['web_c_guid'];
            $web_guid = $_REQUEST['web_guid'];

            
           
            $delete = $this->general_scan_model->delete_item($web_c_guid);
            $data['item'] = $this->IBT_model->item_in_IBT($web_guid);
            $data['header'] = $this->IBT_model->item_in_IBT_header($web_guid);
             $data['count'] = $this->db->query("SELECT count(web_c_guid) as web from backend.web_trans_c where web_guid = '$web_guid' ")->row('web');
            $this->general_scan_model->reloadbillamt($web_guid);
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/IBTrequest/item_in_IBT',$data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('IBTrequest/item_in_IBT',$data);
                    $this->load->view('footer');                    
                }    


        }  
        else
        {
            redirect('main_controller/main');
        }
        
    }

}
?>