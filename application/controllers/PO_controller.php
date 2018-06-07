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
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {

          $data['po']=$this->PO_model->main();
         
         $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {

                $this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);
                
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


    public function search_sup()
    {
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/po/po_search');
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


    public function search_result()
    {
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $supname = $this->input->post('supname');
            $data['supname']=$this->PO_model->search_result($supname);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                

                $this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_search_results',$data);
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


    public function add_trans()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
           
          

            $supname = addslashes($_REQUEST['supname']);
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

    public function save_amount()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $data = array(
                'amt_inc_tax' => $this->input->post('amt_inc_tax'),
                'amt_exc_tax' => $this->input->post('amt_exc_tax'),
                'gst_amt' => $this->input->post('gst_amt'),
            );
            $this->db->where('web_guid', $_REQUEST['web_guid']);
            $this->db->update('backend.web_trans',$data);

            redirect('PO_controller/item_in_po?web_guid='.$_REQUEST['web_guid'].'&acc_code='.$_REQUEST['acc_code']);
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function item_in_po()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            //$web_guid = $this->input->post('guid');
            $web_guid = $_REQUEST['web_guid'];
            $acc_code = $_REQUEST['acc_code'];
            $web_c_guid = '';

            $acc_code_Data = array(
                'web_guid'=> $web_guid,
                'acc_code'=> $acc_code,
                'web_c_guid'=> $web_c_guid );
            $this->session->set_userdata($acc_code_Data);

            $data['amount'] = $this->db->query("SELECT * FROM backend.web_trans a where a.web_guid = '$web_guid' ");
            $data['item'] = $this->PO_model->item_in_po($web_guid);
            $data['header'] = $this->PO_model->item_in_po_header($web_guid);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/po/item_in_po',$data);
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


    public function scan_item()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $acc_code = $this->input->post('acc_code');
            $web_guid = $this->input->post('web_guid');
            $acc_name = addslashes($this->input->post('acc_name'));

            $acc_code_Data = array(

                'acc_code' => $acc_code,
                'web_guid' => $web_guid
            );
            $this->session->set_userdata($acc_code_Data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                

                $this->load->view('WinCe/header');
                $this->load->view('WinCe/po/scan_item_po',$acc_code_Data);
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


/*    public function scan_itemresult()
    {
        if($this->session->userdata('loginuser')== true)
        {
            $barcode = $this->input->post('barcode');
            $acc_code = $this->input->post('acc_code');
            $web_guid = $this->input->post('web_guid');
            //$web_c_guid = $this->input->post('web_c_guid');
            $iqty = $this->input->post('iqty');
            //$web

            $acc_code_Data = array(

                'acc_code' => $acc_code,
                'web_guid' => $web_guid,
                'barcode' => $barcode,
                //'web_c_guid' => $web_c_guid,
                'iqty'=> $iqty
            );
            $this->session->set_userdata($acc_code_Data);
             // added 2017-01-16
                 $check = $this->PO_model->checkguid($web_guid,$barcode);
                            if($check->num_rows() == 0)
                            {
                                    $result = $this->PO_model->itemresult_new($barcode);
                                    // changed 2017-1-17    
                                    $itemcode =  $result->row('itemcode');
                                    if($result->num_rows() != 0)
                                    {
                                    
                                        foreach($result->result() as $row)
                                        {
                                          //  $itemcode = $row->itemcode;
                                        }
                                        $data['itemresult'] = $result2 = $this->PO_model->itemresultSupCus($itemcode, $acc_code);
                                        if($result2->num_rows() > 0)
                                        {
                                            $data['itemresult'] = $this->PO_model->itemresult_new($barcode);
                                            $data['itemQOH'] = $this->PO_model->itemQOH($itemcode);
                                            $data['itemQty'] = $this->PO_model->itemQty($barcode, $web_guid);

                                            $browser_id = $_SERVER["HTTP_USER_AGENT"];
                                            if(strpos($browser_id,"Windows CE"))
                                             {
                                                $this->load->view('header');
                                                 $this->load->view('WinCe/po/scan_item_result', $data);
                                                $this->load->view('footer');
                                             } 

                                            else
                                            {
                                                 $this->load->view('header');
                                                 $this->load->view('po/scan_itemresult', $data);
                                                 $this->load->view('footer');
                                            }  
                                           
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
                        //changed 2017-01-17
                           }
                           else
                           {
                            $web_c_guid = $check->row('web_c_guid');
                            $check2 = $this->PO_model->edit_itemqty($web_c_guid);
                            $itemcode1 =  $check2->row('itemcode');
            
                                foreach($check2->result() as $row)
                                {
                                    $barcode = $row->barcode;
                                
                                    $web_c_guid = $row->web_c_guid;
                                   
                               }
                                    $data['itemresult'] = $this->PO_model->itemresult($barcode,$web_c_guid);
                                    $data['itemQOH'] = $this->PO_model->itemQOH($itemcode1);
                                    $data['itemQty'] = $this->PO_model->edit_itemqty($web_c_guid);
                                    $this->PO_model->reloadbillamt($web_guid);
                                    $this->load->view('header');
                                    $this->load->view('po/edit_itemresult', $data);
                                    $this->load->view('footer'); 

                        }     // end         
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
    }*/


   /* public function edit_item()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $acc_code = $this->input->post('acc_code');
            $web_guid = $this->input->post('web_guid');
            // $barcode = $_REQUEST['barcode'];
            // $itemcode = $_REQUEST['itemcode'];
            $web_c_guid = $_REQUEST['web_c_guid'];

            
            $check = $this->PO_model->edit_itemqty($web_c_guid);
            if($check -> num_rows() != 0)
            {

                foreach($check->result() as $row)
                {
                    $barcode = $row->barcode;
                    $web_c_guid = $row->web_c_guid;
                    $itemcode = $row->itemcode;
                }
                    $data['itemresult'] = $this->PO_model->itemresult($barcode,$web_c_guid);
                    $data['itemQOH'] = $this->PO_model->itemQOH($itemcode);
                    $data['itemQty'] = $this->PO_model->edit_itemqty($web_c_guid);
                    $this->PO_model->reloadbillamt($web_guid);
                    $this->load->view('header');
                    $this->load->view('po/edit_itemresult', $data);
                    $this->load->view('footer');
           
            
             }  
                else
                {
                    $this->load->database();
                    $this->load->model('Main_Model'); 
                    //$data['location']=$this->PO_model->main();
                    $this->PO_model->main();
                    $this->load->view('header');
                    $this->load->view('index', $data);
                    $this->load->view('footer');
                } 
        }
    }

        public function update_qty()
    {
        if($this->session->userdata('loginuser')== true)
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
        

            $result = $this->PO_model->update_qty($web_c_guid,$web_guid,$itemcode,$description,$sellingprice,$foc_qty,$barcode,$SinglePackQOH,$remark,$totalqty,$_amount);   
                
                // $this->load->database();
                // $this->load->model('PO_model'); 
                $data['web_guid'] = $this->PO_model->reloadmodel($web_guid);
                $this->PO_model->reloadbillamt($web_guid);
                $data['module_desc'] = $this->general_scan_model->checkModule($web_guid);
                $this->load->view('header');
                $this->load->view('po/scan_item_po',$data);
                $this->load->view('footer');

        
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function add_qty()
    {
        if($this->session->userdata('loginuser')== true)
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
        
                           

            $result = $this->PO_model->add_qty($web_c_guid,$web_guid,$itemcode,$description,$sellingprice,$foc_qty,$barcode,$SinglePackQOH,$remark,$totalqty,$_amount);   
                $data['web_guid'] = $this->PO_model->reloadmodel($web_guid);
                $data['module_desc'] = $this->general_scan_model->checkModule($web_guid);
                $this->PO_model->reloadbillamt($web_guid);
                $this->load->view('header');
                $this->load->view('general/scan_item',$data);
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
*/
    public function delete()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $web_guid = $_REQUEST['web_guid'];
            $delete = $this->PO_model->delete($web_guid);
            redirect('PO_controller/main');
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
           
            $delete = $this->PO_model->delete_item($web_c_guid);
            $data['item'] = $this->PO_model->item_in_po($web_guid);
            $data['header'] = $this->PO_model->item_in_po_header($web_guid);
            $this->PO_model->reloadbillamt($web_guid);
            //header("Refresh:0");
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/po/item_in_po',$data);
                }
            else
                {

                    $this->load->view('header');
                    $this->load->view('po/item_in_po',$data);
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

}
?>