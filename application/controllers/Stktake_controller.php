<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stktake_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('stktake_model');
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


    public function scan_userID()
    {
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
       // $location = $this->input->post('location');
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/stktake/scan_userID');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('stktake/scan_userID');
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function scan_binID()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        { 
            //checking table set_weight_parameter, set_weight_type_by_module, set_weight_type_by_module_c
            $module = 'Stock Take';
            $eighteenD = $this->general_scan_model->check_decode($module);

            if ($eighteenD->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'There is no data in set_weight_parameter, please contact Panda support team!');
                redirect("stktake_controller/scan_userID");
                /*$this->db->query("INSERT INTO `set_weight_parameter`(`Weight_guid`,`Weight_type_code`,`Weight_type_desc`,`Weight_bar_pos_start`,`Weight_bar_pos_count`,`Weight_capture_weight`,`Weight_capture_weight_type`,`Weight_capture_pos_start`,`Weight_capture_pos_count`,`Weight_capture_factor`,`Weight_capture_price`,`Weight_capture_price_pos_start`,`Weight_capture_price_pos_count`,`Weight_capture_price_factor`,`created_at`,`created_by`,`updated_at`,`updated_by`) values ('438EB0EDCA2DDA4A3734A3777198099D','barcode only','barcode only',1,7,0,'actual weight',0,0,1,0,0,0,1,'2014-04-01 19:38:29','','2014-04-01 19:38:29','') ");
                $this->db->query("INSERT INTO `set_weight_type_by_module`(`module_guid`,`module_desc`,`created_at`,`created_by`,`updated_at`,`updated_by`) values ('4E6501ECAE1574A988B4BC2C54024069','Stock Take','2014-04-01 19:39:00','admin','2014-04-01 19:39:00','kc') ");
                $this->db->query("INSERT INTO `set_weight_type_by_module_c`(`module_c_guid`,`module_guid`,`as_default`,`weight_guid`,`created_at`,`created_by`,`updated_at`,`updated_by`) values ('9786414143BFD8792F64A30B8EFEC4C8','4E6501ECAE1574A988B4BC2C54024069',1,'438EB0EDCA2DDA4A3734A3777198099D','2014-04-01 19:39:05','kc','2014-04-01 19:39:05','admin')");*/

            };
        
        $user_ID = $this->input->post('user_ID');
        $bin_ID = '';
            
            if ($this->input->post('user_ID') != "")
            {
                $data['trans_guid'] = $result = $this->stktake_model->store_trans();


    
                    $user_ID_Data = array(
                        'user_ID' => $user_ID,
                        'bin_ID' => $bin_ID,
                        'trans_guid' =>$result->row('TRANS_GUID')
                        );
                    $this->session->set_userdata($user_ID_Data);
    
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/stktake/scan_binID', $data, $user_ID_Data);
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('stktake/scan_binID', $data, $user_ID_Data);
                            $this->load->view('footer');
                        }    
            }
            else
            {
                $user_ID = $_REQUEST['user_ID'];
                $data['trans_guid'] = $result = $this->stktake_model->store_trans();
                
                    $user_ID_Data = array(
                        'user_ID' => $user_ID,
                        'bin_ID' => $bin_ID,
                        'trans_guid' =>$result->row('TRANS_GUID')
                        );
                    $this->session->set_userdata($user_ID_Data);
                    
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/stktake/scan_binID', $data, $user_ID_Data);
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('stktake/scan_binID', $data, $user_ID_Data);
                            $this->load->view('footer');
                        }    

            }
        }
        else
        {
            redirect('main_controller');
        }
        
    }


    public function scan_item()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        { 
            
            $bin_ID = $this->input->post('bin_ID');
            $user_ID = $this->input->post('user_ID');

            /*if($_SESSION['trans_guid'] == '')
                {
                    $this->session->set_flashdata('message', 'Please check with IT to open Stock Take date');
                    redirect('stktake_controller/scan_binID');
                };
            */
            if ($_SESSION['trans_guid'] == '')
                {
                    echo "<script>
                    alert('Unable to continue. Please contact IT to set stocktake date.');
                    </script>";
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/stktake/scan_binID');
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('stktake/scan_binID');
                            $this->load->view('footer');
                        }    
                };

            if ($this->input->post('bin_ID') != "")
            {
                $data['binID'] = $result  = $this->stktake_model->check_binID($bin_ID);
                $bin_location = $this->stktake_model->bin_location($bin_ID)->row('location');
                $checksub  = $this->stktake_model->sublocation($bin_ID);
                $sublocation = $checksub->row('sublocation');
                $trans_guid = $_SESSION['trans_guid'];
                $caption = $this->db->query("SELECT IF(send_print = '1', CONCAT('Printed'), ' ') AS printinfo 
                FROM backend_stktake.`stk_trans`
                WHERE `trans_guid` = '$trans_guid'
                AND `bin_id` = '$bin_ID'
                LIMIT 1");
                $printinfo = $caption->row('printinfo');
                if($result->num_rows() != 0)
                {
                    $bin_ID_Data = array(
                        'bin_ID' => $bin_ID,
                        'user_ID' => $user_ID,
                        'bin_location' => $bin_location,
                        'printinfo' => $printinfo,
                        );
                    $this->session->set_userdata($bin_ID_Data);
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/stktake/scan_item', $bin_ID_Data);
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('stktake/scan_item', $bin_ID_Data);
                            $this->load->view('footer');
                        }    
                }
                
                else
                {
                    echo "<script>
                    alert('Bin ID Not Exist.');
                    </script>";
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/stktake/scan_binID');
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('stktake/scan_binID');
                            $this->load->view('footer');
                        }    
                } 
            }
            else
            {

                $bin_ID = $_REQUEST['bin_ID'];
                $user_ID = $_REQUEST['user_ID'];
                $bin_location = $this->stktake_model->bin_location($bin_ID)->row('location');
                $checksub  = $this->stktake_model->sublocation($bin_ID);
                $sublocation = $checksub->row('sublocation');
                $trans_guid = $_SESSION['trans_guid'];
                $caption = $this->db->query("SELECT IF(send_print = '1', CONCAT('Printed'), ' ') AS printinfo 
                FROM backend_stktake.`stk_trans`
                WHERE `trans_guid` = '$trans_guid'
                AND `bin_id` = '$bin_ID'
                LIMIT 1");
                $printinfo = $caption->row('printinfo');
                $bin_ID_Data = array(
                    'bin_ID' => $bin_ID,
                    'user_ID' => $user_ID,
                    'bin_location' => $bin_location,
                    'printinfo' => $printinfo,
                    );
                    $this->session->set_userdata($bin_ID_Data);
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/stktake/scan_item', $bin_ID_Data);
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('stktake/scan_item', $bin_ID_Data);
                            $this->load->view('footer');
                        }   

            }
        }
        else
        {
            redirect('main_controller');
        }
        
    }


    public function scan_item_result()
    {
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            if(isset($_REQUEST['barcode']))
            {
                $barcode = $_REQUEST['barcode'];
            }
            else
            {
                $barcode = $this->input->post('barcode');
            }
            
            if($barcode != "")
            {
                $_SESSION['barcode'] = $barcode;
            $module = 'Stock Take';

                       
             // check if need decode
            $barcode_type1 = $this->general_scan_model->check_itemmaster_all($barcode);
            
             if($barcode_type1->num_rows() > 0 )
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
                                  //  021466380512
                                  /*  $barcode_type = '';*/
                                    $this->session->set_flashdata('message', 'Barcodess does not exist');
                                   redirect("stktake_controller/scan_item?bin_ID=".$_SESSION['bin_ID']."&user_ID=".$_SESSION['user_ID']);
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
                            if($weight_capture_weight_type == 'actual weight' )
                            {
                                    if($barcode_type == 'Q') // sold by qty
                                    {
                                    $get_weight = substr($barcode, 
                                        $weight_capture_pos_start-1
                                        , $weight_capture_pos_count);
    
                                    }
                                    else // sold by weight
                                    {
                                    $get_weight = substr($barcode,$weight_capture_pos_start-1
                                                , $weight_capture_pos_count)/
                                                $weight_capture_factor;
                                    }
                               
                            }
                            else
                            {
                            $get_weight = (substr($barcode, $weight_capture_pos_start-1
                                        , $weight_capture_pos_count)/ $weight_capture_factor)  ;
                           /* /$getsellingprice;*/ 
                            } // end actual weight

                            $get_weight = round($get_weight,3);

                        }else //else weight capture weight
                        {
                             $get_weight = '0';
                        }

                        if($weight_capture_price == 1)
                        {
                        $get_price = substr($barcode, $weight_capture_price_pos_start-1,
                            $weight_capture_price_pos_count)/
                            $weight_capture_price_factor;
                        }
                        else
                        {
                            $get_price = '0';
                        }
                        //$get_price = round($get_price,3);

                        $temp_weight_price = array(
                                    'get_weight' =>$get_weight,
                                    'get_price' => $get_price,
                                    );
                                    $this->session->set_userdata($temp_weight_price); 

                        if ( strlen($barcode)== '18')
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
                        echo 'direct click link mode';
                    }
                } // end 18D num_rows != 0
                else
                {
                    $this->session->set_flashdata('message', 'Some setting does not exist!');
                    redirect('stktake_controller/scan_item?user_ID='.$_SESSION['user_ID']."&bin_ID=".$_SESSION['bin_ID']);
                }
            } // end elseif num_rows() == 0
            else
            {
                echo 'barcode_type1 there something wrong. contact panda programmer.';
            }
            $check = $this->stktake_model->check_guid($barcode);
            $check_im = $this->general_scan_model->check_itemcode($barcode);
            
            if($check->num_rows() == 0 )
            {
                $data['item']=$this->stktake_model->itemresult_new($barcode);
                $data['itemQty']=$this->stktake_model->itemQty($barcode);
                $data['detail']=$this->stktake_model->deptsubdept($barcode);
                
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/stktake/scan_item_result', $data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('stktake/scan_item_result', $data);
                        $this->load->view('footer');
                    }
            }// end check num rows == 0        
            else if ($check->num_rows() != 0 )
            {
                $data['item']=$this->stktake_model->itemresult_new($barcode);
                $data['itemQty']=$this->stktake_model->itemQty($barcode);
                $data['detail']=$this->stktake_model->deptsubdept($barcode);
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/stktake/edit_item_result', $data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('stktake/edit_item_result', $data);
                        $this->load->view('footer');
                    }    
            }
            else
            {
                 $this->session->set_flashdata('message', 'Barcode does not exist');
                 redirect('stktake_controller/scan_item?user_ID='.$_SESSION['user_ID']."&bin_ID=".$_SESSION['bin_ID']);
            } // end else check numrows == 0
            } // end if barcode exist or not
        } // end login = true
        else
        {
            redirect('main_controller');
        } // end else login = false
    } // end function
 public function add_qty()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {

        $barcode = $this->input->post('barcode');
        $bin_ID = $this->input->post('bin_ID');
        $itemcode = $this->input->post('itemcode');
        $description = addslashes($this->input->post('description'));
        $itemlink = $this->input->post('itemlink');
        $iqty = $this->input->post('iqty');
        $defaultqty = $this->input->post('defaultqty');
        $qty = $this->input->post('qty');
        $trans_guid = $_SESSION['trans_guid'];
        $sublocation = $_SESSION['sub_location'];
        $bin_location = $_SESSION['bin_location'];

        $totalqty  = $iqty+$defaultqty;

        if($_SESSION['get_weight'] == '' && abs($iqty) > '100000')
        {
            $this->session->set_flashdata('message', 'Qty Input is too large, please try again!');
            redirect('stktake_controller/scan_item_result?barcode='.$_SESSION['barcode']);
        };

        $check_null = $this->db->query("SELECT * from backend.itembarcode where barcode = '$barcode'");

        if($check_null->num_rows() == 0)
        {
            $this->session->set_flashdata('message', 'BARCODE ERROR! Please RESCAN');
            redirect('stktake_controller/scan_item_result?barcode='.$_SESSION['barcode']);
        };

        $check_duplicate_stk_trans_c = $this->db->query("SELECT * from backend_stktake.stk_trans_c where TRANS_GUID = '$trans_guid' AND Barcode = '$barcode' AND Bin_ID = '$bin_ID' ");

        if($check_duplicate_stk_trans_c->num_rows() > 0)
        {
            $this->session->set_flashdata('message', 'Duplicate entry found, please do not keep refreshing page while loading!');
            redirect('stktake_controller/scan_item_result?barcode='.$_SESSION['barcode']);
        };

        $result = $this->stktake_model->add_qty($barcode,$itemcode,$description,$itemlink,$totalqty); 
        $result2 = $this->stktake_model->add_stk_trans();
        $result3 = $this->stktake_model->update_stk_trans();  

        $check_stkqoh = $this->db->query("SELECT * FROM backend_stktake.stk_qoh WHERE trans_guid = '$trans_guid' AND itemcode = '$itemcode' ");

        if ($check_stkqoh->num_rows() == 0 )
        {
            $add_stkqoh = $this->db->query("INSERT INTO backend_stktake.`stk_qoh` (TRANS_GUID,TRANS_CHILD,Location,Itemcode,Barcode) 
                VALUES('$trans_guid', REPLACE(UPPER(UUID()),'-',''), '$bin_location', '$itemcode', '$barcode')");
            $update_stkqoh = $this->db->query("UPDATE backend_stktake.stk_qoh m 
                INNER JOIN (SELECT b.`Location`,a.itemcode,IF(SUM(a.qty) IS NULL,0,SUM(a.qty)) AS sum_qty 
                FROM backend_stktake.`stk_trans` a 
                INNER JOIN  backend_stktake.set_bin b 
                ON a.`BIN_ID`=b.`BIN_NO` 
                WHERE a.trans_guid='$trans_guid'
                AND a.`Itemcode`='$itemcode'
                GROUP BY b.`Location`,a.itemcode) n 
                ON m.`Itemcode`=n.itemcode SET m.stk_qty=n.sum_qty 
                WHERE m.trans_guid='$trans_guid'
                AND m.`Itemcode`='$itemcode'");
            $edit_stkqoh = $this->db->query("UPDATE backend_stktake.stk_qoh SET Stk_Variance=stk_qty-qoh 
                WHERE trans_guid='$trans_guid' AND itemcode='$itemcode'");
            $result4 = $this->stktake_model->updateitemmasterinfo($itemcode); 
        }
        else
        {
            $update_stkqoh = $this->db->query("UPDATE backend_stktake.stk_qoh m 
                INNER JOIN (SELECT b.`Location`,a.itemcode,IF(SUM(a.qty) IS NULL,0,SUM(a.qty)) AS sum_qty 
                FROM backend_stktake.`stk_trans` a 
                INNER JOIN  backend_stktake.set_bin b 
                ON a.`BIN_ID`=b.`BIN_NO` 
                WHERE a.trans_guid='$trans_guid'
                AND a.`Itemcode`='$itemcode'
                GROUP BY b.`Location`,a.itemcode) n 
                ON m.`Itemcode`=n.itemcode SET m.stk_qty=n.sum_qty 
                WHERE m.trans_guid='$trans_guid'
                AND m.`Itemcode`='$itemcode'");           
            $edit_stkqoh = $this->db->query("UPDATE backend_stktake.stk_qoh SET Stk_Variance=stk_qty-qoh 
                WHERE trans_guid='$trans_guid' AND itemcode='$itemcode'");
        };
        //prevent db corrupt as reported by kelwin
        $requery_after_insert = $this->db->query("SELECT requery_after_insert from backend.xsetup")->row('requery_after_insert');
        if($requery_after_insert == '1')
        {
            $check_stk_trans_c = $this->db->query("select * from backend_stktake.stk_trans_c where trans_guid = '$trans_guid' and itemcode = '$itemcode' and bin_id = '".$_SESSION['bin_ID']."'");
            if($check_stk_trans_c->row('Qty') != $totalqty)
            {   
                // echo $check_stk_trans_c->row('qty'); echo '  ===>  '; echo $totalqty; die;
                $this->session->set_flashdata('message', 'Input Qty does not tally with Qty Stored. Please Print report to double confirm.');
                redirect("stktake_controller/scan_item?bin_ID=".$_SESSION['bin_ID']."&user_ID=".$_SESSION['user_ID']);
            }

        };


                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/stktake/scan_item');
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('stktake/scan_item');
                        $this->load->view('footer');
                    }   
                
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function edit_qty()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
        $barcode = $this->input->post('barcode');
        $bin_ID = $_SESSION['bin_ID'];
        $itemcode = $this->input->post('itemcode');
        $description = addslashes($this->input->post('description'));
        $itemlink = $this->input->post('itemlink');
        $iqty = $this->input->post('iqty');
        $defaultqty = $this->input->post('defaultqty');
        $qty = $this->input->post('qty');
        $trans_guid = $_SESSION['trans_guid'];
        $sublocation = $_SESSION['sub_location'];
        $bin_location = $_SESSION['bin_location'];
    
        $totalqty  = $iqty+$defaultqty;

        if($_SESSION['get_weight'] == '' && abs($iqty) > '100000')
        {
            $this->session->set_flashdata('message', 'Qty Input is too large, please try again!');
            redirect('stktake_controller/scan_item_result?barcode='.$_SESSION['barcode']);
        };

        $check_null = $this->db->query("SELECT * from backend.itembarcode where barcode = '$barcode'");

        if($check_null->num_rows() == 0)
        {
            $this->session->set_flashdata('message', 'BARCODE ERROR! Please RESCAN');
            redirect('stktake_controller/scan_item_result?barcode='.$_SESSION['barcode']);
        };

        $c_itemcode_tran_c = $this->db->query("SELECT trans_guid, barcode, bin_id, itemcode, itemlink, qty from backend_stktake.stk_trans_c where barcode = '$barcode' and trans_guid = '$trans_guid' and itemcode = '$itemcode' and bin_id ='$bin_ID'  ");
        //echo $this->db->last_query();die;
        if($c_itemcode_tran_c->num_rows() > 0)//checking if itemcode in stk_trans_c has changed and cant find in itembarcode
        {
            $result = $this->stktake_model->edit_qty($barcode,$itemcode,$description,$itemlink,$totalqty);
            $result2 = $this->stktake_model->edit_stk_trans();
            // insert into user_log
            $this->db->query("INSERT INTO backend_stktake.user_log SELECT upper(replace(uuid(),'-','')), '$trans_guid', '$barcode', '$bin_ID', '$itemcode', '$description', '$itemlink', '".$c_itemcode_tran_c->row('qty')."', '$totalqty', now(),'".$_SESSION['user_ID']."' ");

            $check_stkqoh = $this->db->query("SELECT * FROM backend_stktake.stk_qoh WHERE trans_guid='$trans_guid' AND itemcode='$itemcode' ");

            if ($check_stkqoh->num_rows() == 0 )
            {
                $add_stkqoh = $this->db->query("INSERT INTO backend_stktake.`stk_qoh` (TRANS_GUID,TRANS_CHILD,Location,Itemcode,Barcode) 
                VALUES('$trans_guid', REPLACE(UPPER(UUID()),'-',''), '$bin_location', '$itemcode', '$barcode')");
                $update_stkqoh = $this->db->query("UPDATE backend_stktake.stk_qoh m 
                INNER JOIN (SELECT b.`Location`,a.itemcode,IF(SUM(a.qty) IS NULL,0,SUM(a.qty)) AS sum_qty 
                FROM backend_stktake.`stk_trans` a 
                INNER JOIN  backend_stktake.set_bin b 
                ON a.`BIN_ID`=b.`BIN_NO` 
                WHERE a.trans_guid='$trans_guid'
                AND a.`Itemcode`='$itemcode'
                GROUP BY b.`Location`,a.itemcode) n 
                ON m.`Itemcode`=n.itemcode SET m.stk_qty=n.sum_qty 
                WHERE m.trans_guid='$trans_guid'
                AND m.`Itemcode`='$itemcode'");
                $edit_stkqoh = $this->db->query("UPDATE backend_stktake.stk_qoh SET Stk_Variance=stk_qty-qoh 
                WHERE trans_guid='$trans_guid' AND itemcode='$itemcode'");
            }
            else
            {
                $update_stkqoh = $this->db->query("UPDATE backend_stktake.stk_qoh m 
                INNER JOIN (SELECT b.`Location`,a.itemcode,IF(SUM(a.qty) IS NULL,0,SUM(a.qty)) AS sum_qty 
                FROM backend_stktake.`stk_trans` a 
                INNER JOIN  backend_stktake.set_bin b 
                ON a.`BIN_ID`=b.`BIN_NO` 
                WHERE a.trans_guid='$trans_guid'
                AND a.`Itemcode`='$itemcode'
                GROUP BY b.`Location`,a.itemcode) n 
                ON m.`Itemcode`=n.itemcode SET m.stk_qty=n.sum_qty 
                WHERE m.trans_guid='$trans_guid'
                AND m.`Itemcode`='$itemcode'");           
                $edit_stkqoh = $this->db->query("UPDATE backend_stktake.stk_qoh SET Stk_Variance=stk_qty-qoh 
                WHERE trans_guid='$trans_guid' AND itemcode='$itemcode'");
            }

             //prevent db corrupt as reported by kelwin
        $requery_after_insert = $this->db->query("SELECT requery_after_insert from backend.xsetup")->row('requery_after_insert');
        if($requery_after_insert == '1')
        {
            $check_stk_trans_c = $this->db->query("select * from backend_stktake.stk_trans_c where trans_guid = '$trans_guid' and itemcode = '$itemcode' and bin_id = '".$_SESSION['bin_ID']."'");
            if($check_stk_trans_c->row('Qty') != $totalqty)
            {   
                // echo $check_stk_trans_c->row('qty'); echo '  ===>  '; echo $totalqty; die;
                $this->session->set_flashdata('message', 'Input Qty does not tally with Qty Stored. Please Print report to double confirm.');
                redirect("stktake_controller/scan_item?bin_ID=".$_SESSION['bin_ID']."&user_ID=".$_SESSION['user_ID']);
            }

        };
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/stktake/scan_item');
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('stktake/scan_item');
                        $this->load->view('footer');
                    }    
        }
        else //c_itemcode_tran_c
        {
           $check_prev_record = $this->db->query("SELECT trans_guid, barcode, bin_id, itemcode, itemlink, qty from backend_stktake.stk_trans_c where barcode = '$barcode' and trans_guid = '$trans_guid'  and bin_id = '".$_SESSION['bin_ID']."' ");
          //echo $this->db->last_query();die;
            $this->session->set_flashdata("message", "Data not Saved. <br> Barcode / Itemcode has changed between server and stock take data. <br><br> Please contact Panda Software Support Team Immediately! <br> Current Barcode : ".$barcode." <br> Current Itemcode : ".$itemcode." <br> Previous Barcode : ".$check_prev_record->row('barcode')." <br> Previous Itemcode : ".$check_prev_record->row('itemcode')." <br>");
            redirect('stktake_controller/scan_item?user_ID='.$_SESSION['user_ID']."&bin_ID=".$_SESSION['bin_ID']);
        }
        }
        else
        {
        redirect('main_controller');
        }
    }

    public function send_print()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $sublocation = $_SESSION['sub_location'];
            $trans_guid = $_SESSION['trans_guid'];
            $bin_ID = $_SESSION['bin_ID'];
            $user_ID = $_SESSION['user_ID'];
            $send_print = $this->db->query("update backend_stktake.stk_trans set send_print = '1', send_print_sublocation = '$sublocation' where  trans_guid = (SELECT trans_guid FROM backend_stktake.set_date WHERE status_closed=0) AND bin_id='$bin_ID'");
            redirect('stktake_controller/scan_item?bin_ID='.$bin_ID."&user_ID=".$user_ID);
        }
        else
        {
            redirect('main_controller');
        }
    }
    
} // DO NOT END BEFORE HERE
?>