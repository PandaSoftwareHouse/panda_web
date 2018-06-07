<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rbatch_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('rbatch_model');
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
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $data = array( 
                'result' => $this->db->query("SELECT * FROM backend_warehouse.b_trans 
                WHERE location_to='".$_SESSION['location']."'
                AND trans_type='BATCH_TRANS'
                AND delivered=1 AND received=0 AND canceled=0 
                ORDER BY created_at DESC"),
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/rbatch/main', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('rbatch/main', $data);
                    $this->load->view('footer');
                }    
        }
        else
        {
           redirect('main_controller');
        }
    }

    public function trans_location()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            if (!isset($_SESSION['trans_guid']))
            {
                $_SESSION['trans_guid'] = '';
            };
            $data = array( 
                'trans_location' => $this->db->query("SELECT * FROM backend_warehouse.b_trans_c WHERE trans_guid='".$_SESSION['trans_guid']."' AND verified=0 ORDER BY created_at DESC"),
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/rbatch/trans_location',$data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('rbatch/trans_location',$data);
                    $this->load->view('footer');
                }    
        }  
        else
        {
          redirect('main_controller');
        } 
    }

    public function rbatch_trans()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $barcode = $this->input->post('barcode');
            $check_transbarcode =$this->db->query("SELECT * FROM backend_warehouse.b_trans WHERE refno='$barcode'AND delivered=1 AND received=0 AND canceled=0 AND location_to='".$_SESSION['location']."'");
            if($check_transbarcode->num_rows() > 0)
            {
                $trans_guid = $check_transbarcode->row('trans_guid');
                $data = array (
                    'trans_guid' => $trans_guid,
                    'refno' => $check_transbarcode->row('refno'),
                    );

                $this->session->set_userdata($data);
                redirect('rbatch_controller/itemlist?trans_guid='.$trans_guid);
            }
            else
            {
                $this->session->set_flashdata('message', 'Barcode '.$barcode.' not found ');
                redirect('rbatch_controller/trans_location');
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
        $checkbatch = $this->db->query("SELECT * from backend_warehouse.b_trans WHERE  trans_guid='".$_REQUEST['trans_guid']."'");

        $data = array(
            'result' => $this->db->query("SELECT * FROM backend_warehouse.b_trans_c WHERE  verified=0 and  trans_guid='".$checkbatch->row('trans_guid')."' GROUP BY created_at DESC"),
            'count' => $this->db->query("SELECT COUNT(*) as count from backend_warehouse.b_trans_c WHERE  verified=0 and  trans_guid='".$checkbatch->row('trans_guid')."'")->row('count'),
            );
        $set_session = array (
            'refno'  => $checkbatch->row('refno'),
            'trans_guid' => $checkbatch->row('trans_guid'),
            );
        $this->session->set_userdata($set_session);
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/rbatch/itemlist', $data);
            }
        else
            {
                $this->load->view('header');
                $this->load->view('rbatch/itemlist', $data);
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

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/rbatch/scan_item');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('rbatch/scan_item');
                    $this->load->view('footer');
                }    
        }  
        else
        {
          redirect('main_controller');
        } 
    }

    public function post_refno_c()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $refno = $this->input->post('refno');
            $check_transguid = $this->db->query("SELECT * FROM backend_warehouse.b_trans_c WHERE verified=0 
            AND trans_guid='".$_SESSION['trans_guid']."' AND batch_barcode='$refno'");
            if ($check_transguid->num_rows() > 0)
            {
                $child_guid = $check_transguid->row('child_guid');
                $trans_guid = $check_transguid->row('trans_guid');
                redirect('main_controller/confirm_post?post_type=trx_rec_child&child_guid='.$child_guid."&refno=".$refno."&trans_guid=".$trans_guid);
                 
            }
            else
            {
                $this->session->set_flashdata('message', 'Barcode '.$refno.' not found ');
                redirect('rbatch_controller/scan_item');
            }
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function general_post_c()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $child_guid = $_REQUEST['child_guid'];

            redirect('main_controller/general_post?post_type=trx_rec_child&child_guid='.$child_guid);

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function scan_batch()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/rbatch/scan_batch');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('rbatch/scan_batch');
                    $this->load->view('footer');
                }    
        }  
        else
        {
          redirect('main_controller');
        } 
    }

    public function post_refno()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $refno = $this->input->post('refno');
            $check_transguid = $this->db->query("SELECT * FROM backend_warehouse.b_trans WHERE refno='$refno'
            AND delivered=1 AND received=0 AND canceled=0 AND location_to='".$_SESSION['location']."'");
            if ($check_transguid->num_rows() > 0)
            {
                $transguid = $check_transguid->row('trans_guid');
                redirect('main_controller/confirm_post?post_type=trx_rec&trans_guid='.$transguid."&refno=".$refno);
            }
            else
            {
                $this->session->set_flashdata('message', 'Barcode '.$refno.' not found ');
                redirect('rbatch_controller/scan_batch');
            }
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function general_post()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $trans_guid = $_REQUEST['trans_guid'];

            redirect('main_controller/general_post?post_type=trx_rec&trans_guid='.$trans_guid);

        }
        else
        {
            redirect('main_controller');
        }
    }



}
?>