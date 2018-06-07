<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pandarequest_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('pandarequest_model');
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
        redirect('pandarequest_controller/home');
    }


    public function home()
    {
        
        if($this->session->userdata('loginuser')== true)
        {

            $data['menu']=$this->pandarequest_model->home_data();
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCE/pandarequest/header');
                $this->load->view('WinCE/pandarequest/home', $data);
                $this->load->view('pandarequest/footer');
            }
            else
            {
                $this->load->view('pandarequest/header');
                $this->load->view('pandarequest/home', $data);
                $this->load->view('pandarequest/footer');
            }

        }
        else
        {
            $this->load->view('pandarequest/header');
            $this->load->view('pandarequest/index');
            $this->load->view('pandarequest/footer');
        }
    }


    public function view_transaction()
    {
        if($this->session->userdata('loginuser')== true)
        {
          
        $this->load->database();  
        $this->load->model('pandarequest_model');  
        //$data['transaction_today'] = $result  = $this->pandarequest_model->transaction_today();
        $data['sysrun'] = $result  = $this->pandarequest_model->identify_sysrun();  
        $data['transactions']=$this->pandarequest_model->transaction_data();  
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCE/pandarequest/header');
                $this->load->view('WinCE/pandarequest/transaction', $data);
                $this->load->view('pandarequest/footer');
            }
            else
            {
                $this->load->view('pandarequest/header');
                $this->load->view('pandarequest/transaction', $data);
                $this->load->view('pandarequest/footer');
            }
        }
        else
        {
            redirect('pandarequest_controller/backhome');
            
        }
    }

