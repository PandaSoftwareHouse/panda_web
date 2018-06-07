<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SO_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('SO_model');
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
        
        $data['so']=$this->SO_model->main();

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
        {  
            $this->load->view('WinCe/header');
            $this->load->view('WinCe/so/so_main', $data);
        

        }
        else  
        {
            $this->load->view('header');
            $this->load->view('so/so_main', $data);
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


    public function search_supcus()
    {
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $data['so']=$this->SO_model->main();

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
            {  
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/so/so_search', $data);
            
            }
            else
            {
                $this->load->view('header');
                $this->load->view('so/so_search',$data);
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


    public function search_result()
    {
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $supname = $this->input->post('supname');

            $data['supname']=$this->SO_model->search_result($supname);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))

        {
            $this->load->view('WinCe/header');
            $this->load->view('WinCe/so/so_search_results',$data);
            
        }
        else
        {
            $this->load->view('header');
            $this->load->view('so/so_search_results',$data);
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


    public function add_trans()
    {
       
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
           
            $supname = addslashes($_REQUEST['supname']);
            $supcode = $_REQUEST['supcode'];
            
            $this->SO_model->add_trans($supcode, $supname);
            if($this->db->affected_rows() > 0)
            {
                
                echo "<script>
                alert('Succesfully Add .');
                document.location='" . base_url() . "/index.php/SO_controller/main'
                </script>";
            }
            else
            {
                echo "<script>
                alert('Failed to Add .');
                document.location='" . base_url() . "/index.php/SO_controller/main'
                </script>";
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
                    $this->load->view('WinCe/index', $data);
                }
            else
                {
                   $this->load->view('header');
                   $this->load->view('index', $data);
                   $this->load->view('footer');  
                }        
            
        }
    }


    public function item_in_so()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            //$web_guid = $this->input->post('guid');
            $web_guid = $_REQUEST['web_guid'];

            $data['item'] = $this->SO_model->item_in_so($web_guid);
            $data['header'] = $this->SO_model->item_in_so_header($web_guid);

            $acc_code_Data = array(
                'web_guid' => $web_guid
            );
            $this->session->set_userdata($acc_code_Data);
            $this->SO_model->reloadbillamt($web_guid);
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/so/item_in_so', $data);
                
            }
            else
            {
                $this->load->view('header');
                $this->load->view('so/item_in_so', $data);
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

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/so/scan_item_so');
            }
            else
            {
                $this->load->view('header');
                $this->load->view('so/scan_item_so');
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

         public function scan_itemresult()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $barcode = $this->input->post('barcode');
           $acc_code = $this->input->post('acc_code');
            $web_guid = $this->input->post('web_guid');
            $web_c_guid = $this->input->post('web_c_guid');
        /*    $iqty = $this->input->post('iqty');*/

            $acc_code_Data = array(

               'acc_code' => $acc_code,
                'web_guid' => $web_guid,
                'barcode' => $barcode,
                'web_c_guid' => $web_c_guid,
                /*'iqty'=> $iqty*/
            );
            $this->session->set_userdata($acc_code_Data);

            $result = $this->SO_model->itemresult($barcode,$web_c_guid);




            if($result->num_rows() != 0)
            {
                foreach($result->result() as $row)
                {
                    $itemcode = $row->itemcode;
                }
              //  $data['itemresult'] = $result2 = $this->SO_model->itemresultSupCus($itemcode, $acc_code);
               // if($result2->num_rows() != 0)
                //{
                  if($result->num_rows() != 0)
                {
                    $data['itemresult'] = $this->SO_model->itemresult($barcode,$web_c_guid);
                    //$data['itemresultSupCus'] = $this->PO_model->itemresultSupCus($itemcode, $acc_code);
                    $data['itemQOH'] = $this->SO_model->itemQOH($itemcode);
                     $data['itemQty'] = $this->SO_model->itemQty($barcode, $web_guid);

                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE")) 
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/so/scan_itemresult', $data);
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('so/scan_itemresult', $data);
                            $this->load->view('footer'); 
                        }    
                }
                else
                {
                    echo "<script>
                    alert('Item Not Listed .');
                    </script>";
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/so/scan_item_so', $acc_code_Data);
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('so/scan_item_so', $acc_code_Data);
                            $this->load->view('footer');
                        }    
                }
                
                
            }
            else
            {
                echo "<script>
                alert('Item Not Foundsss .');
                </script>";
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/so/scan_item_so', $acc_code_Data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('so/scan_item_so', $acc_code_Data);
                        $this->load->view('footer');
                    }    
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
                    $this->load->view('WinCe/index', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('index', $data);
                    $this->load->view('footer');
                }    
        } 
    }


     public function add_qty()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {

        $web_c_guid = $this->input->post('web_c_guid');
        $web_guid = $this->input->post('web_guid');
        $itemcode = $this->input->post('itemcode');
        $description = $this->input->post('description');
        $sellingprice = $this->input->post('sellingprice');
        $foc_qty = $this->input->post('foc_qty');
        $barcode = $this->input->post('barcode');
        $SinglePackQOH = $this->input->post('SinglePackQOH');
        $iqty = $this->input->post('iqty');
        $defaultqty = $this->input->post('defaultqty');
        //barcode_actual
        //sold_by_weight
        $qty = $this->input->post('qty');
        $remark = $this->input->post('remark');
            
        $_amount = ($defaultqty+$qty+$iqty)*$sellingprice;
        //$pqty = $defaultqty + $iqty;
        $totalqty  = $foc_qty+$iqty+$defaultqty;
        

            $result = $this->SO_model->add_qty($web_c_guid,$web_guid,$itemcode,$description,$sellingprice,$foc_qty,$barcode,$SinglePackQOH,$remark,$totalqty,$_amount);   
                
                // $this->load->database();
                // $this->load->model('PO_model'); 
                $data['web_guid'] = $this->SO_model->reloadmodel($web_guid);
                $this->SO_model->reloadbillamt($web_guid);
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/so/scan_item_so',$data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('so/scan_item_so',$data);
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
                    $this->load->view('WinCe/index', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('index', $data);
                    $this->load->view('footer');
                }    
        }
    }

