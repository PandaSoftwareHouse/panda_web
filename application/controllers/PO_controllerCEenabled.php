<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PO_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('PO_model');
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
        
        if($this->session->userdata('loginuser')== true)
        {
    
        $data['po']=$this->PO_model->main();

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {

                $this->load->view('header');
                $this->load->view('WinCe/po/po_main',$data);
                $this->load->view('footer');
            }
        else
            {
                $this->load->view('header');
                $this->load->view('po/po_main',$data);
                $this->load->view('footer');
            }    
                
        }
        else
        {
            $this->load->database();
            $this->load->model('Main_Model'); 
            $data['location']=$this->Main_Model->location();
            $this->load->view('header');
            $this->load->view('index', $data);
            $this->load->view('footer');
        }
    }


    public function search_sup()
    {
        
        if($this->session->userdata('loginuser')== true)

        {
            $data['po']=$this->PO_model->main();

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {

                $this->load->view('header');
                $this->load->view('WinCe/po/po_search',$data);
                $this->load->view('footer');
            }

            else
            {

            $this->load->view('header');
            $this->load->view('po/po_search');
            $this->load->view('footer');

            }    
        }
        else
        {
            $this->load->database();
            $this->load->model('Main_Model'); 
            $data['location']=$this->Main_Model->location();
            $this->load->view('header');
            $this->load->view('index', $data);
            $this->load->view('footer');
        }
    }


    public function search_result()
    {
          
        if($this->session->userdata('loginuser')== true)
        {
            $supname = $this->input->post('supname');
            $data['supname']=$this->PO_model->search_result($supname);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                

                $this->load->view('header');
                $this->load->view('WinCe/po/po_search_results',$data);
                $this->load->view('footer');
            }

            else
            {
                $this->load->view('header');
                $this->load->view('po/po_search_results', $data);
                $this->load->view('footer');

            }    

        }
        else
        {
            $this->load->database();
            $this->load->model('Main_Model'); 
            $data['location']=$this->Main_Model->location();
            $this->load->view('header');
            $this->load->view('index', $data);
            $this->load->view('footer');
        }
    }


    public function add_trans()
    {
        if($this->session->userdata('loginuser')== true)
        {
           
            $supname = $_REQUEST['supname'];
            $supcode = $_REQUEST['supcode'];
            
            $this->PO_model->add_trans($supcode, $supname);
            if($this->db->affected_rows() > 0)
            {
                
                echo "<script>
                alert('Succesfully Add .');
                document.location='" . base_url() . "/index.php/PO_controller/main'
                </script>";
            }
            else
            {
                echo "<script>
                alert('Failed to Add .');
                document.location='" . base_url() . "/index.php/PO_controller/main'
                </script>";
            }
        
        
        }
        else
        {
            $this->load->database();
            $this->load->model('Main_Model'); 
            $data['location']=$this->Main_Model->location();
            $this->load->view('header');
            $this->load->view('index', $data);
            $this->load->view('footer');
        }
    }


    public function item_in_po()
    {
        if($this->session->userdata('loginuser')== true)
        {
            //$web_guid = $this->input->post('guid');
            $web_guid = $_REQUEST['guid'];

            $data['item'] = $this->PO_model->item_in_po($web_guid);
            $data['header'] = $this->PO_model->item_in_po_header($web_guid);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                

                $this->load->view('header');
                $this->load->view('WinCe/po/item_in_po',$data);
                $this->load->view('footer');
            }

            else 
            {
                $this->load->view('header');
                $this->load->view('po/item_in_po', $data);
                $this->load->view('footer');
            }
            
        }  
        else
        {
            $this->load->database();
            $this->load->model('Main_Model'); 
            $data['location']=$this->Main_Model->location();
            $this->load->view('header');
            $this->load->view('index', $data);
            $this->load->view('footer');
        }
        
    }


    public function scan_item()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $acc_code = $this->input->post('acc_code');
            $web_guid = $this->input->post('web_guid');
            $acc_name = $this->input->post('acc_name');

            $acc_code_Data = array(

                'acc_code' => $acc_code
                ,'web_guid' => $web_guid
                ,'acc_name' => $acc_name
            );
            $this->session->set_userdata($acc_code_Data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                

                $this->load->view('header');
                $this->load->view('WinCe/po/scan_item_po',$acc_code_Data);
                $this->load->view('footer');
            }
        

            else
            {
                $this->load->view('header');
                $this->load->view('po/scan_item_po', $acc_code_Data);
                $this->load->view('footer');
            }    
            
            
        }  

        else
        {
            $this->load->database();
            $this->load->model('Main_Model'); 
            $data['location']=$this->Main_Model->location();
            $this->load->view('header');
            $this->load->view('index', $data);
            $this->load->view('footer');
        } 
    }


    public function scan_itemresult()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $barcode = $this->input->post('barcode');
            $acc_code = $this->input->post('acc_code');
            $web_guid = $this->input->post('web_guid');

            $acc_code_Data = array(

                'acc_code' => $acc_code,
                'web_guid' => $web_guid
            );
            $this->session->set_userdata($acc_code_Data);

            $result = $this->PO_model->itemresult($barcode);
            if($result->num_rows() != 0)
            {
                foreach($result->result() as $row)
                {
                    $itemcode = $row->itemcode;
                }
                $data['itemresult'] = $result2 = $this->PO_model->itemresultSupCus($itemcode, $acc_code);
                if($result2->num_rows() != 0)
                {
                    $data['itemresult'] = $this->PO_model->itemresult($barcode);
                    $data['itemresultSupCus'] = $this->PO_model->itemresultSupCus($itemcode, $acc_code);
                    $data['itemQOH'] = $this->PO_model->itemQOH($itemcode);
                    $data['itemQty'] = $this->PO_model->itemQty($barcode, $web_guid);
                    $this->load->view('header');
                    $this->load->view('po/scan_itemresult', $data);
                    $this->load->view('footer');
                }
                else
                {
                    echo "<script>
                    alert('Item Not Listed .');
                    </script>";
                    $this->load->view('header');
                    $this->load->view('po/scan_item_po', $acc_code_Data);
                    $this->load->view('footer');
                }
                
            }
            else
            {
                echo "<script>
                alert('Item Not Found .');
                </script>";
                $this->load->view('header');
                $this->load->view('po/scan_item_po', $acc_code_Data);
                $this->load->view('footer');

            }     
        }  
        else
        {
            $this->load->database();
            $this->load->model('Main_Model'); 
            $data['location']=$this->Main_Model->location();
            $this->load->view('header');
            $this->load->view('index', $data);
            $this->load->view('footer');
        } 
    }


    public function edit_item()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $acc_code = $this->input->post('acc_code');
            $web_guid = $this->input->post('web_guid');
            $acc_name = $this->input->post('acc_name');

            $acc_code_Data = array(

                'acc_code' => $acc_code
                ,'web_guid' => $web_guid
                ,'acc_name' => $acc_name
            );
            $this->session->set_userdata($acc_code_Data);
            $this->load->view('header');
            $this->load->view('po/scan_itemresult', $acc_code_Data);
            $this->load->view('footer');
            
        }  
        else
        {
            $this->load->database();
            $this->load->model('Main_Model'); 
            $data['location']=$this->Main_Model->location();
            $this->load->view('header');
            $this->load->view('index', $data);
            $this->load->view('footer');
        } 
    }


    public function add_qty()
    {
        if($this->session->userdata('loginuser')== true)
        {
            
        $web_c_guid= $this->input->post('web_c_guid'); 
        $web_guid = $this->input->post('web_guid');
        $itemcode = $this->input->post('itemcode');
        $description = $this->input->post('description');
        $sellingprice = $this->input->post('sellingprice');
        $foc_qty = $this->input->post('foc_qty');
        $barcode = $this->input->post('barcode');
        $SinglePackQOH = $this->input->post('SinglePackQOH');
        //barcode_actual
        //sold_by_weight
        $qty = $this->input->post('qty');
        $remark = $this->input->post('remark');
            
            $result = $this->PO_model->add_qty($web_c_guid,$web_guid,$itemcode,$description,$sellingprice,$foc_qty,$barcode,$SinglePackQOH,$qty,$remark); 


           // if($result->affected_rows() != 0 )
           //   {            
                redirect('PO_controller/scan_item');
            //    echo "<script> alert('succesfully add');</script>";   
            //  }
            // else
            //  {
            //     $result  = $this->Main_Model->PO_model;
            //     redirect('PO_controller/scan_item');
            //     echo "<script> alert('succesfully add');</script>";
        
            // } 
        
        }
        else
        {
            $this->load->database();
            $this->load->model('Main_Model'); 
            $data['location']=$this->Main_Model->location();
            $this->load->view('header');
            $this->load->view('index', $data);
            $this->load->view('footer');
        }
    }


}
?>