//not use
    public function add_transaction()
    {
        if($this->session->userdata('loginuser')== true)
        {
        
        $username = $this->input->post('username');
        $run_code = $this->input->post('run_code');
        $run_year = $this->input->post('run_year');
        $run_month = $this->input->post('run_month');
        $run_day = $this->input->post('run_day');
        $run_currentno = $this->input->post('run_currentno');
        $run_digit = $this->input->post('run_digit');
        
            
        if ($this->input->post('add') == "Login")
        {
            $result  = $this->pandarequest_model->add_transaction_data($username);   
            if($result > 0)
            {
                    
                //set the session variables
                $sessiondata = array(
                              
                    //'supcode' => $supcode,
                    //'supname' => $supname,
                             
                );
                         
                $this->session->set_userdata($sessiondata);
                redirect('pandarequest_controller/view_transaction');
                echo "<script> alert('succesfully add');</script>";   
            }
            else
            {
                echo "<script> alert('cannot add in');</script>";
                $this->load->view('pandarequest/header');
                $this->load->view('pandarequest/transaction');
                $this->load->view('pandarequest/footer');
            }
        }


        if ($this->input->post('add2') == "Login")
        {   
            $data['sysrun'] = $result  = $this->pandarequest_model->identify_sysrun();   
            if($result->num_rows() != 0 )
            {
                    
                //set the session variables
                $sessiondata = array(
                              
                    //'supcode' => $supcode,
                    //'supname' => $supname,
                             
                );
                $this->pandarequest_model->update_sysrun();
                $this->pandarequest_model->add_refno($username, $run_code, $run_year, $run_month, $run_day, $run_currentno, $run_digit);
                $this->session->set_userdata($sessiondata);
                redirect('pandarequest_controller/view_transaction', $data);
                echo "<script> alert('succesfully add');</script>";   
            }
            else
            {
                $result  = $this->pandarequest_model->insert_sysrun();
                redirect('pandarequest_controller/view_transaction');
                echo "<script> alert('succesfully add');</script>";
            }
        }
        
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }


    public function add_transID()
    {
        if($this->session->userdata('loginuser')== true)
        {
        
        // $username = $this->input->post('username');
        // $run_code = $this->input->post('run_code');
        // $run_year = $this->input->post('run_year');
        // $run_month = $this->input->post('run_month');
        // $run_day = $this->input->post('run_day');
        // $run_currentno = $this->input->post('run_currentno');
        // $run_digit = $this->input->post('run_digit');

        $data['sysrun'] = $result  = $this->pandarequest_model->identify_TransID();
            if($result->num_rows() != 0 )
            {
                redirect('pandarequest_controller/scan_binID_view', $data);
                echo "<script> alert('succesfully add');</script>"; 
            }
            else
            {
                $result  = $this->pandarequest_model->insert_TransID();
                redirect('pandarequest_controller/view_transaction');
                echo "<script> alert('succesfully add');</script>";
            }
        
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }


    public function view_item()
    {   
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $_REQUEST['guidpost'];
            $Bin_ID = $_REQUEST['Bin_ID'];
            $data['header']=$this->pandarequest_model->header_view_item($guid);  
            $data['view']=$this->pandarequest_model->view_item($guid,$Bin_ID);
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCE/pandarequest/header');
                $this->load->view('WinCE/pandarequest/view_item', $data);
                $this->load->view('pandarequest/footer');
            }
            else
            {
                $this->load->view('pandarequest/header');
                $this->load->view('pandarequest/view_item', $data);
                $this->load->view('pandarequest/footer');
            }

        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }


    
    public function view_bin()
    {   
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $_REQUEST['guidpost'];

            $data['header']=$this->pandarequest_model->header_view_item($guid);  
            $data['view']=$this->pandarequest_model->view_bin($guid);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCE/pandarequest/header');
                $this->load->view('WinCE/pandarequest/view_bin', $data);
                $this->load->view('pandarequest/footer');
            }
            else
            {
                $this->load->view('pandarequest/header');
                $this->load->view('pandarequest/view_bin', $data);
                $this->load->view('pandarequest/footer');
            }

        }
        else
        {
            redirect('pandarequest_controller/backhome');
            
        }
    }


    public function done_view_item()
    {
        if($this->session->userdata('loginuser')== true)
        { 
            $this->load->database();  
            $this->load->model('pandarequest_model');  
            $data['item']=$this->pandarequest_model->done_view_item();  
            $this->load->view('pandarequest/header');
            $this->load->view('pandarequest/done_view_item', $data);
            $this->load->view('pandarequest/footer');
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }

//not use
    public function print_doc()
    {
        if($this->session->userdata('loginuser')== true)
        { 
        $this->load->view('pandarequest/header');
        $this->load->view('pandarequest/print');
        $this->load->view('pandarequest/footer');
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }


    public function sendprint_stockpick()
    {
        if($this->session->userdata('loginuser')== true)
        { 
    
            $this->pandarequest_model->sendprint();
            if($this->db->affected_rows() > 0)
            {
                //echo "<script> alert('succesfully add');</script>";
                //redirect("/home_c/viewdata");
                echo "<script>
                alert('Succesfully Print .');
                document.location='" . base_url() . "/index.php/pandarequest_controller/stock_view_transaction'
                </script>";
            }
            else
            {
                echo "<script>
                alert('Document Already Print .');
                document.location='" . base_url() . "/index.php/pandarequest_controller/stock_view_transaction'
                </script>";
            }

        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }


    public function sendprint()
    {
        if($this->session->userdata('loginuser')== true)
        { 
    
            $this->pandarequest_model->sendprint();
            if($this->db->affected_rows() > 0)
            {
                //echo "<script> alert('succesfully add');</script>";
                //redirect("/home_c/viewdata");
                echo "<script>
                alert('Succesfully Print .');
                document.location='" . base_url() . "/index.php/pandarequest_controller/view_transaction'
                </script>";
            }
            else
            {
                echo "<script>
                alert('Document Already Print .');
                document.location='" . base_url() . "/index.php/pandarequest_controller/view_transaction'
                </script>";
            }

        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }


    public function scan_binID_view()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCE/pandarequest/header');
                $this->load->view('WinCE/pandarequest/scan_binID');
                $this->load->view('pandarequest/footer');
            }
            else
            {
                $this->load->view('pandarequest/header');
                $this->load->view('pandarequest/scan_binID');
                $this->load->view('pandarequest/footer');
            }
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }


    public function scanbarcodeview()
    {
        if($this->session->userdata('loginuser')== true)
        {
 
            $data['item']=$this->pandarequest_model->view_item_scan();
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCE/pandarequest/header');
                $this->load->view('WinCE/pandarequest/scanbarcode', $data);
                $this->load->view('pandarequest/footer');
            }
            else
            {
                $this->load->view('pandarequest/header');
                $this->load->view('pandarequest/scanbarcode', $data);
                $this->load->view('pandarequest/footer');
            }  
            
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }


    public function scanbarcode()
    {
        if($this->session->userdata('loginuser')== true)
        { 
        
        $barcode = $this->input->post('barcode');
        $guid = $this->input->post('guid');
            
        if ($this->input->post('barcode') != "")
        {

            $data['item']=$this->pandarequest_model->view_item_scan();
            $data['qty_balance']=$this->pandarequest_model->qty_balance($barcode);
            $data['guid']=$this->pandarequest_model->guid($guid);  
            $data['h']=$this->pandarequest_model->scanbarcode_data($barcode);
            $data['h1']=$this->pandarequest_model->scanbarcode_data1($barcode);
            $sessiondata = array(
                              
                    'barcode' => $barcode,
                    'guid' => $guid
                             
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCE/pandarequest/header');
                $this->load->view('WinCE/pandarequest/scanresult', $data, $sessiondata);
                $this->load->view('pandarequest/footer');
            }
            else
            {
                $this->load->view('pandarequest/header');
                $this->load->view('pandarequest/scanresult', $data, $sessiondata);
                $this->load->view('pandarequest/footer');
            } 
        }
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
        
    }


    public function scan_binID()
    {
        if($this->session->userdata('loginuser')== true)
        { 
        
        $bin_ID = $this->input->post('bin_ID');
            
        if ($this->input->post('bin_ID') != "")
        {

            $data['binID'] = $result  = $this->pandarequest_model->check_binID($bin_ID);   
            if($result->num_rows() != 0 )
            {

                $data['item']=$this->pandarequest_model->scan_binID($bin_ID);
                $bin_ID_Data = array(
                                      
                    'bin_ID' => $bin_ID   
                    );
                $this->session->set_userdata($bin_ID_Data);
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCE/pandarequest/header');
                    $this->load->view('WinCE/pandarequest/scanbarcode', $data, $bin_ID_Data);
                    $this->load->view('pandarequest/footer');
                }
                else
                {
                    $this->load->view('pandarequest/header');
                    $this->load->view('pandarequest/scanbarcode', $data, $bin_ID_Data);
                    $this->load->view('pandarequest/footer');
                }
                
            }
            else
            {
                echo "<script>
                alert('Bin ID Not Exist.');
                document.location='" . base_url() . "/index.php/pandarequest_controller/scan_binID_view'
                </script>";
            } 
        }
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
        
    }

//not used
    public function action()
    {   
        if($this->session->userdata('loginuser')== true)
        { 
        
        $guid = $this->input->post('guid');
        $description = $this->input->post('Description');
        $itemcode = $this->input->post('Itemcode');
        $itemlink = $this->input->post('ItemLink');
        $qoh = $this->input->post('OnHandQty');
        $qty_request = $this->input->post('qty_request');
        
        $description1 = $this->input->post('Description1');
        $itemcode1 = $this->input->post('Itemcode1');
        $itemlink1 = $this->input->post('ItemLink1');
        $qoh1 = $this->input->post('OnHandQty1');
        
        if ($this->input->post('add') == "add")//add item and go back to scan item
        {
            
            $this->load->database();  
            //load the model  
            $this->load->model('pandarequest_model');  
            //load the method of model
            $data['h']=$this->pandarequest_model->add_request ($guid, $itemcode, $description, $itemlink, $qoh, $qty_request);
            //return the data in view
            redirect('pandarequest_controller/view_transaction');
            //$this->load->view('header');
            //$this->load->view('scanbarcode');
            //$this->load->view('footer');
            
        }
        if ($this->input->post('go') == "go")//add item and go to submited page
        {
            //load the database  
            $this->load->database();  
            //load the model  
            $this->load->model('Pending_Trans_model');  
            //load the method of model  
            $data['h']=$this->Pending_Trans_model->add_item_data($guid, $itemcode, $barcode, $itemname, $qty);  
            //return the data in view
            redirect("pending_submit_c/viewdata");
        
        }
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }


    public function add_request()
    {   
        if($this->session->userdata('loginuser')== true)
        { 
        
        $guid = $this->input->post('guid');
        $description = $this->input->post('Description');
        $itemcode = $this->input->post('Itemcode');
        $itemlink = $this->input->post('ItemLink');
        $qoh = $this->input->post('OnHandQty');
        $qty_request = $this->input->post('qty_request');
        
        $description1 = $this->input->post('Description1');
        $itemcode1 = $this->input->post('Itemcode1');
        $itemlink1 = $this->input->post('ItemLink1');
        $qoh1 = $this->input->post('OnHandQty1');
        $qty_balance = $this->input->post('qty_balance');
        $qty_requested = $this->input->post('qty_requested');


        if ($this->input->post('add') == "add")//add item and go back to scan item
        {
            
            $this->load->database();  
            $this->load->model('pandarequest_model');  
            $result2 =$this->pandarequest_model->add_request ($guid, $itemcode, $description, $itemlink, $qoh, $qty_request, $qty_balance, $qty_requested);
            $result = $this->pandarequest_model->update_desc();
            $this->load->helper('url'); 
            if($this->db->affected_rows() > 0)
            {
                echo "<script>
                alert('Succesfully Request.');
                document.location='" . base_url() . "/index.php/pandarequest_controller/scanbarcodeview'
                </script>";
            }
            else
            {
                echo "<script>
                alert('Failed to Request.');
                document.location='" . base_url() . "/index.php/pandarequest_controller/view_transaction'
                </script>";
            }
            
        }

        if ($this->input->post('go') == "go")//add item and go back to scan item
        {
              
            $this->load->database();  
            $this->load->model('pandarequest_model');  
            $result2 =$this->pandarequest_model->add_request ($guid, $itemcode, $description, $itemlink, $qoh, $qty_request, $qty_balance);
            $result = $this->pandarequest_model->update_desc();
            if($this->db->affected_rows() > 0)
            {
                echo "<script>
                alert('Succesfully Request.');
                document.location='" . base_url() . "/index.php/pandarequest_controller/scan_binID_view'
                </script>";
            }
            else
            {
                echo "<script>
                alert('Failed to Request.');
                document.location='" . base_url() . "/index.php/pandarequest_controller/view_transaction'
                </script>";
            }
            
        }
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }


    public function add_requestWinCE()
    {   
        if($this->session->userdata('loginuser')== true)
        { 
        
        $guid = $this->input->post('guid');
        $description = $this->input->post('Description');
        $itemcode = $this->input->post('Itemcode');
        $itemlink = $this->input->post('ItemLink');
        $qoh = $this->input->post('OnHandQty');
        $qty_request = $this->input->post('qty_request');
        
        $description1 = $this->input->post('Description1');
        $itemcode1 = $this->input->post('Itemcode1');
        $itemlink1 = $this->input->post('ItemLink1');
        $qoh1 = $this->input->post('OnHandQty1');
        $qty_balance = $this->input->post('qty_balance');
        $qty_requested = $this->input->post('qty_requested');

            
            $this->load->database();  
            $this->load->model('pandarequest_model');  
            $result2 =$this->pandarequest_model->add_request ($guid, $itemcode, $description, $itemlink, $qoh, $qty_request, $qty_balance, $qty_requested);
            $result = $this->pandarequest_model->update_desc();
            $this->load->helper('url'); 
            if($this->db->affected_rows() > 0)
            {
                echo "<script>
                alert('Succesfully Request.');
                document.location='" . base_url() . "/index.php/pandarequest_controller/scanbarcodeview'
                </script>";
            }
            else
            {
                echo "<script>
                alert('Failed to Request.');
                document.location='" . base_url() . "/index.php/pandarequest_controller/view_transaction'
                </script>";
            }
        
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }



    public function stock_view_transaction()
    {
        if($this->session->userdata('loginuser')== true)
        {
            
            $data['transactions']=$this->pandarequest_model->transaction_data(); 
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCE/pandarequest/header');
                $this->load->view('WinCE/pandarequest/stock_transaction', $data);
                $this->load->view('pandarequest/footer');
            }
            else
            {
                $this->load->view('pandarequest/header');
                $this->load->view('pandarequest/stock_transaction', $data);
                $this->load->view('pandarequest/footer');
            }
        
        }
        else
        {
            redirect('pandarequest_controller/backhome');
            
        }
    }


    public function stock_view_item()
    {   
        if($this->session->userdata('loginuser')== true)
        {
            $guid = $_REQUEST['guidpost'];
            $data['header']=$this->pandarequest_model->header_view_item($guid);  
            $data['view']=$this->pandarequest_model->view_item2($guid);
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCE/pandarequest/header');
                $this->load->view('WinCE/pandarequest/stockpick_scanbarcode', $data);
                $this->load->view('pandarequest/footer');
            }
            else
            {
                $this->load->view('pandarequest/header');
                $this->load->view('pandarequest/stockpick_scanbarcode', $data);
                $this->load->view('pandarequest/footer');
            }
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
    }


    public function add_qty_pick()
    {
        if($this->session->userdata('loginuser')== true)
        {

        $qty_balance = $this->input->post('qty_balance');
        $qty_request = $this->input->post('qty_request');
        $qty_pick = $this->input->post('qty_pick');
        $Itemcode = $this->input->post('Itemcode');
        $Trans_ID = $this->input->post('Trans_ID');

        $this->load->database();
        $this->load->model('pandarequest_model');
        $result = $this->pandarequest_model->add_qty_pick($Itemcode, $qty_pick, $Trans_ID, $qty_request, $qty_balance);
        if($this->db->affected_rows() > 0)
            {
                
                echo "<script>
                alert('Succesfully Pick.');
                document.location='" . base_url() . "/index.php/pandarequest_controller/stock_view_transaction'
                </script>";
            }
            else
            {
                echo "<script>
                alert('Failed To Pick.');
                document.location='" . base_url() . "/index.php/pandarequest_controller/stock_view_transaction'
                </script>";
            }
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
        
    }


    public function scan_item_request()
    {
        if($this->session->userdata('loginuser')== true)
        { 
        
        $barcode = $this->input->post('barcode');
        $TransID = $this->input->post('TransID');
            
        if ($this->input->post('barcode') != "")
        {    
            $this->load->database();  
            $this->load->model('pandarequest_model');
            $data['TransID']=$this->pandarequest_model->TransID($TransID);
            $data['item']=$this->pandarequest_model->scan_item_request($barcode, $TransID);
            $sessiondata = array(
                              
                    'barcode' => $barcode,
                    'guid' => $TransID
                             
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCE/pandarequest/header');
                $this->load->view('WinCE/pandarequest/stockpick_scanresult', $data, $sessiondata);
                $this->load->view('pandarequest/footer');
            }
            else
            {
                $this->load->view('pandarequest/header');
                $this->load->view('pandarequest/stockpick_scanresult', $data, $sessiondata);
                $this->load->view('pandarequest/footer');
            }
        }
        }
        else
        {
            redirect('pandarequest_controller/backhome');
        }
        
    }
 
}
?>