// added on 2017-1-14
     public function edit_item()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $acc_code = $this->input->post('acc_code');
            $web_guid = $this->input->post('web_guid');
            // $barcode = $_REQUEST['barcode'];
            // $itemcode = $_REQUEST['itemcode'];
            $web_c_guid = $_REQUEST['web_c_guid'];

            
            $check = $this->SO_model->edit_itemqty($web_c_guid);
            if($check -> num_rows() != 0)
            {

                foreach($check->result() as $row)
                {
                    $barcode = $row->barcode;
                    $web_c_guid = $row->web_c_guid;
                    $itemcode = $row->itemcode;
                }
                    $data['itemresult'] = $this->SO_model->itemresult($barcode,$web_c_guid);
                    $data['itemQOH'] = $this->SO_model->itemQOH($itemcode);
                    $data['itemQty'] = $this->SO_model->edit_itemqty($web_c_guid);
                    $this->SO_model->reloadbillamt($web_guid);

                     $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/so/edit_itemresult', $data);
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('so/edit_itemresult', $data);
                            $this->load->view('footer');
                        }   
           
            
             }  
                else
                {
                    $this->load->database();
                    $this->load->model('Main_Model'); 
                    //$data['location']=$this->PO_model->main();
                    $this->SO_model->main();

                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/index', $data);
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('index', $data);
                            $this->load->view('footer');
                        }    
                } 
        }
    }

        public function update_qty()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {

        $web_c_guid = $this->input->post('web_c_guid');
        $web_guid = $this->input->post('web_guid');
        $itemcode = $this->input->post('itemcode');
        $description = $this->input->post('description');
        $sellingprice = $this->input->post('sellingprice');
        $foc_qty = $this->input->post('foc_qty');
        $barcode = $this->input->post('barcode');
        $SinglePackQOH = $this->input->post('SinglePackQOH');
        $iqty = $this->input->post('iqty');
        $defaultqty = $this->input->post('defaultqty');
        //barcode_actual
        //sold_by_weight
        $qty = $this->input->post('qty');
        $remark = $this->input->post('remark');
            
        $_amount = ($defaultqty+$qty+$iqty)*$sellingprice;
        //$pqty = $defaultqty + $iqty;
        $totalqty  = $foc_qty+$iqty+$defaultqty;
        

            $result = $this->SO_model->update_qty($web_c_guid,$web_guid,$itemcode,$description,$sellingprice,$foc_qty,$barcode,$SinglePackQOH,$remark,$totalqty,$_amount);   
                
                // $this->load->database();
                // $this->load->model('PO_model'); 
                $data['web_guid'] = $this->SO_model->reloadmodel($web_guid);
                $this->SO_model->reloadbillamt($web_guid);

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/so/scan_item_so',$data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('so/scan_item_so',$data);
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
                    $this->load->view('WinCe/index', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('index', $data);
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

            
           
            $delete = $this->SO_model->delete_item($web_c_guid);
            $data['item'] = $this->SO_model->item_in_so($web_guid);
            $data['header'] = $this->SO_model->item_in_so_header($web_guid);
            $this->SO_model->reloadbillamt($web_guid);
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/index', $data);
                }
            else
                {    
                    $this->load->view('header');
                    $this->load->view('so/item_in_so',$data);
                    $this->load->view('footer');
                }    
        }  
        else
        {
         redirect('main_controller');
        }
        
    }

}
?>