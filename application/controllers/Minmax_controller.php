<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class minmax_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('Minmax_Model');
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
        $this->load->library('form_validation');

	}
    
	
	
    //home projectGRN
    public function backhome()
    {
        redirect('minmax_controller/home');
    }


    public function home()
    {
        
        if($this->session->userdata('loginuser')== true)
        {

            $data['menu']=$this->Minmax_Model->home_data();
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/home', $data);
            }
            else
            {
                $this->load->view('header');
                $this->load->view('home', $data);
                $this->load->view('footer');
            }

        }
        else
        {
            $this->load->view('header');
            $this->load->view('index');
            $this->load->view('footer');
        }
    }


    public function view_transaction()
    {
        if($this->session->userdata('loginuser')== true)
        {
          
        //$this->load->database();  
        //$this->load->model('Minmax_Model');  
        //$data['transaction_today'] = $result  = $this->Minmax_Model->transaction_today();
       /*$data['sysrun'] = $result  = $this->Minmax_Model->identify_sysrun();  
        $data['transactions']=$this->Minmax_Model->transaction_data(); */

        $data = array(
                'form_action' => site_url('minmax_controller/scan_barcode'),
                'heading' => 'Min Max Setup',
                );

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/minmax/header');
                    $this->load->view('WinCe/minmax/scan_binID',$data);
                }
                else
                {
                    $this->load->view('header');
                    $this->load->view('minmax/scan_binID', $data);
                    $this->load->view('footer');
                }    

            
        }
        else
        {
           // / redirect('minmax_controller/backhome');
            
        }
    }
    public function scan_barcode()
    {
        if($this->session->userdata('loginuser') == true)
        { 

            $bin_ID = $this->input->post('bin_ID');
            $result = $this->db->query("SELECT bin_no, location from backend_stktake.set_bin where bin_no = '$bin_ID'");
            if ($result->row('bin_no') != '')
            {
                $ses_data = array (
                    'bin_ID' => $bin_ID,
                    'locBin' => $result->row('location')
                    );
    
                $data = array(
                'form_action' => site_url('minmax_controller/itemlist'),
                'heading' => 'Min Max Setup',
                );
                $this->session->set_userdata($ses_data);

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/minmax/header');
                    $this->load->view('WinCe/minmax/pre_itemscan',$data);
                }

                else
                {
                    $this->load->view('header');
                    $this->load->view('minmax/pre_itemscan', $data);
                    $this->load->view('footer');    
                }    

            }
            elseif ($_REQUEST['bin_ID'] != '')
            {
                $bin_ID = $_REQUEST['bin_ID'];
                $result = $this->db->query("SELECT bin_no, location from backend_stktake.set_bin where bin_no = '$bin_ID'");
                if ($result->row('bin_no') != '')
                {
                    $ses_data = array (
                      'bin_ID' => $bin_ID,
                       'locBin' => $result->row('location')
                        );
    
                    $data = array(
                    'form_action' => site_url('minmax_controller/itemlist'),
                    'heading' => 'Min Max Setup',
                    );
                    $this->session->set_userdata($ses_data);

                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/minmax/header');
                        $this->load->view('WinCe/minmax/pre_itemscan',$data);
                    }

                    else
                    {
                        $this->load->view('header');
                        $this->load->view('minmax/pre_itemscan', $data);
                        $this->load->view('footer');    
                    }    
                }
                else
                {
                    $this->session->set_flashdata('message', "Bin ID does not exist.");
                    redirect('minmax_controller/view_transaction');
                }

            }
            else
            {
                $this->session->set_flashdata('message', "Bin ID does not exist.");
                redirect('minmax_controller/view_transaction');
            }
        }
        else
        {

             redirect('minmax_controller/backhome');
        }
    }

    public function itemlist()
    {
        if($this->session->userdata('loginuser') == true)
        { 
        $barcode = $this->input->post('barcode');
        $loc_group = $_SESSION['loc_group'];
        $check_itemcode = $this->db->query("SELECT itemcode, barcode, bardesc from backend.itembarcode where barcode = '$barcode'");
        $itemcode = $check_itemcode->row('itemcode');
        $set_minmax = $this->db->query("SELECT set_min, set_max from backend_warehouse.set_min_max where itemcode = '$itemcode' and loc_group = '$loc_group' and bin_id = '".$_SESSION['bin_ID']."'");

        if($check_itemcode->num_rows() > 0)
        {
            $data = array(
                'form_action' => site_url('minmax_controller/insert_data'),
                'heading' => 'Min Max Setup',
                'itemcode' => $check_itemcode->row('itemcode'),
                'barcode'  => $barcode,
                'bardesc' => $check_itemcode->row('bardesc'),
                'set_min' => $set_minmax->row('set_min'),
                'set_max' => $set_minmax->row('set_max'),
                ); 

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/minmax/header');
                $this->load->view('WinCe/minmax/pre_itemEdit',$data);
            }

            else
            {    
                $this->load->view('header');
                $this->load->view('minmax/pre_itemEdit', $data);
                $this->load->view('footer');
            }    
        }
        else
        {
            $this->session->set_flashdata('message', "Barcode does not exist.");
            redirect('minmax_controller/scan_barcode?bin_ID='.$_SESSION['bin_ID']);
        }
    }
    else
    {
         redirect('minmax_controller/backhome');
    }


    }

    public function insert_data()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $itemcode = $this->input->post('itemcode');
            $check_row = $this->db->query("SELECT * FROM backend_warehouse.set_min_max where loc_group = '".$_SESSION['locBin']."' and bin_id = '".$_SESSION['bin_ID']."' and itemcode = '$itemcode'");
            $set_min = $this->input->post('set_min');
            $set_max = $this->input->post('set_max');
            if ($this->input->post('set_min') > $this->input->post('set_max') )
            {
                $this->session->set_flashdata('message', "Data Not Saved : Min Value is more than Max Value. Please try again");
                redirect('minmax_controller/scan_barcode?bin_ID='.$_SESSION['bin_ID']);
            }
            else
            {
                if($check_row->num_rows() == 0)
                {
                    $data = array(
                            'loc_group' => $_SESSION['locBin'],
                            'bin_id' => $_SESSION['bin_ID'],
                            'itemcode' => $itemcode,
                            'set_min' => $this->input->post('set_min'),
                            'set_max' => $this->input->post('set_max'),
                            );
        
                    $this->Minmax_Model->insert_sysrun($data);
                    redirect('minmax_controller/scan_barcode?bin_ID='.$_SESSION['bin_ID']);
                }
                else
                {
                     $data = array(
                            'loc_group' => $_SESSION['locBin'],
                            'bin_id' => $_SESSION['bin_ID'],
                            'itemcode' => $itemcode,
                            'set_min' => $this->input->post('set_min'),
                            'set_max' => $this->input->post('set_max'),
                            );
                     $this->Minmax_Model->update_sysrun($data);
                     redirect('minmax_controller/scan_barcode?bin_ID='.$_SESSION['bin_ID']);
                }
             }    
        }
        else
        {
            redirect('minmax_controller/backhome');
        }
    }
 
}
?>
