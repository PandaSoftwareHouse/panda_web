<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class general_scan_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('main_model');
        $this->load->model('general_scan_model');
        $this->load->model('adjout_model');
        $this->load->model('adjin_model');
        $this->load->model('IBT_model');
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
    // 2017-01-20

    public function scan_item()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            //$this->session->set_flashdata($get_weight,$get_price);
            $_SESSION['get_weight'] = '';
            $_SESSION['get_price'] = '';
            $_SESSION['itemcode'] = '';
            $_SESSION['barcode'] = '';

            
            $acc_code = $_REQUEST['acc_code'];
            $web_guid = $_REQUEST['web_guid'];
            $_module = $this->general_scan_model->checkModule($web_guid);
            $mod =  $_module->row('module_desc');

            if ($mod == 'PO' && $acc_code == '')
            {
                $acc_code = $_REQUEST['acc_code'];
                $web_guid = $_REQUEST['web_guid'];
                $mod = $_REQUEST['module_desc'];
            }
            elseif ($web_guid == '')
            {
                $web_guid = $_REQUEST['web_guid'];
            };
                if ($mod == 'PO')
                {
                    $back = site_url('PO_controller/item_in_po?web_guid='.$web_guid.'&acc_code='.$acc_code);
                }
                elseif ($mod == 'Sales Order')
                {
                    $back = site_url('SO_controller/item_in_so?web_guid='.$web_guid.'&acc_code='.$acc_code);
                }
                elseif ($mod == 'IBT Req')
                {
                    $back = site_url('IBT_controller/item_in_IBT?web_guid='.$web_guid);
                }
                elseif ($mod == 'Adjust-In')
                {
                    $back = site_url('adjin_controller/itemlist?web_guid='.$web_guid);
                }
                elseif ($mod == 'Adjust-Out')
                {
                    $back = site_url('adjout_controller/itemlist?web_guid='.$web_guid);
                }
                elseif ($mod == 'POS')
                {
                    $back = site_url('Mpos_controller/itemlist?web_guid='.$web_guid);
                }
                elseif ($mod == 'Simple SO')
                {
                    $back = site_url('simpleso_controller/itemlist?web_guid='.$web_guid);
                }
                else
                {
                    $back = site_url('main_controller');
                }
            $acc_code_Data = array(
                'acc_code' => $acc_code
                ,'web_guid' => $web_guid
                , 'module_desc'=> $mod
                // , 'sold_by_weight' => $sold_by_weight
                                );
            $this->session->set_userdata($acc_code_Data);
            
             $data = array (
                'module_desc' => $this->general_scan_model->checkModule($web_guid),
                'back' => $back,
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/general/scan_item', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('general/scan_item', $data);
                    $this->load->view('footer');
                }   
        }  
        else
        {
           redirect('main_controller');
        } 
    }


    public function scan_itemresult()
    {
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            if ($this->input->post('barcode') != '')
            {
                $barcode = $this->input->post('barcode');
            }
            else
            {
                $web_c_guid = $_REQUEST['web_c_guid'];
                $barcode = '0';
            }

            if(strpos($barcode,'*'))
            {
                $barcode_explode = explode('*', $barcode);

                $barcode = $barcode_explode[1];
                $_SESSION['decode_qty'] = round($barcode_explode[0]);
            }
            else
            {
                $_SESSION['decode_qty'] = 0;
            }


            if ($_SESSION['web_guid'] != '')
            { 
                $web_guid = $_SESSION['web_guid']; 
            }
            else
            {
                $web_guid = $_REQUEST['web_guid'];
            }

            if ($this->input->post('module_desc') != '')
            {
                $module = $this->input->post('module_desc');
            }
            else
            {
                $module1 = $this->general_scan_model->checkModule($web_guid);
                $module = $module1->row('module_desc');
            }

            $acc_code_Data = array(
                'module_desc'=> $module );
            $this->session->set_userdata($acc_code_Data);
            // check if need decode
            $barcode_type1 = $this->general_scan_model->check_itemmaster_all($barcode);
            if($barcode_type1-> num_rows() > 0)
            {
                foreach($barcode_type1->result() as $row)
                {
                    $barcode_type = $row->barcodetype;
                    $getsellingprice = $row->sellingprice;
                    $getsoldbyweight = $row->soldbyweight;
                    $get_weight = '';
                }
            }
            else if ($barcode_type1-> num_rows() == 0 )
            {
                $barcode_type2 = $this->general_scan_model->check_itemmaster_18D($barcode);
                if($barcode_type2-> num_rows() > 0 )
                {
                    foreach($barcode_type2->result() as $row)
                    {
                        $barcode_type = $row->barcodetype;
                        $getsellingprice = $row->sellingprice;
                        $getsoldbyweight = $row->soldbyweight;
                    }
                }// end barcodetype2
                else
                {
                   $barcode_type = '';
                }

                $eighteenD = $this->general_scan_model->check_decode($module);
                if ($eighteenD->num_rows() != 0)
                {
                    if($barcode != '0')
                    {
                        foreach($eighteenD->result() as $row)
                        {
                            $weight_type_code               =  $row->weight_type_code;
                            $weight_capture_price           =  $row->weight_capture_price;
                            $weight_bar_pos_start           =  $row->weight_bar_pos_start;
                            $weight_bar_pos_count           =  $row->weight_bar_pos_count;
                            $weight_capture_factor          =  $row->weight_capture_factor;
                            $weight_capture_weight          =  $row->weight_capture_weight;
                            $weight_capture_pos_start       =  $row->weight_capture_pos_start;
                            $weight_capture_pos_count       =  $row->weight_capture_pos_count;
                            $weight_capture_weight_type     =  $row->weight_capture_weight_type;
                            $weight_capture_price_factor    =  $row->weight_capture_price_factor;
                            $weight_capture_price_pos_start =  $row->weight_capture_price_pos_start;
                            $weight_capture_price_pos_count =  $row->weight_capture_price_pos_count;
                        }
                    
                    if ($weight_capture_weight == 1)
                    {
                        if($weight_capture_weight_type == 'actual weight')
                        {
                            if($barcode_type == 'Q') // sold by qty
                            {
                                $get_weight = substr($barcode, $weight_capture_pos_start-1, $weight_capture_pos_count);
                            }
                            else // sold by weight
                            {
                                $get_weight = substr($barcode,$weight_capture_pos_start-1, $weight_capture_pos_count)/$weight_capture_factor;
                            }
                        }
                        else
                        {
                            $get_weight = (substr($barcode, $weight_capture_pos_start-1, $weight_capture_pos_count)/$weight_capture_factor) 
                            /* /$getsellingprice;*/ ;
                        } // end actual weight

                        $get_weight = round($get_weight,3);
                    }
                    // added by hugh 2018-03-21 mymydin bypass get_weight error
                    else
                    {
                        $get_weight = '';
                    }

                    if($weight_capture_price == 1)
                    {
                        $get_price = substr($barcode, $weight_capture_price_pos_start-1,
                            $weight_capture_price_pos_count)/
                            $weight_capture_price_factor;
                    }
                        $get_price = round($get_price,3);

                        $temp_weight_price = array(
                            'get_weight' =>$get_weight,
                            'get_price' => $get_price,
                            );
                        $this->session->set_userdata($temp_weight_price); 

                        // force to find itemcode and truncate the barcode to get the front part
                        if ( strlen($barcode) == '18')
                        {
                            /*$_barcode = substr($barcode,0,-11);*/
                            $_barcode = substr($barcode, $weight_bar_pos_start-1,$weight_bar_pos_count);
                            $barcode = $_barcode;
                            

                        }
                        else if ( strlen($barcode) == '13')
                        {
                            /*$_barcode = substr($barcode,0,-6);*/
                            $_barcode = substr($barcode, $weight_bar_pos_start-1,$weight_bar_pos_count);
                            $barcode = $_barcode;
                        }
                    }// end if checking barcode = 0
                    else
                    {
                         $web_guid = $_REQUEST['web_guid'];
                         $web_c_guid = $_REQUEST['web_c_guid'];
                         $_module = $this->general_scan_model->checkModule($web_guid);
                         $mod =  $_module->row('module_desc');
                         $acc_code_Data = array(
                            'module_desc'=> $mod,
                            'web_guid'=>$web_guid,
                            'web_c_guid'=>$web_c_guid);
                         $this->session->set_userdata($acc_code_Data);
                    }
                } // end 18D num_rows != 0
            } // end elseif num_rows() == 0
            else
            {
                echo 'Please check barcode type and barcode. Please close and reopen browser.';
            }

            // start sorting based on modules
            if ($module != 'PO')
            {
                if ($this->input->post('barcode') != "")
                {
                    $check = $this->general_scan_model->check_guid($barcode);
                    $web_c_guid = $check->row('web_c_guid');
                    $web_guid = $check->row('web_guid');
                    $check_im = $this->general_scan_model->check_itemcode($barcode);
                    $itemcode = $check_im->row('itemcode');

                    /* added by hugh to block itemblockbybranch 2018-04-16*/
                    $get_branch = $this->db->query("SELECT locgroup from backend.location where code = '".$_SESSION['sub_location']."'")->row('locgroup');
                   // echo $this->db->last_query();die;
                    $check_block_item = $this->db->query("SELECT itemcode, branch, sales_order, purchase_order, ibt, cn, dn from backend.itemmaster_block_by_branch where itemcode = '$itemcode' and branch = '$get_branch'");

                    if($check_block_item->num_rows() > 0)
                    {
                        if($module == 'IBT Req' && $check_block_item->row('ibt') == '1')
                        $this->session->set_flashdata('message', 'Item block from IBT process. Please check.');
                        redirect('general_scan_controller/scan_item?web_guid='.$_SESSION['web_guid']."&acc_code=".$_SESSION['acc_code']);

                        if($module == 'Sales Order' && $check_block_item->row('sales_order') == '1')
                        $this->session->set_flashdata('message', 'Item block from Sales Order process. Please check.');
                        redirect('general_scan_controller/scan_item?web_guid='.$_SESSION['web_guid']."&acc_code=".$_SESSION['acc_code']);
                    };

                    /* end */
                    

                    if($check->num_rows() == 0 && $check_im->num_rows()!= 0)
                    {
                        // echo 'im here 1';die;
                        $data['itemresult'] = $itemcode1 = $this->adjout_model->itemresult_new($barcode);
                        $itemcode =  $itemcode1->row('itemcode');
                        $data['itemQOH'] = $this->adjout_model->itemQOH($itemcode);
                        $data['itemQty']=$this->adjout_model->itemQty($itemcode);
                        $data['module']= $module;

                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/general/scan_itemresult', $data);
                        }
                        else
                        {
                            $this->load->view('header');
                            $this->load->view('general/scan_itemresult', $data);
                            $this->load->view('footer'); 
                        }    
                
                    }// end check num rows == 0      
                    elseif ($check->num_rows() != 0 && $check_im->num_rows()!= 0 && $get_weight == '')
                    {
                        //echo 'im here 2';echo $_SESSION['decode_qty'];die;
                        $user_ID_Data = array(
                         'web_c_guid' =>$check->row('web_c_guid'),
                         'barcode'=>$barcode,
                         'itemcode'=>$itemcode,
                         'acc_code'=>'',
                         'decode_qty' => $_SESSION['decode_qty'],
                        );
                    
                        $this->session->set_userdata($user_ID_Data);
                        $data['itemresult']= $itemcode2 = $this->adjout_model->itemresult_new($barcode);
                        $itemcode =  $itemcode2->row('itemcode');
                        $data['itemQOH']  = $this->adjout_model->itemQOH($itemcode);
                        $data['itemQty'] = $this->adjout_model->itemQty($itemcode);
                        $data['module']= $module;

                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/general/edit_item_result', $data);
                        }
                        else
                        {
                            $this->load->view('header');
                            $this->load->view('general/edit_item_result', $data);
                            $this->load->view('footer');
                        }

                    } // end else check numrows == 0
                    elseif ($check->num_rows() != 0 && $check_im->num_rows()!= 0 && $get_weight != '')
                    {
                        // echo 'im here 3';die;
                        $data['itemresult'] = $itemcode1 = $this->adjout_model->itemresult_new($barcode);
                        $itemcode =  $itemcode1->row('itemcode');
                        $data['itemQOH'] = $this->adjout_model->itemQOH($itemcode);
                        $data['itemQty']=$this->adjout_model->itemQty($itemcode);
                        $data['module']= $module;
                        $acc_code = array(
                            'acc_code'=> '');
                         $this->session->set_userdata($acc_code);
                                    
                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                                $this->load->view('WinCe/header');
                                $this->load->view('WinCe/general/scan_itemresult', $data);
                            }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('general/scan_itemresult', $data);
                                $this->load->view('footer');
                            }    

                    }
                    elseif($check->num_rows() == 0 && $check_im->num_rows() == 0)
                    {
                        $this->session->set_flashdata('message', 'Barcode not Found');
                        redirect('general_scan_controller/scan_item?web_guid='.$_SESSION['web_guid']."&acc_code=".$_SESSION['acc_code']);
                    }

                }; // end if barcode exist or not 

                // this is direct click description
                if ($this->input->post('barcode') == "" && $_REQUEST['web_c_guid'] != '' )
                {   
                    $_SESSION['web_c_guid']='';
                    $web_c_guid = $_REQUEST['web_c_guid'];
                    $check_c_guid = $this->adjout_model->edit_itemqty($web_c_guid);
                    $itemcode =  $check_c_guid->row('itemcode');
                    $barcode =  $check_c_guid->row('barcode');
                    $web_guid =  $check_c_guid->row('web_guid');
                    $acc_code_Data = array(
                        'web_guid'=>$web_guid,
                        'barcode'=>$barcode,
                        'web_c_guid'=>$web_c_guid,
                        'acc_code'=>'',);
                     $this->session->set_userdata($acc_code_Data);
                    if($check_c_guid -> num_rows() != 0)
                    {     
                        $data['itemresult'] = $this->adjout_model->itemresult_new($barcode,$web_c_guid);
                        $data['itemQOH'] = $this->adjout_model->itemQOH($itemcode);
                        $data['itemQty'] = $this->adjout_model->edit_itemqty($web_c_guid);
                        $data['module']= $module;
                        $this->general_scan_model->reloadbillamt($web_guid);
                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {

                                $this->load->view('WinCe/header');
                                $this->load->view('WinCe/general/edit_item_result', $data);
                            }
                        else
                            {

                                $this->load->view('header');
                                $this->load->view('general/edit_item_result', $data);
                                $this->load->view('footer');
                            }

                    }//  end check_c_guid num row

                }; // end elseif edit_itemqty using web_c_guid
            } ;  // end $module == 'Adjust-Out' || 'Adjust-In' || 'Sales Order' || 'IBT req'

            if ($module == 'PO' )
            {
                if ($this->input->post('barcode') != "")
                {      
                    $check = $this->general_scan_model->check_guid($barcode);
                    $web_c_guid = $check->row('web_c_guid');
                    $web_guid = $check->row('web_guid');
                    $acc_code = $check->row('acc_code');
                    $check_im = $this->general_scan_model->check_itemcode($barcode);
                    $itemcode = $check_im->row('itemcode');

                    if ($acc_code == '')
                    {
                        $check_acc = $this->general_scan_model->check_acc();
                        $acc_code = $check_acc->row('acc_code');
                        
                        $checkpoprice_method = $this->db->query("SELECT poprice_method from backend.supcus where code = '$acc_code'")->row('poprice_method');
                        if($checkpoprice_method != 'ILAST')
                        {
                            $check_sup= $this->general_scan_model->check_supplier($itemcode,$acc_code);
                            $check_itemmastersupcode = 'true';
                        }
                        else
                        {
                            $check_sup = $this->db->query("SELECT * from backend.itemmaster where itemcode = '$itemcode'");
                            $check_itemmastersupcode = 'false';
                        }
                    }
                    else
                    {
                        $checkpoprice_method = $this->db->query("SELECT poprice_method from backend.supcus where code = '$acc_code'")->row('poprice_method');
                        if($checkpoprice_method != 'ILAST')
                        {
                        $check_sup= $this->general_scan_model->check_supplier($itemcode,$acc_code);  
                            $check_itemmastersupcode = 'true';
                        }
                        else
                        {
                            $check_sup = $this->db->query("SELECT * from backend.itemmaster where itemcode = '$itemcode'");
                            $check_itemmastersupcode = 'false';
                        }  
                    }

                    /* added by hugh to block itemblockbybranch 2018-04-16*/
                    $get_branch = $this->db->query("SELECT locgroup from backend.location where code = '".$_SESSION['sub_location']."'")->row('locgroup');
                    $check_block_item = $this->db->query("SELECT itemcode, branch, sales_order, purchase_order, ibt, cn, dn from backend.itemmaster_block_by_branch where itemcode = '$itemcode' and branch = '$get_branch'");
                    $check_supcus_block_item = $this->db->query("SELECT itemcode, branch from backend.itemmastersupcode_block_by_branch where itemcode = '$itemcode' and branch = '$get_branch' and code = '$acc_code'");
                    
                    if($check_block_item->num_rows() > 0 || $check_supcus_block_item->num_rows() > 0)
                    {
                        if($module == 'PO' && $check_block_item->row('purchase_order') == '1')
                        $this->session->set_flashdata('message', 'Item block from PO process. Please check.');
                        redirect('general_scan_controller/scan_item?web_guid='.$_SESSION['web_guid']."&acc_code=".$_SESSION['acc_code']);

                        if($module == 'PO' && $check_supcus_block_item->num_rows() > '0')
                        $this->session->set_flashdata('message', 'Item block from PO process. Please check.');
                        redirect('general_scan_controller/scan_item?web_guid='.$_SESSION['web_guid']."&acc_code=".$_SESSION['acc_code']);
                    };
                    /* end */    

                    if($check->num_rows() == 0 && $check_im->num_rows()!= 0 && $check_sup-> num_rows() != 0)
                    {
                        // echo 'PO condition 1' new record;     
                        $data['itemresult'] = $itemcode1 = $this->PO_model->itemresult_po($barcode,$check_itemmastersupcode);
                        //echo $this->db->last_query();die;
                        $itemcode =  $itemcode1->row('itemcode');
                        $data['itemQOH'] = $this->PO_model->itemQOH($itemcode);
                        $data['itemQty']=$this->PO_model->itemQty($barcode, $web_guid);
                        $data['module']= $module;

                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                         {
                             $this->load->view('WinCe/header');
                             $this->load->view('WinCe/po/scan_itemresult', $data);
                         }
                        else
                         {
                             $this->load->view('header');
                             $this->load->view('po/scan_itemresult', $data);
                             $this->load->view('footer');
                         }

                    }// end check num rows == 0 

                    elseif($check->num_rows() != 0 && $check_im->num_rows()!= 0 && $check_sup->num_rows() != 0 && $get_weight == '')
                    {
                     // force web_c_guid to become session from $check
                        $user_ID_Data = array(
                        'web_c_guid' =>$check->row('web_c_guid'),
                        'web_guid' =>$check->row('web_guid'), 
                        'acc_code' =>$check->row('acc_code')
                        );
                        $this->session->set_userdata($user_ID_Data);
                               // echo 'PO condition 2';
                        $data['itemresult']= $itemcode2 = $this->PO_model->itemresult_po($barcode, $check_itemmastersupcode);

                        $itemcode =  $itemcode2->row('itemcode');
                        $sellingprice1 = $this->PO_model->itemQty($barcode, $web_guid);
                        $data['sellingprice'] = $sellingprice1->row("sellingprice");
                        $data['itemQOH']  = $this->PO_model->itemQOH($itemcode);
                        $data['itemQty'] = $this->PO_model->itemQty($barcode, $web_guid);
                        $data['module']= $module;

                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                        {
                          $this->load->view('WinCe/header');
                          $this->load->view('WinCe/po/edit_itemresult', $data, $web_c_guid);    
                        }
                        else
                        {
                            $this->load->view('header');
                            $this->load->view('po/edit_itemresult', $data, $web_c_guid);
                            $this->load->view('footer');
                        }
                    }
                                 // end else check numrows == 0

                    elseif ($check->num_rows() != 0 && $check_im->num_rows()!= 0 && $check_sup-> num_rows() != 0 && $get_weight != '')
                    {
                        $data['itemresult'] = $itemcode1 = $this->PO_model->itemresult_po($barcode, $check_itemmastersupcode);
                            
                        $itemcode =  $itemcode1->row('itemcode');
                        $data['itemQOH'] = $this->PO_model->itemQOH($itemcode);
                        $data['itemQty']= $this->PO_model->itemQty($barcode, $web_guid);
                        $data['module']= $module;
                        $user_ID_Data = array(
                            'acc_code' =>$check->row('acc_code')
                           );
                            $this->session->set_userdata($user_ID_Data);
                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                                $this->load->view('WinCe/header');
                                $this->load->view('WinCe/po/scan_itemresult', $data);
                            }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('po/scan_itemresult', $data);
                                $this->load->view('footer');
                            }    
                    }
                        /*elseif($check->num_rows() == 0 && $check_im->num_rows() == 0 && $check_sup-> num_rows() == 0)*/
                    else 
                    {
                        $error['barcode_error'] = $barcode;

                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                                $this->load->view('WinCe/header');
                                $this->load->view('WinCe/po/norecord', $error);
                            }
                        else
                            {
                                  
                                $this->load->view('header');
                                $this->load->view('po/norecord', $error);
                                $this->load->view('footer');
                            }   
                    }
                        
                } // end if barcode exist or not
                elseif ($this->PO_model->edit_itemqty($web_c_guid) != '')
                {
                    $check_c_guid = $this->PO_model->edit_itemqty($web_c_guid);
                    foreach ($check_c_guid->result() as $row)
                    {
                        $barcode =  $row->barcode;
                        $web_c_guid = $row->web_c_guid;
                        $itemcode = $row->itemcode;
                    }

                    if($check_c_guid -> num_rows() != 0)
                    {     
                        $data['itemresult'] = $this->PO_model->itemresult($barcode,$web_c_guid);
                        $data['itemQOH'] = $this->PO_model->itemQOH($itemcode);
                        $data['itemQty'] = $this->PO_model->edit_itemqty($web_c_guid);
                        $data['module']= $module;
     
                        $this->general_scan_model->reloadbillamt($web_guid);

                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                                $this->load->view('WinCe/header');
                                $this->load->view('WinCe/po/edit_itemresult', $data);
                            }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('po/edit_itemresult', $data);
                                $this->load->view('footer');
                            }   
                    } // end check_c_guid num row
                    else
                    {
                       /* echo "Web Guid for item Not Found. Please close and reopen browser.";*/
                    }

                } // end elseif edit_itemqty using web_c_guid

            }  // end PO mode
            else
            {
                /*echo "If blank page... check here.. 
                Module Session Timeout, return module == null. Please close and reopen browser.";*/
            };
        } // end if login = true for scan item result
        else
        {
            redirect('main_controller');
        }
    }   // end function scan_itemresult()

        public function add_qty()
        {
            if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
            {

            $web_c_guid = $this->input->post('web_c_guid');
            $web_guid = $this->input->post('web_guid');
            $itemcode = $this->input->post('itemcode');
            $barcode = $this->input->post('barcode');
            $itemlink = $this->input->post('itemlink');
            $packsize = $this->input->post('packsize');
            $description = $this->input->post('description');
            /*$sellingprice = $this->input->post('sellingprice');*/
            $foc_qty = $this->input->post('foc_qty');
            $barcode = $this->input->post('barcode');
            $SinglePackQOH = $this->input->post('SinglePackQOH');
            $iqty = $this->input->post('iqty');
            $defaultqty = $this->input->post('defaultqty');
            $soldbyweight = $this->input->post('soldbyweight');
            $qty = $this->input->post('qty');
            $remark = addslashes($this->input->post('remark'));

            $use_cost = $this->db->query("SELECT averagecost from itemmaster where itemcode = '$itemcode' ")->row('averagecost');

            if($_SESSION['module_desc'] == 'PO' ) 
            {
                $check_acc_code = $this->db->query("SELECT acc_code FROM web_trans WHERE web_guid = '$web_guid'")->row('acc_code');

                $check_popricemethod = $this->db->query("SELECT poprice_method from supcus where code = '$check_acc_code'")->row('poprice_method');
                // correct

                if($check_popricemethod == 'VLISTED')
                {
                    $check_quey = $this->db->query("SELECT supstdprice from itemmastersupcode where code = '$check_acc_code' and itemcode = '$itemcode'");
                    if($check_quey->num_rows() > 0)
                    {
                        $use_cost = $check_quey->row('supstdprice');    
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Itemcode not Found in supplier');
                        redirect('general_scan_controller/scan_item?web_guid='.$_SESSION['web_guid']."&acc_code=".$_SESSION['acc_code']);
                    }
                    
                }
                elseif($check_popricemethod == 'VLAST')
                {
                    $check_quey = $this->db->query("SELECT suplastprice  from itemmastersupcode where code = '$check_acc_code' and itemcode = '$itemcode'");
                    if($check_quey->num_rows() > 0)
                    {
                        $use_cost = $check_quey->row('suplastprice');    
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Itemcode not Found in supplier');
                        redirect('general_scan_controller/scan_item?web_guid='.$_SESSION['web_guid']."&acc_code=".$_SESSION['acc_code']);
                    }

                }
                elseif($check_popricemethod == 'ILAST')
                {
                    $use_cost = $this->db->query("SELECT lastcost   from itemmaster where itemcode = '$itemcode'")->row('lastcost');
                }
                elseif($check_popricemethod == 'ILISTED')
                {
                    $use_cost = $this->db->query("SELECT stdcost  from itemmaster where itemcode = '$itemcode'")->row('stdcost');
                }
                else
                {
                    $use_cost = $this->db->query("SELECT averagecost from itemmaster where itemcode = '$itemcode' ")->row('averagecost');
                }
                
                $_amount = ($defaultqty+$qty+$iqty)*$use_cost;
                $sellingprice = $use_cost;
                
            }
            elseif($_SESSION['module_desc'] == 'IBT Req' || $_SESSION['module_desc'] == 'Adjust-In' || $_SESSION['module_desc'] == 'Adjust-Out' )
            {   
            	$_amount = ($defaultqty+$qty+$iqty)*$use_cost;
                $sellingprice = $use_cost;
               
            }
            else
            {
                $sellingprice = $this->input->post('sellingprice');
            	$_amount = ($defaultqty+$qty+$iqty)*$sellingprice;
                

        	}

            $totalqty  = $foc_qty+$iqty+$defaultqty;

            $result = $this->PO_model->add_qty($web_c_guid,$web_guid,$itemcode,$description,$sellingprice,$foc_qty,$barcode,$SinglePackQOH,$remark,$totalqty,$_amount,$soldbyweight);

            $get_item_guid = $this->db->query("SELECT * FROM backend_warehouse.`d_batch_scan_log` a WHERE a.`type` = '".$_SESSION['module_desc']."' AND a.scan_itemcode = '$itemcode' ");
            //echo $this->db->last_query();die;
            if($get_item_guid->num_rows() == 0)
            {
                $item_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid');
            }
            else
            {
                $item_guid = $get_item_guid->row('item_guid');
            }
            $data = array(

                'item_guid' => $item_guid ,
                'scan_guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid') ,
                'lineno' => $this->db->query("SELECT COUNT(*)+1 AS reccount FROM backend_warehouse.d_batch_scan_log WHERE item_guid = '$item_guid' ")->row('reccount'),
                'type' => $_SESSION['module_desc'],
                'refno' => $web_guid,
                'scan_barcode' => $barcode,
                'scan_itemcode' => $itemcode,
                'scan_description' => addslashes($description),
                'scan_itemlink' => $itemlink,
                'scan_packsize' => $packsize,
                'scan_as_itemcode' => '0',
                'scan_qty' => $iqty,

                'scan_weight' => '',
                'created_at' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at'=> $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                'updated_by' => $_SESSION['username'],
            );

            if($_SESSION['decode_qty'] <> 0)
            {

                $this->db->insert('backend_warehouse.d_batch_scan_log', $data);
            };

                if ($_SESSION['module_desc'] == 'PO')
                {
                    $back = site_url('PO_controller/item_in_po?web_guid='.$_SESSION['web_guid'].'&acc_code='.$_SESSION['acc_code']);
                }
                elseif ($_SESSION['module_desc'] == 'Sales Order')
                {
                    $back = site_url('SO_controller/item_in_so?web_guid='.$_SESSION['web_guid']);
                }
                elseif ($_SESSION['module_desc'] == 'IBT Req')
                {
                    $back = site_url('IBT_controller/item_in_IBT?web_guid='.$_SESSION['web_guid']);
                }
                elseif ($_SESSION['module_desc'] == 'Adjust-In')
                {
                    $back = site_url('adjin_controller/itemlist?web_guid='.$_SESSION['web_guid']);
                }
                elseif ($_SESSION['module_desc'] == 'Adjust-Out')
                {
                    $back = site_url('adjout_controller/itemlist?web_guid='.$_SESSION['web_guid']);
                }
                elseif ($_SESSION['module_desc'] == 'POS')
                {
                    $back = site_url('Mpos_controller/itemlist?web_guid='.$_SESSION['web_guid']);
                }
                elseif ($_SESSION['module_desc'] == 'Simple SO')
                {
                    $back = site_url('simpleso_controller/itemlist?web_guid='.$_SESSION['web_guid']);
                }
                else
                {
                    $back = site_url('main_controller/home');
                }

                $data = array (
                    'web_guid' => $this->general_scan_model->reloadmodel($web_guid),
                    'module_desc' => $this->general_scan_model->checkModule($web_guid),
                    'back' => $back,
                    );

                    $this->general_scan_model->reloadbillamt($web_guid);
                    $_SESSION['get_weight'] = '';
                    $_SESSION['get_price'] = '';

                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                             $this->load->view('WinCe/header');
                             $this->load->view('WinCe/general/scan_item',$data);
                        }
                    else
                        {
                             $this->load->view('header');
                             $this->load->view('general/scan_item',$data);
                             $this->load->view('footer');
                        }    
                   
            }
            else
            {
                redirect('main_controller');
            }
    } // end public function add_qty()


    public function update_qty()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {

            if(isset($_REQUEST['delete_batch_scan']))
            {
                $iqty = $_REQUEST['delete_batch_scan'];
            }
            else
            {
                $iqty = $this->input->post('iqty');
            }

        $web_c_guid = $this->input->post('web_c_guid');
        $itemcode = $this->input->post('itemcode');
        $barcode = $this->input->post('barcode');
        $itemlink = $this->input->post('itemlink');
        $packsize = $this->input->post('packsize');
        $description = $this->input->post('description');
        /*$sellingprice = $this->input->post('sellingprice');*/
        $foc_qty = $this->input->post('foc_qty');
        $barcode = $this->input->post('barcode');
        $SinglePackQOH = $this->input->post('SinglePackQOH');
        $defaultqty = $this->input->post('defaultqty');
        $web_guid = $this->input->post('web_guid');
        $acc_code = $this->input->post('acc_code');
        $qty = $this->input->post('qty');
        $remark = addslashes($this->input->post('remark'));
        $iqty = $iqty;

        $use_cost = $this->db->query("SELECT averagecost from itemmaster where itemcode = '$itemcode' ")->row('averagecost');
            
            if($_SESSION['module_desc'] == 'PO' ) 
            {
                $check_acc_code = $this->db->query("SELECT acc_code FROM web_trans WHERE web_guid = '$web_guid'")->row('acc_code');

                $check_popricemethod = $this->db->query("SELECT poprice_method from supcus where code = '$check_acc_code'")->row('poprice_method');

                if($check_popricemethod == 'VLISTED')
                {
                    $check_quey = $this->db->query("SELECT supstdprice from itemmastersupcode where code = '$check_acc_code' and itemcode = '$itemcode'");
                    if($check_quey->num_rows() > 0)
                    {
                        $use_cost = $check_quey->row('supstdprice');    
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Itemcode not Found in supplier');
                        redirect('general_scan_controller/scan_item?web_guid='.$_SESSION['web_guid']."&acc_code=".$_SESSION['acc_code']);
                    }
                    
                }
                elseif($check_popricemethod == 'VLAST')
                {
                    $check_quey = $this->db->query("SELECT suplastprice  from itemmastersupcode where code = '$check_acc_code' and itemcode = '$itemcode'");
                    if($check_quey->num_rows() > 0)
                    {
                        $use_cost = $check_quey->row('suplastprice');    
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Itemcode not Found in supplier');
                        redirect('general_scan_controller/scan_item?web_guid='.$_SESSION['web_guid']."&acc_code=".$_SESSION['acc_code']);
                    }

                }
                elseif($check_popricemethod == 'ILAST')
                {
                    $use_cost = $this->db->query("SELECT lastcost   from itemmaster where itemcode = '$itemcode'")->row('lastcost');
                }
                elseif($check_popricemethod == 'ILISTED')
                {
                    $use_cost = $this->db->query("SELECT stdcost  from itemmaster where itemcode = '$itemcode'")->row('stdcost');
                }
                else
                {
                    $use_cost = $this->db->query("SELECT averagecost from itemmaster where itemcode = '$itemcode' ")->row('averagecost');
                }

                $_amount = ($defaultqty+$qty+$iqty)*$use_cost;
                $sellingprice = $use_cost;
            }
            elseif($_SESSION['module_desc'] == 'IBT Req' || $_SESSION['module_desc'] == 'Adjust-In' || $_SESSION['module_desc'] == 'Adjust-Out' )
            {
            	$_amount = ($defaultqty+$qty+$iqty)*$use_cost;
                $sellingprice = $use_cost;
            }
            else// sales order
            {
                $sellingprice = $this->input->post('sellingprice');
            	$_amount = ($defaultqty+$qty+$iqty)*$sellingprice;
                
        	}
        	
        /*$_amount = ($defaultqty+$qty+$iqty)*$sellingprice;*/
        $totalqty  = $foc_qty+$iqty+$defaultqty;
        

            $result = $this->PO_model->update_qty($web_c_guid,$itemcode,$description,$sellingprice,$foc_qty,$barcode,$SinglePackQOH,$remark,$totalqty,$_amount);
            //echo $this->db->last_query();die;

            $get_item_guid = $this->db->query("SELECT * FROM backend_warehouse.`d_batch_scan_log` a WHERE a.`type` = '".$_SESSION['module_desc']."' AND a.scan_itemcode = '$itemcode' ");
            //echo $this->db->last_query();die;
            if($get_item_guid->num_rows() == 0)
            {
                $item_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid');
            }
            else
            {
                $item_guid = $get_item_guid->row('item_guid');
            }
            $data = array(

                'item_guid' => $item_guid ,
                'scan_guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid') ,
                'lineno' => $this->db->query("SELECT COUNT(*)+1 AS reccount FROM backend_warehouse.d_batch_scan_log WHERE item_guid = '$item_guid' ")->row('reccount'),
                'type' => $_SESSION['module_desc'],
                'refno' => $web_guid,
                'scan_barcode' => $barcode,
                'scan_itemcode' => $itemcode,
                'scan_description' => addslashes($description),
                'scan_itemlink' => $itemlink,
                'scan_packsize' => $packsize,
                'scan_as_itemcode' => '0',
                'scan_qty' => $iqty,

                'scan_weight' => '',
                'created_at' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at'=> $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                'updated_by' => $_SESSION['username'],
            );

            if($_SESSION['decode_qty'] <> 0 && !isset($_REQUEST['delete_batch_scan']))
            {

                $this->db->insert('backend_warehouse.d_batch_scan_log', $data);
            };

                if ($_SESSION['module_desc'] == 'PO')
                {
                    $back = site_url('PO_controller/item_in_po?web_guid='.$_SESSION['web_guid'].'&acc_code='.$acc_code);
                }
                elseif ($_SESSION['module_desc'] == 'Sales Order')
                {
                    $back = site_url('SO_controller/item_in_so?web_guid='.$_SESSION['web_guid']);
                }
                elseif ($_SESSION['module_desc'] == 'IBT Req')
                {
                    $back = site_url('IBT_controller/item_in_IBT?web_guid='.$_SESSION['web_guid']);
                }
                elseif ($_SESSION['module_desc'] == 'Adjust-In')
                {
                    $back = site_url('adjin_controller/itemlist?web_guid='.$_SESSION['web_guid']);
                }
                elseif ($_SESSION['module_desc'] == 'Adjust-Out')
                {
                    $back = site_url('adjout_controller/itemlist?web_guid='.$_SESSION['web_guid']);
                }
                 elseif ($_SESSION['module_desc'] == 'POS')
                {
                    $back = site_url('Mpos_controller/itemlist?web_guid='.$_SESSION['web_guid']);
                }
                elseif ($_SESSION['module_desc'] == 'Simple SO')
                {
                    $back = site_url('simpleso_controller/itemlist?web_guid='.$_SESSION['web_guid']);
                }
                else
                {
                    $back = site_url('main_controller/home');
                }

                if(isset($_REQUEST['delete_batch_scan']))
                {
                    // redirect($_REQUEST['redirect']);
                    //echo $_REQUEST['redirect'];die;
                    header('Location:'.$_REQUEST['redirect']);
                }
                else
                {
                    $data = array (
                        'web_guid' => $this->general_scan_model->reloadmodel($web_guid),
                        'module_desc' => $this->general_scan_model->checkModule($web_guid),
                        'back' => $back,
                        );   
                    $this->general_scan_model->reloadbillamt($web_guid);
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                             $this->load->view('WinCe/header');
                             $this->load->view('WinCe/general/scan_item',$data);           
                        }
                    else
                        {
                             $this->load->view('header');
                             $this->load->view('general/scan_item',$data);
                             $this->load->view('footer');
                        }    
                }

        }
        else
        {
             redirect('main_controller');
        }
    } // end public function edit qty()


    public function decoode_barcode()
    {
        $encode_barcode = '289087610598300678';
        $barcode = '289087610598300678';
        $module = 'POS';
            // check if need decode
            $barcode_type1 = $this->general_scan_model->check_itemmaster_all($barcode);
            if($barcode_type1-> num_rows() > 0)
            {
                foreach($barcode_type1->result() as $row)
                {
                    $barcode_type = $row->barcodetype;
                    $getsellingprice = $row->sellingprice;
                    $getsoldbyweight = $row->soldbyweight;
                    $get_weight = '';
                }

                // $barcode_type = $barcode_type1->row('barcodetype');
                // $getsellingprice = $barcode_type1->row('sellingprice');
                // $getsoldbyweight = $barcode_type1->row('soldbyweight');
                // $get_weight = '';

            }
            else if ($barcode_type1-> num_rows() == 0 )
            {
                $barcode_type2 = $this->general_scan_model->check_itemmaster_18D($barcode);
                if($barcode_type2-> num_rows() > 0 )
                {
                    // foreach($barcode_type2->result() as $row)
                    // {
                    //     $barcode_type = $row->barcodetype;
                    //     $getsellingprice = $row->sellingprice;
                    //     $getsoldbyweight = $row->soldbyweight;
                    // }

                    $barcode_type = $barcode_type2->row('barcodetype');
                    $getsellingprice = $barcode_type2->row('sellingprice');
                    $getsoldbyweight = $barcode_type2->row('soldbyweight');

                    //echo $getsellingprice;die;

                }// end barcodetype2
                else
                {
                    $barcode_type = '';
                }

                $eighteenD = $this->general_scan_model->check_decode($module);
                if ($eighteenD->num_rows() != 0)
                {
                    
                    // foreach($eighteenD->result() as $row)
                    // {
                    //     $weight_type_code               =  $row->weight_type_code;
                    //     $weight_capture_price           =  $row->weight_capture_price;
                    //     $weight_bar_pos_start           =  $row->weight_bar_pos_start;
                    //     $weight_bar_pos_count           =  $row->weight_bar_pos_count;
                    //     $weight_capture_factor          =  $row->weight_capture_factor;
                    //     $weight_capture_weight          =  $row->weight_capture_weight;
                    //     $weight_capture_pos_start       =  $row->weight_capture_pos_start;
                    //     $weight_capture_pos_count       =  $row->weight_capture_pos_count;
                    //     $weight_capture_weight_type     =  $row->weight_capture_weight_type;
                    //     $weight_capture_price_factor    =  $row->weight_capture_price_factor;
                    //     $weight_capture_price_pos_start =  $row->weight_capture_price_pos_start;
                    //     $weight_capture_price_pos_count =  $row->weight_capture_price_pos_count;
                    // }

                    $weight_type_code               =  $eighteenD->row('weight_type_code');
                    $weight_capture_price           =  $eighteenD->row('weight_capture_price');
                    $weight_bar_pos_start           =  $eighteenD->row('weight_bar_pos_start');
                    $weight_bar_pos_count           =  $eighteenD->row('weight_bar_pos_count');
                    $weight_capture_factor          =  $eighteenD->row('weight_capture_factor');
                    $weight_capture_weight          =  $eighteenD->row('weight_capture_weight');
                    $weight_capture_pos_start       =  $eighteenD->row('weight_capture_pos_start');
                    $weight_capture_pos_count       =  $eighteenD->row('weight_capture_pos_count');
                    $weight_capture_weight_type     =  $eighteenD->row('weight_capture_weight_type');
                    $weight_capture_price_factor    =  $eighteenD->row('weight_capture_price_factor');
                    $weight_capture_price_pos_start =  $eighteenD->row('weight_capture_price_pos_start');
                    $weight_capture_price_pos_count =  $eighteenD->row('weight_capture_price_pos_count');

                    // echo $barcode_type;die;

                    if ($weight_capture_weight == 1)
                    {
                        if($weight_capture_weight_type == 'actual weight')
                        {
                            if($barcode_type == 'Q') // sold by qty
                            {
                                $get_weight = substr($barcode, $weight_capture_pos_start-1, $weight_capture_pos_count);

                            }
                            else // sold by weight
                            {
                                $get_weight = (float)substr($barcode,(int)$weight_capture_pos_start-1, (int)$weight_capture_pos_count)/(float)$weight_capture_factor;
                                // echo (float)$weight_capture_factor;
                                // echo substr('289087610598000678', 12);echo '<br>';
                                // echo substr('289087610598000678', 12,5)/(float)$weight_capture_factor;die;
                                
                            }
                        }
                        else
                        {
                            $get_weight = (substr($barcode, $weight_capture_pos_start-1, $weight_capture_pos_count)/$weight_capture_factor)/* /$getsellingprice;*/ ;
                        } // end actual weight

                        $get_weight = round($get_weight,3);
                    };

                    // echo $weight_capture_price;die;

                    if($weight_capture_price == 1)
                    {
                        $get_price = substr($barcode, $weight_capture_price_pos_start-1,$weight_capture_price_pos_count)/$weight_capture_price_factor;
                    };

                    $get_price = round($get_price,3);

                    $temp_weight_price = array(
                                'get_weight' =>$get_weight,
                                'get_price' => $get_price,
                                );
                    $this->session->set_userdata($temp_weight_price); 

                    // force to find itemcode and truncate the barcode to get the front part
                    if ( strlen($barcode) == '18')
                    {
                           /*$_barcode = substr($barcode,0,-11);*/
                       $_barcode = substr($barcode, $weight_bar_pos_start-1,$weight_bar_pos_count);
                       $barcode = $_barcode;
                    }
                    else if ( strlen($barcode) == '13')
                    {
                           /*$_barcode = substr($barcode,0,-6);*/
                        $_barcode = substr($barcode, $weight_bar_pos_start-1,$weight_bar_pos_count);
                        $barcode = $_barcode;
                    }

                    echo 'scan_barcode: '.$encode_barcode;echo '<br>';
                    echo 'weight: '.$_SESSION['get_weight'];echo '<br>';
                    echo 'price: '.$_SESSION['get_price'];echo '<br>';
                    echo 'decode_barcode: '.$barcode;
                    return $barcode;
                }
                else
                {
                    $barcode = $encode_barcode;
                    echo 'scan_barcode'.$encode_barcode;
                    echo 'weight'.$_SESSION['get_weight'];echo '<br>';
                    echo 'price'.$_SESSION['get_price'];echo '<br>';
                    echo 'decode_barcode'.$barcode;
                    return $barcode;
                } 
                
            } 
            else
            {
                echo 'Please check barcode type and barcode. Please close and reopen browser.';
            }
        
    }

    public function general_post()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            //$trans_guid = isset($_REQUEST['trans_guid']);

            $header_guid = $_REQUEST['header_guid'];

            $trans_guid = $this->db->query("SELECT upper(replace(uuid(),'-','')) as guid")->row('guid');

            $redirect_controller = $_REQUEST['redirect_controller'];
            $redirect_function = $_REQUEST['redirect_function'];

            if(isset($_REQUEST['type']))
            {
                $type = $_REQUEST['type'];
            }
            else
            {
                $type = '';
            };

            if(isset($_REQUEST['refno']))
            {
                $refno = $_REQUEST['refno'];
            }
            else
            {
                $refno = '';
            };

            if(isset($_REQUEST['location']))
            {
                $location = $_REQUEST['location'];
            }
            else
            {
                $location = '';
            };

            if(isset($_REQUEST['do_no']))
            {
                $do_no = $_REQUEST['do_no'];
            }
            else
            {
                $do_no = '';
            };

            if(isset($_REQUEST['inv_no']))
            {
                $inv_no = $_REQUEST['inv_no'];
            }
            else
            {
                $inv_no = '';
            };

            if(isset($_REQUEST['po_date']))
            {
                $po_date = $_REQUEST['po_date'];
            }
            else
            {
                $po_date = '';
            };

            if(isset($_REQUEST['po_no']))
            {
                $po_no = $_REQUEST['po_no'];
            }
            else
            {
                $po_no = '';
            };

            if(isset($_REQUEST['scode']))
            {
                $scode = $_REQUEST['scode'];
            }
            else
            {
                $scode = '';
            };

            if(isset($_REQUEST['s_name']))
            {
                $s_name = $_REQUEST['s_name'];
            }
            else
            {
                $s_name = '';
            };


            if(isset($_REQUEST['reason']))
            {
                $reason = $_REQUEST['reason'];
            }
            else
            {
                $reason = '';
            };

            $checkdate = $this->db->query("SELECT YEAR(NOW()) AS getYear,MONTH(NOW()) AS getMonth");
            $checkPLATFORM = $this->db->query("SELECT * from sysrun where type='PLATFORM'");

            if($checkPLATFORM->num_rows() == 0)
            {
                 $this->general_scan_model->insertsysrun();
            };

            if($refno == '')
            {
                $getcode = $this->db->query("SELECT code from sysrun where type='PLATFORM'")->row('code');
                // create refno here
                $year = $this->db->query("SELECT right(year(now()),2) as year")->row('year');
                $month = $this->db->query("SELECT lpad(month(now()),2,0) as month")->row('month');
                $run_no = $this->db->query("SELECT  IFNULL(MAX(LPAD(RIGHT(refno,4)+1,4,0)),LPAD(1,4,0)) AS runno  FROM panda_platform.trans WHERE location = '".$_SESSION['location']."' AND SUBSTRING(refno,-8,4) = CONCAT(RIGHT(YEAR(NOW()),2),LPAD(MONTH(NOW()),2,0))")->row('runno');
                $refno = $this->db->query("SELECT concat('".$_SESSION['location']."', '$getcode', '$year', '$month', '$run_no' ) as refno")->row('refno');
                // end create refno
            };
            
            // do the checking of module below here
            if($type == 'GRN')// START GR CONTROLLER
            {
                $checkheader = $this->db->query("SELECT * from backend_warehouse.d_grn_batch where grn_guid = '$header_guid'");
                foreach($checkheader->result() as $i => $id)
                {
                    $this->db->query("REPLACE INTO panda_platform.trans SELECT '$trans_guid' as trans_guid
                        ,'$type' as type
                        , '".$id->batch_guid."' as web_guid
                        , '".$id->batch_barcode."' as refno
                        , '$location' as location
                        , '$header_guid' as do_no
                        , '$inv_no' as inv_no
                        , '$po_date' as po_date
                        , '$po_no' as po_no
                        , '$scode' as scode
                        , '$s_name' as s_name
                        , '$reason' as reason
                        , '' as datetime
                        , now() as created_at
                        , '".$_SESSION['username']."' as created_by
                        , '' as sync_in
                        , '' as sync_in_datetime        
                        , '' as sync_out       
                        , '' as sync_out_datetime  
                        , '0' as printed
                        , '' as printed_datetime
                        , '' as  status
                        ");
                }

                $trans_guid = $this->db->query("SELECT * from panda_platform.trans where do_no = '$header_guid'")->row('trans_guid');

                $checkchild = $this->db->query("SELECT * FROM backend_warehouse.d_grn_batch_item WHERE batch_guid ='".$checkheader->row('batch_guid')."'");

                foreach($checkchild->result() as $i => $id )
                {
                    $this->db->query("REPLACE INTO panda_platform.trans_c 
                        SELECT 
                        upper(replace(uuid(),'-','')) as  trans_guid_c 
                        , '$trans_guid' as trans_guid     
                        , '$type' as type
                        , '".$id->batch_guid."' as web_guid
                        , '".$id->item_guid."' as web_c_guid
                        , '".$checkheader->row('batch_barcode')."' as refno          
                        , '".$id->po_itemcode."' as itemcode       
                        , '".addslashes($id->po_description)."' as description    
                        , '".$id->scan_barcode."' as barcode        
                        , '".$id->qty_rec."' as qty            
                        , '".$id->reason."' as reason         
                        , '' as  datetime  
                        , now() as created_at
                        , '".$_SESSION['username']."' as created_by 
                        , '' as sync_in
                        , '' as sync_in_datetime        
                        , '' as sync_out       
                        , '' as sync_out_datetime   
                        ");
                }

                //checking if fully d_grn_batch_item_c sync, flag sync
                $check_ori_count = $this->db->query("SELECT count(item_guid) as ori_count FROM backend_warehouse.d_grn_batch_item WHERE batch_guid='".$checkheader->row('batch_guid')."'")->row('ori_count');

                $check_platform_count = $this->db->query("SELECT count(itemcode) as sync_count FROM panda_platform.trans_c WHERE trans_guid =  '$trans_guid'")->row('sync_count');

                if($check_ori_count == $check_platform_count)
                {
                    $this->db->query("UPDATE panda_platform.trans_c set sync_in = '1', sync_in_datetime = now() where trans_guid = '$trans_guid'");
                    $this->db->query("UPDATE panda_platform.trans set sync_in = '1' , sync_in_datetime = now() where trans_guid = '$trans_guid'");
                }
                else
                {
                    $this->db->query("DELETE from panda_platform.trans where trans_guid = '$trans_guid'");
                    $this->db->query("DELETE from panda_platform.trans_c where trans_guid = '$trans_guid'");

                    redirect('general_scan_controller/general_post?type='.$type.'&header_guid='.$head_guid.'&location='.$location.'&redirect_controller='.$redirect_controller.'&redirect_function='.$redirect_function);
                }

                $this->session->set_flashdata('message', 'Posted');
                    redirect($redirect_controller."/".$redirect_function."?localdate=".$_REQUEST['localdate']);

            } // END GR CONTROLLER

            if($type == 'PO')// START PO CONTROLLER
            {
                $checkheader = $this->db->query("SELECT * from backend.pomain where refno = '$refno'");
                foreach($checkheader->result() as $row)
                {
                    $this->db->query("REPLACE INTO panda_platform.trans SELECT '$trans_guid' as trans_guid
                                    , '$type' as type
                                    , '$header_guid' as web_guid 
                                    , '$refno' as refno
                                    , '$location' as location
                                    , '$do_no' as do_no
                                    , '$inv_no' as inv_no
                                    , '$po_date' as po_date
                                    , '$po_no' as po_no
                                    , '$scode' as scode
                                    , '$s_name' as s_name
                                    , '$reason' as reason
                                    , '' as datetime
                                    , now() as created_at
                                    , '".$_SESSION['username']."' as created_by
                                    , '' as sync_in
                                    , '' as sync_in_datetime        
                                    , '' as sync_out       
                                    , '' as sync_out_datetime  
                                    , '0' as printed
                                    , '' as printed_datetime
                                    , '' as  status
                                     ");
                }
                //echo $this->db->last_query();die;
                $trans_guid = $this->db->query("SELECT trans_guid from panda_platform.trans where refno = '$refno'")->row('trans_guid');

                $checkchild = $this->db->query("SELECT * FROM backend.pochild WHERE refno ='$refno'");

                foreach($checkchild->result() as $i => $id )
                {
                    $this->db->query("REPLACE INTO panda_platform.trans_c 
                        SELECT 
                        upper(replace(uuid(),'-','')) as  trans_guid_c 
                        , '$trans_guid' as trans_guid     
                        , '$type' as type
                        , '$header_guid' as web_guid
                        , '".$id->Line."' as web_c_guid
                        , '$refno' as refno          
                        , '".$id->Itemcode."' as itemcode       
                        , '".addslashes($id->Description)."' as description    
                        , '".$id->Barcode."' as barcode        
                        , '".$id->Qty."' as qty            
                        , '' as reason         
                        , '' as  datetime  
                        , now() as created_at
                        , '".$_SESSION['username']."' as created_by 
                        , '' as sync_in
                        , '' as sync_in_datetime        
                        , '' as sync_out       
                        , '' as sync_out_datetime   
                        ");
                }

                //checking if fully pochild sync, flag sync
                $check_ori_count = $this->db->query("SELECT count(line) as ori_count FROM backend.pochild WHERE refno='$refno'")->row('ori_count');

                $check_platform_count = $this->db->query("SELECT count(itemcode) as sync_count FROM panda_platform.trans_c WHERE trans_guid =  '$trans_guid'")->row('sync_count');

                if($check_ori_count == $check_platform_count)
                {
                    $this->db->query("UPDATE panda_platform.trans_c set sync_in = '1', sync_in_datetime = now() where trans_guid = '$trans_guid'");
                    $this->db->query("UPDATE panda_platform.trans set sync_in = '1' , sync_in_datetime = now() where trans_guid = '$trans_guid'");
                }
                else
                {
                    $this->db->query("DELETE from panda_platform.trans where trans_guid = '$trans_guid'");
                    $this->db->query("DELETE from panda_platform.trans_c where trans_guid = '$trans_guid'");

                    redirect('general_scan_controller/general_post?type='.$type.'&header_guid='.$head_guid.'&location='.$location.'&redirect_controller='.$redirect_controller.'&redirect_function='.$redirect_function);
                }

                $this->session->set_flashdata('message', 'Posted');
                    redirect($redirect_controller."/".$redirect_function."?localdate=".$_REQUEST['localdate']);

            }; // END PO 

            if($type == 'Adjust-In' || $type == 'Adjust-Out') // START adjin adjout CONTROLLER
            {
                $checkheader = $this->db->query("SELECT * from backend.web_trans where web_guid = '$header_guid'");
                $reason = $checkheader->row('reason');

                foreach($checkheader->result() as $row)
                {
                    $this->db->query("REPLACE INTO panda_platform.trans SELECT '$trans_guid' as trans_guid
                                    , '$type' as type
                                    , '$header_guid' as web_guid 
                                    , '$refno' as refno
                                    , '$location' as location
                                    , '$do_no' as do_no
                                    , '$inv_no' as inv_no
                                    , '$po_date' as po_date
                                    , '$po_no' as po_no
                                    , '' as scode
                                    , '' as s_name
                                    , '$reason' as reason
                                    , '' as datetime
                                    , now() as created_at
                                    , '".$_SESSION['username']."' as created_by
                                    , '' as sync_in
                                    , '' as sync_in_datetime        
                                    , '' as sync_out       
                                    , '' as sync_out_datetime  
                                    , '0' as printed
                                    , '' as printed_datetime
                                    , '' as  status
                                     ");
                }

                $trans_guid = $this->db->query("SELECT trans_guid from panda_platform.trans where refno = '$refno'")->row('trans_guid');

                 $checkchild = $this->db->query("SELECT * FROM backend.web_trans_c WHERE web_guid ='$header_guid'");

                foreach($checkchild->result() as $i => $id )
                {
                    $this->db->query("REPLACE INTO panda_platform.trans_c 
                        SELECT 
                        upper(replace(uuid(),'-','')) as  trans_guid_c 
                        , '$trans_guid' as trans_guid     
                        , '$type' as type
                        , '$header_guid' as web_guid
                        , '".$id->web_c_guid."' as web_c_guid
                        , '$refno' as refno          
                        , '".$id->itemcode."' as itemcode       
                        , '".addslashes($id->description)."' as description    
                        , '".$id->barcode."' as barcode        
                        , '".$id->qty."' as qty            
                        , '".addslashes($id->remark_c)."' as reason         
                        , '' as  datetime  
                        , now() as created_at
                        , '".$_SESSION['username']."' as created_by 
                        , '' as sync_in
                        , '' as sync_in_datetime        
                        , '' as sync_out       
                        , '' as sync_out_datetime   
                        ");
                }

                //checking if fully web_trans_c sync, flag sync
                $check_ori_count = $this->db->query("SELECT count(web_c_guid) as ori_count FROM backend.web_trans_c WHERE web_guid='$header_guid'")->row('ori_count');

                $check_platform_count = $this->db->query("SELECT count(itemcode) as sync_count FROM panda_platform.trans_c WHERE trans_guid =  '$trans_guid'")->row('sync_count');

                if($check_ori_count == $check_platform_count)
                {
                    $this->db->query("UPDATE panda_platform.trans_c set sync_in = '1', sync_in_datetime = now() where trans_guid = '$trans_guid'");
                    $this->db->query("UPDATE panda_platform.trans set sync_in = '1' , sync_in_datetime = now() where trans_guid = '$trans_guid'");
                }
                else
                {
                    $this->db->query("DELETE from panda_platform.trans where trans_guid = '$trans_guid'");
                    $this->db->query("DELETE from panda_platform.trans_c where trans_guid = '$trans_guid'");

                    redirect('general_scan_controller/general_post?type='.$type.'&header_guid='.$head_guid.'&location='.$location.'&redirect_controller='.$redirect_controller.'&redirect_function='.$redirect_function);
                }

                if($type=='Adjust-In')
                {
                    $this->session->set_flashdata('message', 'Posted');
                    redirect($redirect_controller.'/'.$redirect_function);    
                }
                else
                {
                    if($reason == 'DISPOSAL')
                    {
                        $para = 'DP';
                    }
                    elseif($reason == 'OWN USE')
                    {
                        $para = 'OU';
                    }
                    else
                    {
                        $para = 'AO';
                    }
                    $this->session->set_flashdata('message', 'Posted');
                    redirect($redirect_controller."/".$redirect_function."?type=".$para);
                    //echo var_dump($redirect_controller."/".$redirect_function."?type=".$para);
                  //  die;
                }  

            }; // END ADJUST IN OUT DISPOSAL

            if($type == 'DN') // START GRRETURN CONTROLLER
            {
                $checkheader = $this->db->query("SELECT * FROM backend.dbnote_basket WHERE converted=0  AND location_to='$location'  AND sup_code='$header_guid' group by sup_code");

                $check_sname = $this->db->query("SELECT name from backend.supcus where code = '".$checkheader->row('sup_code')."'")->row('name');

                //replace into header
                foreach($checkheader->result() as $row)
                {
                    $this->db->query("REPLACE INTO panda_platform.trans SELECT '$trans_guid' as trans_guid
                                    , '$type' as type
                                    , '$header_guid' as web_guid
                                    , '$refno' as refno
                                    , '$location' as location
                                    , '$do_no' as do_no
                                    , '$inv_no' as inv_no
                                    , '$po_date' as po_date
                                    , '$po_no' as po_no
                                    , '$header_guid' as scode
                                    , '$check_sname' as s_name
                                    , '$reason' as reason
                                    , '' as datetime
                                    , now() as created_at
                                    , '".$_SESSION['username']."' as created_by
                                    , '' as sync_in
                                    , '' as sync_in_datetime        
                                    , '' as sync_out       
                                    , '' as sync_out_datetime  
                                    , '0' as printed
                                    , '' as printed_datetime
                                    , '' as  status
                                     ");
                }


                $trans_guid = $this->db->query("SELECT trans_guid from panda_platform.trans where refno = '$refno'")->row('trans_guid');

               // replace into child
                $checkchild = $this->db->query("SELECT item_guid,location_to, SUM(qty) AS qty, itemcode, packsize, description, sup_code, sup_name, reason, scan_barcode, converted FROM backend.dbnote_basket WHERE converted=0  AND location_to='$location'  AND sup_code='$header_guid' GROUP BY itemcode");
                //echo $this->db->last_query();die;
                foreach($checkchild->result() as $i => $id )
                {
                    $this->db->query("REPLACE INTO panda_platform.trans_c 
                        SELECT 
                        upper(replace(uuid(),'-','')) as  trans_guid_c   
                        , '$trans_guid' as trans_guid
                        , '$type' as type
                        , '$header_guid'  as web_guid
                        , '".$id->item_guid."' as web_c_guid
                        , '$refno' as refno          
                        , '".$id->itemcode."' as itemcode       
                        , '".addslashes($id->description)."' as description    
                        , '".$id->scan_barcode."' as barcode        
                        , '".$id->qty."' as qty            
                        , '".addslashes($id->reason)."' as reason         
                        , '' as  datetime  
                        , now() as created_at
                        , '".$_SESSION['username']."' as created_by     
                        , '' as sync_in
                        , '' as sync_in_datetime        
                        , '' as sync_out       
                        , '' as sync_out_datetime  
                        ");
                }

                //checking if fully sync, flag sync
                $check_ori_count = $this->db->query("SELECT count(itemcode) as ori_count FROM backend.dbnote_basket WHERE converted=0  AND location_to='$location' AND sup_code='$header_guid' group by itemcode")->num_rows();

                $check_platform_count = $this->db->query("SELECT count(itemcode) as sync_count FROM panda_platform.trans_c WHERE trans_guid =  '$trans_guid'")->row('sync_count');

                if($check_ori_count == $check_platform_count)
                {
                    $this->db->query("UPDATE panda_platform.trans_c set sync_in = '1', sync_in_datetime = now() where trans_guid = '$trans_guid'");
                    $this->db->query("UPDATE panda_platform.trans set sync_in = '1' , sync_in_datetime = now() where trans_guid = '$trans_guid'");
                }
                else
                {
                    $this->db->query("DELETE from trans where trans_guid = '$trans_guid'");
                    $this->db->query("DELETE from trans_c where trans_guid = '$trans_guid'");

                    redirect('general_scan_controller/general_post?type=DN&header_guid='.$head_guid.'&location='.$location.'&redirect_controller='.$redirect_controller.'&redirect_function='.$redirect_function);
                }

                $this->session->set_flashdata('message', 'Posted');
                redirect($redirect_controller.'/'.$redirect_function);
            }; // END GRRETURN CONTROLLER

        }
        else
        {
            redirect('main_controller');
        }
    }

    



}
?>