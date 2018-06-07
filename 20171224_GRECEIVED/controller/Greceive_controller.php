<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class greceive_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('greceive_model');
        $this->load->model('main_model');
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
        $this->load->library('form_validation');

	}

    public function po_list()
    {
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $data['po_list']=$this->greceive_model->po_list();
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/po_list', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/po_list', $data);
                    $this->load->view('footer');
                }    
        }
        else
        {
           redirect('main_controller');
        }
    }


    public function scan_po()
    {   
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/scan_po');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/scan_po');
                    $this->load->view('footer');                    
                }
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function scan_po_result()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') !='')
        { 
        
        $po_no = $this->input->post('po_no');

            $data['po_details'] = $result = $this->greceive_model->scan_po_result($po_no);
            if($result->num_rows() != 0)
            {
                $po_no_Data = array(
                                      
                    'po_no' => $po_no,
                    'sup_code' => $result->row('SCode'),
                    'sup_name' => $result->row('SName'),
                    );
                $this->session->set_userdata($po_no_Data);

                if($result->row('Completed')=='1')
                {
                    $this->session->set_flashdata('message', 'PO already Closed : '.$po_no);
                    redirect('greceive_controller/scan_po');
                }
                else
                {
                    if($result->row('expiry_date') < date('Y-m-d') )
                    {
                        $this->session->set_flashdata('message', 'PO already Expired : '.$po_no. "<br> Expiry date : ". $result->row('expiry_date'));
                        redirect('greceive_controller/scan_po');
                    };

                    $get_setting = $this->db->query("SELECT arrive_earlier_po FROM backend.`xsetup`")->row('arrive_earlier_po');
                    if ($result->row('DeliverDate') > date('Y-m-d') && $get_setting == 0)
                    {
                        $this->session->set_flashdata('message', 'Delivery Date for this PO is not today: '.$po_no. "<br> Deliver date : ". $result->row('DeliverDate'));
                            redirect('greceive_controller/scan_po');
                    }
                    else
                    {
                        $result2 = $this->greceive_model->po_add($po_no);
                        if($result2->num_rows() == 0)
                        {
                            redirect('greceive_controller/po_add?po_no='.$po_no."&sname=".$result->row('SName'));
                        }
                        else
                        {
                            $this->session->set_flashdata('message', 'PO No already exist in pending grn : '.$po_no );
                            redirect('greceive_controller/scan_po');
                        }
                    }  
                } 
            }
            else
            {
                $this->session->set_flashdata('message', 'PO No not found : '.$po_no);
                redirect('greceive_controller/scan_po');
            }
        
        }
        else
        {
            redirect('main_controller');
        }
        
    }

    public function po_edit()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $po_no = $_REQUEST['po_no'];
            $sname = $_REQUEST['sname'];

            $data = array(
                'po_details' => $this->greceive_model->po_details($po_no),
                'po_no' => $po_no,
                'sname' => $sname,
                'method' => 'Edit',
                'form_action' => site_url('greceive_controller/po_edit_update'),
                'back' => site_url('greceive_controller/po_list')
                );
            $sessiondata = array(
                'po_no' => $po_no,
                'sname' => $sname,
                'grn_guid' => $_REQUEST['grn_guid'],
                );
            $this->session->set_userdata($sessiondata);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/po_add', $data, $sessiondata);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/po_add', $data, $sessiondata);
                    $this->load->view('footer'); 
                }    

        }
        else
        {
            redirect('main_controller');
        }

    }

    public function po_edit_update()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $datetime = $this->db->query("SELECT NOW() AS datetime");

            $check_current_record = $this->db->query("SELECT * from backend_warehouse.d_grn where grn_guid = '".$_SESSION['grn_guid']."'");


            if($this->input->post('inv_date') == '')
            {   
                $this->session->set_flashdata('message', 'Invoice Date Cannot be empty');
                redirect('greceive_controller/po_edit?po_no='.$_SESSION['po_no']."&sname=".$_SESSION['sname']."&grn_guid=".$_SESSION['grn_guid']);
            };

            if($this->input->post('inv_date') > $this->input->post('received_date'))
            {   
                $this->session->set_flashdata('message', 'Goods Received Date cannot be earlier than Invoice Date');
                redirect('greceive_controller/po_edit?po_no='.$_SESSION['po_no']."&sname=".$_SESSION['sname']."&grn_guid=".$_SESSION['grn_guid']);
            };

            if($this->input->post('received_date') > $check_current_record->row("created_at"))
            {
                $this->session->set_flashdata('message', 'Goods Received Date cannot be later than Created Date');
                redirect('greceive_controller/po_edit?po_no='.$_SESSION['po_no']."&sname=".$_SESSION['sname']."&grn_guid=".$_SESSION['grn_guid']);
            };

            /*if($this->input->post('inv_date') < $this->input->post('received_date'))
            {   
                $this->session->set_flashdata('message', 'Invoice Date Cannot be less than received date');
                redirect('greceive_controller/po_edit?po_no='.$_SESSION['po_no']."&sname=".$_SESSION['sup_name']);
            };*/
 
            if(round($this->input->post('amt_exc_tax')+$this->input->post('gst_tax'),4) != round($this->input->post('amt_inc_tax'),4)  )
            {   
                /*$this->session->set_flashdata('message', "Amount Exclude Tax + Tax Amount does not tally");*/
               // $sum = round($this->input->post('amt_exc_tax')+$this->input->post('gst_tax'),4);

                $this->session->set_flashdata('message', "Amount Exclude Tax + Tax Amount does not tally");
                redirect('greceive_controller/po_edit?po_no='.$_SESSION['po_no']."&sname=".$_SESSION['sname']."&grn_guid=".$_SESSION['grn_guid']);
            };


            if($this->input->post('inv_no') == '')
            {
                $inv_no = $this->input->post('do_no');
            }
            else
            {
                $inv_no = $this->input->post('inv_no');
            }

            $data = array(
                'do_no' => strtoupper($this->input->post('do_no')),
                'inv_no' => strtoupper($inv_no),
                'inv_date' => $this->input->post('inv_date'),
                'received_date' => $this->input->post('received_date'),
                'amt_inc_tax' => $this->input->post('amt_inc_tax'), 
                'amt_exc_tax' => $this->input->post('amt_exc_tax'), 
                'gst_tax' => $this->input->post('gst_tax'), 
                'updated_at' => $datetime->row('datetime'),
                'updated_by' => $_SESSION['username'],
                );

            $this->greceive_model->po_edit_update($data);

            redirect('greceive_controller/po_list');

        }
        else
        {
            redirect('main_controller');
        }

    }

    public function po_delete()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $grn_guid = $_REQUEST['grn_guid'];
            
            $this->greceive_model->d_grn_delete($grn_guid);

            redirect('greceive_controller/po_list');

        }
        else
        {
            redirect('main_controller');
        }

    }

    public function po_add()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $po_no = $_REQUEST['po_no'];
            $sname = $_REQUEST['sname'];
            
            $data = array(
                'po_details' => $this->greceive_model->po_details($po_no),
                'po_no' => $po_no,
                'sname' => $sname,
                'method' => 'Add',
                'form_action' => site_url('greceive_controller/po_add_insert'),
                'back' => site_url('greceive_controller/scan_po')
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/po_add', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/po_add', $data);
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function po_add_insert()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $account_code = $this->db->query("SELECT a.`AccountCode` FROM backend.`supcus` a WHERE a.`Code` = '".$_SESSION['sup_code']."' ")->row('AccountCode');
            // $check_do_no = $this->db->query("SELECT * FROM backend_warehouse.d_grn WHERE do_no = '".$this->input->post('do_no')."' AND inv_no = '$inv_no' AND scode = '".$_SESSION['sup_code']."' ");
            $check_do_no = $this->db->query("SELECT * FROM backend_warehouse.d_grn a INNER JOIN backend.supcus b ON a.`scode` = b.`Code` WHERE do_no = '".$this->input->post('do_no')."' AND inv_no = '$inv_no' AND a.scode = '".$_SESSION['sup_code']."' AND b.`AccountCode` = '$account_code'");

            if($check_do_no->num_rows() > 0)
            {
                $this->session->set_flashdata('message', 'Invoice Number already exist in: '.$_SESSION['po_no']);
                redirect('greceive_controller/po_add?po_no='.$_SESSION['po_no']."&sname=".$_SESSION['sup_name']);
            }

            if($this->input->post('inv_date') == '')
            {   
                $this->session->set_flashdata('message', 'Invoice Date Cannot be empty');
                redirect('greceive_controller/po_add?po_no='.$_SESSION['po_no']."&sname=".$_SESSION['sup_name']);
            };

            if($this->input->post('inv_date') > $this->input->post('received_date'))
            {   
                $this->session->set_flashdata('message', 'Goods Received Date cannot be earlier than Invoice Date');
                redirect('greceive_controller/po_add?po_no='.$_SESSION['po_no']."&sname=".$_SESSION['sup_name']);
            };



            /*if($this->input->post('inv_date') < $this->input->post('received_date'))
            {   
                $this->session->set_flashdata('message', 'Invoice Date Cannot be less than received date');
                redirect('greceive_controller/po_add?po_no='.$_SESSION['po_no']."&sname=".$_SESSION['sup_name']);
            };*/
 
            if(round($this->input->post('amt_exc_tax')+$this->input->post('gst_tax'),4) != round($this->input->post('amt_inc_tax'),4)  )
            {   
                $this->session->set_flashdata('message', 'Amount Exclude Tax + Tax Amount does not tally');
                redirect('greceive_controller/po_add?po_no='.$_SESSION['po_no']."&sname=".$_SESSION['sup_name']);
            };



            $datetime = $this->db->query("SELECT NOW() AS datetime");
            $date = $this->db->query("SELECT CURDATE() as date");
            $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid");

            $check_sysrun = $this->db->query("SELECT * from backend_warehouse.set_sysrun where run_type='GRNBATCH'");

            $run_year = $this->db->query("SELECT YEAR(CURRENT_TIMESTAMP) as year");
            $run_month = $this->db->query("SELECT MONTH(CURRENT_TIMESTAMP) as month");
            $run_day = $this->db->query("SELECT DAY(CURRENT_TIMESTAMP) as day");

            if($check_sysrun->row('run_date') == '')
            {
                $data = array(

                    'run_type' => 'GRNBATCH',
                    'run_code' => 'GW',
                    'run_year' => $run_year->row('year'),
                    'run_month' => $run_month->row('month'),
                    'run_day' => $run_day->row('day'),
                    'run_date' => $date->row('date'),
                    'run_currentno' => '0',
                    'run_digit' => '4',
                    );
                $this->greceive_model->insert_sysrun($data);
                $get_run_date = $this->db->query("SELECT * from backend_warehouse.set_sysrun where run_type='GRNBATCH'");
            };

            if($check_sysrun->row('run_date') < $date->row('date'))
            {
                $data= array(
                    'run_date' => $date->row('date'),
                    'run_currentno' => 1,
                    );
                $this->greceive_model->update_sysrun($data);
            }
            else
            {
                $data= array(
                    'run_currentno' => $check_sysrun->row('run_currentno')+1,
                    );
                $this->greceive_model->update_sysrun($data);
            }

            $getRefNo = $this->db->query("SELECT CONCAT(run_code, REPLACE(run_date, '-', ''), REPEAT(0,run_digit-LENGTH(run_currentno + 1)), run_currentno,LPAD(FLOOR(RAND() * 99),2,0))
                AS refno FROM backend_warehouse.set_sysrun WHERE run_type = 'GRNBATCH' ");

            $pomain = $this->db->query('SELECT * from backend.pomain where BillStatus="1" and Completed<>"1" and refno="'.$_SESSION['po_no'].'"');

            if($this->input->post('inv_no') == '')
            {
                $inv_no = $this->input->post('do_no');
            }
            else
            {
                $inv_no = $this->input->post('inv_no');
            }

            $data = array(

                'grn_guid' => $guid->row('guid'),
                'grn_id' => $getRefNo->row('refno'),
                'trans_type' => 'GRN_WEIGHT',
                'loc_group' => $_SESSION['loc_group'],
                'location' => $_SESSION['location'],
                'sublocation' => $_SESSION['sub_location'],
                'po_no' => $pomain->row('RefNo'),
                'po_date' => $pomain->row('DeliverDate'),
                'scode' => $pomain->row('SCode'),
                's_name' => $pomain->row('SName'),
                'send_print' => '0',
                'convert_grn' => '0',
                'received' => '0',

                'do_no' => strtoupper($this->input->post('do_no')),
                'inv_no' => strtoupper($inv_no),
                'inv_date' => $this->input->post('inv_date'),
                'received_date' => $this->input->post('received_date'),
                'amt_inc_tax' =>  $this->input->post('amt_inc_tax'), 
                'amt_exc_tax' =>  $this->input->post('amt_exc_tax'), 
                'gst_tax' =>  $this->input->post('gst_tax'), 

                'created_at' => $datetime->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at' => $datetime->row('datetime'),
                'updated_by' => $_SESSION['username'],
            );

            $grn_guid = $guid->row('guid');

                $this->greceive_model->po_add_insert($data);

                $this->greceive_model->d_grn_create_podetail($grn_guid);
                $this->greceive_model->d_grn_create_posum($grn_guid);

                redirect('greceive_controller/po_list');

        }
        else
        {
            redirect('main_controller');
        }


    }

    public function po_batch()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $grn_guid = $_REQUEST['grn_guid'];
            $po_no = $_REQUEST['po_no'];
            $sname = $_REQUEST['sname'];
            $sessiondata = array(
                'grn_guid' => $grn_guid,
                'po_no' => $po_no,
                'sname' => $sname
                );
            $this->session->set_userdata($sessiondata);

            $_SESSION['grn_by_weight'] = $this->db->query('SELECT grn_by_weight from backend.xsetup')->row('grn_by_weight');

            if($_SESSION['grn_by_weight'] == '0')
            {
                
                redirect('greceive_controller/batch_check_pay_by_invoice');
            };

            
            $data['result'] = $this->greceive_model->po_batch($grn_guid);
            $data = array(
                'result' => $this->greceive_model->po_batch($grn_guid),
                'grn_id' => $this->db->query("SELECT grn_id FROM backend_warehouse.d_grn WHERE grn_guid = '$grn_guid' ")->row('grn_id'),
                'postButton' => $this->db->query("SELECT grn_by_weight_direct_post_grn FROM backend.xsetup")->row('grn_by_weight_direct_post_grn'),
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/po_batch', $data, $sessiondata);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/po_batch', $data, $sessiondata);
                    $this->load->view('footer');
                }    

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function barcode_scan()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            if(isset($_REQUEST['by_batch']))
            {
                $_SESSION['method'] = 'by_batch';
            };

            if(isset($_REQUEST['by_qty']))
            {
                $_SESSION['method'] = 'by_qty';
            };
            
            $data = array(

                'by_batch' => $this->db->query("SELECT decode_receiving_barcode FROM backend.xsetup")->row('decode_receiving_barcode'),
            );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/barcode_scan' , $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/barcode_scan', $data);
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function barcode_scan_result()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $grn_guid = $_SESSION['grn_guid'];
            if(isset($_REQUEST['exist_barcode']))
            {
                $barcode = $_REQUEST['exist_barcode'];
            }
            else
            {
                $barcode = $this->input->post('barcode');
            }
            $sessiondata = array(
                'barcode' => $barcode
                );
            $this->session->set_userdata($sessiondata);

            // $xsetup = $this->db->query("SELECT decode_receiving_barcode FROM backend.xsetup")->row('decode_receiving_barcode');
            // if($xsetup <> 0)
            // {
            //     $barcode = $this->main_model->decode_barcode_receiving($barcode);
            //     //echo $this->db->last_query();die;
            // }
            // else
            // {
            //     $barcode = $this->input->post('barcode');
            // }
            
            $result = $this->greceive_model->barcode_scan_result($barcode);
            //echo $this->db->last_query();die;
            $itemlink = $result->row('itemlink');

            if($result->num_rows() == 0)
            {
                $barcode = $this->main_model->decode_barcode_general($barcode);
                if($this->input->post('barcode') == $barcode)
                {

                    $this->session->set_flashdata('message', 'Barcode Not Found : '.$barcode);
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/greceive/barcode_not_found');
                    }
                    else
                    {
                        $this->load->view('header');
                        $this->load->view('greceive/barcode_not_found');
                        $this->load->view('footer');
                    }    
                }
                else
                {

                    $_SESSION['method'] = 'by_batch';
                    redirect('greceive_controller/barcode_scan_result?exist_barcode='.$barcode);
                }
            }
            else
            {
                $_SESSION['bardesc'] = addslashes($result->row('bardesc'));
                $_SESSION['itemcode'] = $result->row('itemcode');
                $_SESSION['itemlink'] = $result->row('itemlink');
                $_SESSION['packsize'] = $result->row('packsize');

                $query = $this->db->query("SELECT * from backend_warehouse.d_grn_posum 
                    where grn_guid='$grn_guid' and itemlink = '$itemlink' ORDER by grn_diff DESC ");
                if($query->num_rows() == 0)
                {
                    $this->session->set_flashdata('message', 'Item code: '.$result->row('itemcode'). '<br> Not Exist in PO No :'.$_SESSION['po_no'] );
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/greceive/item_not_in_po');
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('greceive/item_not_in_po');
                            $this->load->view('footer');
                        }    
                    
                    // redirect('greceive_controller/item_not_in_po');
                }
                else
                {
                    $_SESSION['itemcode'] = $query->row('itemcode');
                    $_SESSION['itemlink'] = $query->row('itemlink');
                    $_SESSION['packsize'] = $query->row('packsize');

                    if($query->row('grn_diff') <=0 )
                    {
                        $this->session->set_flashdata('message', 'PO BALANCE IS = ' .$query->row('grn_diff'). "<br>Unable To Scan : " .$query->row('description'));
                        redirect('greceive_controller/barcode_scan');
                    }
                    else
                    {
                        redirect('greceive_controller/have_focitem?itemcode='.$query->row('itemcode'));
                    }
                }

            }
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function have_focitem()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $itemcode = $_REQUEST['itemcode'];
            $query = $this->db->query("SELECT itemcode,itemlink,description,packsize from backend.itemmaster where itemcode='$itemcode' ");
            
            $query2 = $this->db->query("SELECT itemcode,itemlink,description,packsize,foc_qty,po_qty,posum_guid from backend_warehouse.d_grn_posum where grn_guid='".$_SESSION['grn_guid']."' and itemlink='".$query->row('itemlink')."' order by po_qty desc");

            if($query2->num_rows() == 1)
            {
                redirect('greceive_controller/have_itemlink?posum_guid='.$query2->row('posum_guid')."&itemlink=".$query->row('itemlink'));
            }
            else
            {
/*                $this->session->set_flashdata('message', 'Something went wrong: '.$itemcode."<br>Please contact staff.");
                redirect('greceive_controller/barcode_scan');*/
            redirect('greceive_controller/have_itemlink?posum_guid='.$query2->row('posum_guid')."&itemlink=".$query->row('itemlink'));
            }

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function have_itemlink()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $posum_guid = $_REQUEST['posum_guid'];
            $itemlink = $_REQUEST['itemlink'];

            // $this->greceive_model->have_itemlink($posum_guid);

            $query = $this->db->query("SELECT itemcode,itemlink,description,packsize,po_qty,foc_qty,po_bal,grn_diff,grn_by_weight_hide_po_info from backend_warehouse.d_grn_posum a join backend.xsetup b where posum_guid='$posum_guid'");

            $_SESSION['po_itemlink'] = $query->row('itemlink');
            $_SESSION['po_itemcode'] = $query->row('itemcode');
            $_SESSION['po_description'] = addslashes($query->row('description'));
            $_SESSION['po_packsize'] = $query->row('packsize');

            $query2 = $this->db->query("SELECT itemcode,itemlink,description,packsize from backend.itemmaster where ItemLink='$itemlink' order by packsize");
            // echo $_SESSION['itemcode'];die;
            $check_itemcode = $this->db->query("SELECT * FROM itembarcode a INNER JOIN itemmaster b ON b.`Itemcode` = a.`Itemcode` WHERE a.`Barcode` = '".$_SESSION['barcode']."' ")->row('Itemcode');
            $check_match_po = $this->db->query("SELECT a.*
FROM backend.itemmaster a INNER JOIN backend_warehouse.d_grn_posum b ON a.`Itemcode` = b.`itemcode` 
WHERE a.ItemLink='$itemlink' AND b.itemcode = '$check_itemcode' ORDER BY packsize;");

            //echo $this->db->last_query();die;

            $data = array(
                'query_heading' => $query,
                'query_item' => $query2,
                'po_itemcode' => $query->row('itemcode'),
                'itemcode' => $query2->row('itemcode'),
                );
            $sessiondata = array(
                'posum_guid' => $_REQUEST['posum_guid'],
                'po_packsize' => $query->row('packsize')
                );
            $this->session->set_userdata($sessiondata);

            if($check_match_po->num_rows() > 0)
            {
                redirect('greceive_controller/item_entry_add?scan_itemcode='.$query2->row('itemcode'));
            };

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/have_itemlink', $data, $sessiondata);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/have_itemlink', $data, $sessiondata);
                    $this->load->view('footer');
                }    

        }
        else
        {
            redirect('main_controller');
        }
    }


    public function po_print()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            if ($_REQUEST['print_type']=='batch_only')
            {
                $batch_guid = $_REQUEST['batch_guid'];
                $grn_guid = $_REQUEST['grn_guid'];

                $query = $this->db->query("SELECT batch_id from backend_warehouse.d_grn_batch where batch_guid= '$batch_guid' ");
                $batch_id = $query->row('batch_id');

                $this->greceive_model->po_print_batch_only($batch_guid);
                $this->session->set_flashdata('message', 'Printing Pallet ID : '.$batch_id);
                // redirect('greceive_controller/batch_entry?batch_guid='.$batch_guid);
                redirect('greceive_controller/po_batch?grn_guid='.$_SESSION['grn_guid']."&po_no=".$_SESSION['po_no']."&sname=".$_SESSION['sname']);
                // redirect('greceive_controller/po_batch?grn_guid='.$grn_guid);
            };

            if ($_REQUEST['print_type']=='batch_list')
            {
                $grn_guid = $_REQUEST['grn_guid'];

                $query = $this->db->query("SELECT grn_id from backend_warehouse.d_grn where grn_guid= '$grn_guid'");
                $grn_id = $query->row('grn_id');

                $this->greceive_model->po_print_batch_list($grn_guid);
                $this->session->set_flashdata('message', 'Printing GRDA List : '.$grn_id);
                redirect('greceive_controller/po_batch?grn_guid='.$_SESSION['grn_guid']."&po_no=".$_SESSION['po_no']."&sname=".$_SESSION['sname']);
                    // redirect('greceive_controller/po_batch?grn_guid='.$grn_guid);
            };

            if ($_REQUEST['print_type']=='batch_list_dn')
            {
                $grn_guid = $_REQUEST['grn_guid'];

                $query = $this->db->query("SELECT grn_id from backend_warehouse.d_grn where grn_guid= '$grn_guid'");
                $grn_id = $query->row('grn_id');

                $this->greceive_model->po_print_batch_list_dn($grn_guid);
                $this->session->set_flashdata('message', 'Printing GRN DN List : '.$grn_id);
                redirect('greceive_controller/po_batch?grn_guid='.$_SESSION['grn_guid']."&po_no=".$_SESSION['po_no']."&sname=".$_SESSION['sname']);
                    // redirect('greceive_controller/po_batch?grn_guid='.$grn_guid);
            };
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function po_post_grn()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/po_post_grn');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/po_post_grn');
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function po_post_grn_scan()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            if(isset($_REQUEST['get_refno']))
            {
                $grn_id = $_REQUEST['get_refno'];
            }
            else
            {
                $grn_id = $this->input->post('grn_id');
            }
            

            $result = $this->greceive_model->po_post_grn_scan($grn_id);
            if($result->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Transaction Ref No not found : '.$grn_id);
                redirect('greceive_controller/po_post_grn');
            }
            else
            {
                $grn_guid = $result->row('grn_guid');

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                {
                    $this->session->set_flashdata('message', 'Post this transaction:sasasas '.$grn_id."<br><br><a href='general_post?post_type=grn_rec&grn_guid=".$grn_guid.'&get_refno='.$grn_id."' class ='btn btn-primary btn-xs'>POST</a>");
                    redirect('greceive_controller/po_post_grn');
                }
                else
                {
                    $this->session->set_flashdata('message', 'Post this transaction: '.$grn_id."<br><br><a href='general_post?post_type=grn_rec&grn_guid=".$grn_guid.'&get_refno='.$grn_id."'><button class='btn btn-primary btn-xs' >POST</button></a>");
                    redirect('greceive_controller/po_post_grn');
                }

            }
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function general_post()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $grn_guid = $_REQUEST['grn_guid'];
            $grn_id = $_REQUEST['get_refno'];

            redirect('main_controller/general_post?post_type=grn_rec&grn_guid='.$grn_guid.'&get_refno='.$grn_id);

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function batch_check_pay_by_invoice()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $grn_guid = $_SESSION['grn_guid'];

            $query = $this->db->query("SELECT grn_id 
                          FROM backend_warehouse.d_grn WHERE grn_guid='$grn_guid'");
            $grn_id = $query->row('grn_id');

            $_SESSION['grn_id'] = $grn_id;

            $query = $this->db->query("SELECT grn_by_weight FROM backend_warehouse.set_parameter");
            $grn_by_weight = $query->row('grn_by_weight');

            if($grn_by_weight == 0)
            {
                $query = $this->db->query("SELECT count(*) as rec_count FROM backend_warehouse.d_grn_batch where grn_guid='$grn_guid'");
                $rec_count = $query->row('rec_count');
                
                if($rec_count == 0)
                {
                    $query = $this->db->query("SELECT method_name FROM backend_warehouse.set_move_method ORDER BY method_name");
                    $method_name = $query->row('method_name');

                    $query1 = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS batch_guid, IF(MAX(batch_id) IS NULL,0,MAX(batch_id))+1 AS MaxBatch_Id FROM backend_warehouse.d_grn_batch WHERE grn_guid ='$grn_guid'");
                    $MaxBatch_Id = $query1->row('MaxBatch_Id');
                    $batch_guid = $query1->row('batch_guid');

                    $this->greceive_model->delete_data($batch_guid);

                    $data = array(
                        'batch_guid' => $batch_guid,
                        'grn_guid' => $grn_guid,
                        'loc_group' => $_SESSION['loc_group'],
                        'trans_type' => 'GRN_WEIGHT',
                        'location' => $_SESSION['location'],
                        'batch_id' => $MaxBatch_Id,
                        'goods_weight' => '0',
                        'pallet_weight' => '0',
                        'goods_pallet_weight' => '0',
                        'goods_pallet_variance' => '0',
                        'batch_barcode' => $grn_id.sprintf("%02d", $MaxBatch_Id),
                        'method_name' => $method_name,
                        'Stock' => '1'
                        );
                    $this->greceive_model->insert_data($data);
                    $this->greceive_model->d_grn_create_batch($batch_guid, $method_name);
                    $this->greceive_model->d_grn_recal_batch_variance_before($batch_guid);
                    redirect('greceive_controller/batch_entry?batch_guid='.$batch_guid);

                }
                else
                {
                   redirect('greceive_controller/batch_add');
                }
            }
            else
            {
                redirect('greceive_controller/batch_add');
            }

        }
        else
        {
            redirect('main_controller');
        }
    }


    public function batch_add()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $grn_guid = $_SESSION['grn_guid'];

            $query = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS batch_guid, IF(MAX(batch_id) IS NULL,0,MAX(batch_id))+1 AS MaxBatch_Id FROM backend_warehouse.d_grn_batch WHERE grn_guid ='$grn_guid'");
            $MaxBatch_Id = $query->row('MaxBatch_Id');
            $batch_guid = $query->row('batch_guid');

            $method_name = $this->db->query("SELECT method_name FROM backend_warehouse.set_move_method ORDER BY method_name");
            
            $data =array(
                'MaxBatch_Id' => $MaxBatch_Id,
                'method_name' => $method_name,
                );

            if($MaxBatch_Id == 1)
            {
                redirect('greceive_controller/batch_add_save?method_name=Pallet');
            };

            if($MaxBatch_Id > 1 && $_SESSION['grn_by_weight'] == '0')
            {
                $batch_guid = $this->greceive_model->po_batch($grn_guid)->row('batch_guid');
                redirect('greceive_controller/batch_entry?batch_guid='.$batch_guid);
                // redirect('greceive_controller/barcode_scan');
            };

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/batch_add', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/batch_add', $data);
                    $this->load->view('footer');
                }    

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function batch_add_save()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            if($this->input->post('method_name') == null)
            {
                $method_name = $_REQUEST['method_name'];
            }
            else
            {
                $method_name = $this->input->post('method_name');
            }
            
            $grn_guid = $_SESSION['grn_guid'];

            $query = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS batch_guid, IF(MAX(batch_id) IS NULL,0,MAX(batch_id))+1 AS MaxBatch_Id FROM backend_warehouse.d_grn_batch WHERE grn_guid ='$grn_guid'");
            $MaxBatch_Id = $query->row('MaxBatch_Id');
            $batch_guid = $query->row('batch_guid');

            // $method_name = $this->db->query("SELECT method_name FROM backend_warehouse.set_move_method ORDER BY method_name");
            // $method_name = $query1->result();

            $query2 = $this->db->query("SELECT grn_id FROM backend_warehouse.d_grn WHERE grn_guid= '$grn_guid' ");
            $grn_id = $query2->row('grn_id');

            $this->greceive_model->delete_data($batch_guid);

            $data = array(
                'batch_guid' => $batch_guid,
                'grn_guid' => $grn_guid,
                'loc_group' => $_SESSION['loc_group'],
                'trans_type' => 'GRN_WEIGHT',
                'location' => $_SESSION['location'],
                'batch_id' => $MaxBatch_Id,
                'goods_weight' => '0',
                'pallet_weight' => '0',
                'goods_pallet_weight' => '0',
                'goods_pallet_variance' => '0',
                'batch_barcode' => $grn_id.sprintf("%02d", $MaxBatch_Id),
                'method_name' => $method_name,
                'Stock' => '1'
                );
            $this->greceive_model->insert_data($data);
            $this->greceive_model->d_grn_create_batch($batch_guid, $method_name);
            $this->greceive_model->d_grn_recal_batch_variance_before($batch_guid);
                redirect('greceive_controller/po_batch?grn_guid='.$_SESSION['grn_guid']."&po_no=".$_SESSION['po_no']."&sname=".$_SESSION['sname']);
                // redirect('greceive_controller/po_batch?grn_guid='.$grn_guid."&po_no=".$_SESSION['po_no']);
            
            
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function batch_weight()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $_SESSION['batch_guid'] = $_REQUEST['batch_guid'];  
            //Get Pallet ID
            $grn_batch = $this->db->query('SELECT * from backend_warehouse.d_grn_batch where batch_guid = "'.$_REQUEST['batch_guid'].'"');

            //Query Batch Method
            $grn_method = $this->db->query('SELECT * from backend_warehouse.d_grn_method where batch_guid = "'.$_REQUEST['batch_guid'].'"');

            $MethodCode = '';
            $UOM = '';
            $StockValueShow = false;
            $MultiplyShow = false;
            $Multiply = 1;
            $guid = '';

            $getcount = 0;
            if($grn_method->num_rows() != 0)
            {
                $getcount = $getcount+1;

                if($getcount == 1)
                {

                    $MethodCode = $grn_method->row('method_code');
                    $StockValue = $grn_method->row('StockValue');
                    $StockValueShow = true;
                    $UOM = $grn_method->row('UOM');

                    if ($grn_method->row('MultiplyType')!='Qty')
                    {
                        $MultiplyShow = true;
                        $Multiply = $grn_method->row('MultiplyQty');
                        $guid = $grn_method->row('method_guid');
                    };
                };
            

                if ($getcount==2)
                {
                    $MethodCode = $grn_method->row('method_code');
                    $StockValue = $grn_method->row('StockValue');
                    $StockValueShow = true;
                    $UOM = $grn_method->row('UOM');
                    $guid = $grn_method->row('method_guid');

                    if ($grn_method->row('MultiplyType')!='Qty')
                    {
                        $MultiplyShow = true;
                        $Multiply = $grn_method->row('MultiplyQty');
                    };

                };

                if ($getcount==3)
                {
                    $MethodCode = $grn_method->row('method_code');
                    $StockValue = $grn_method->row('StockValue');
                    $StockValueShow = true;
                    $UOM = $grn_method->row('UOM');
                    $guid = $grn_method->row('method_guid');

                    if ($grn_method->row('MultiplyType')!='Qty')
                    {
                        $MultiplyShow = true;
                        $Multiply = $grn_method->row('MultiplyQty');
                    };

                };

                if ($getcount==4)
                {
                    $MethodCode = $grn_method->row('method_code');
                    $StockValue = $grn_method->row('StockValue');
                    $StockValueShow = true;
                    $UOM = $grn_method->row('UOM');
                    $guid = $grn_method->row('method_guid');

                    if ($grn_method->row('MultiplyType')!='Qty')
                    {
                        $MultiplyShow = true;
                        $Multiply = $grn_method->row('MultiplyQty');
                    };
                };

                if ($getcount==5)
                {
                    $MethodCode = $grn_method->row('method_code');
                    $StockValue = $grn_method->row('StockValue');
                    $StockValueShow = true;
                    $UOM = $grn_method->row('UOM');
                    $guid = $grn_method->row('method_guid');

                    if ($grn_method->row('MultiplyType')!='Qty')
                    {
                        $MultiplyShow = true;
                        $Multiply = $grn_method->row('MultiplyQty');
                    };
                };

            };

            $data = array(
                'Method' => $grn_batch->row('method_name'),
                'PalletID' => $grn_batch->row('batch_id'),
                'MethodCode' => $MethodCode,
                'StockValue' => $StockValue ,
                'UOM' => $UOM,
                'Multiply' => $Multiply,
                'StockValueShow' => $StockValueShow,
                'MultiplyShow' => $MultiplyShow,
                'guid' => $guid
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/batch_weight', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/batch_weight', $data);
                    $this->load->view('footer');
                }    
            
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function batch_weight_save()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $method_guid = $this->input->post('guid');
            $batch_guid = $_SESSION['batch_guid'];
            $data = array(

                'StockValue' => $this->input->post('StockValue'), 
                'MultiplyQty' => $this->input->post('Multiply'), 
                );
            
            $this->greceive_model->batch_weight_save($data, $method_guid);
            
            //sum item weight and qty by batch_guid
            $this->greceive_model->d_grn_goods_weight_by_batchguid($batch_guid);
            //update method weight
            $this->greceive_model->d_grn_method_weight_by_batchguid($batch_guid);
            //update pallet weight
            $this->greceive_model->d_grn_pallet_weight_by_batchguid($batch_guid);
            //recal variance
            $this->greceive_model->d_grn_recal_batch_variance($batch_guid);
            
            redirect('greceive_controller/po_batch?grn_guid='.$_SESSION['grn_guid']."&po_no=".$_SESSION['po_no']."&sname=".$_SESSION['sname']);
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function batch_gross_weight()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $batch_guid = $_REQUEST['batch_guid'];
            $data['result'] = $this->greceive_model->batch_gross_weight($batch_guid);
            $sessiondata = array(
                'batch_guid' => $batch_guid);
            $this->session->set_userdata($sessiondata);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/batch_gross_weight', $data, $sessiondata);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/batch_gross_weight', $data, $sessiondata);
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function goods_pallet_weight_update()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $goods_pallet_weight = $this->input->post('goods_pallet_weight');

            $this->greceive_model->goods_pallet_weight_update($goods_pallet_weight);
            $this->greceive_model->d_grn_recal_batch_variance();
            $this->session->set_flashdata('message', 'Succesfully add. ');

            // redirect('greceive_controller/po_batch?grn_guid='.$_SESSION['grn_guid']."&po_no=".$_SESSION['po_no']);
            redirect('greceive_controller/po_batch?grn_guid='.$_SESSION['grn_guid']."&po_no=".$_SESSION['po_no']."&sname=".$_SESSION['sname']);
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function batch_entry()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $batch_guid = $_REQUEST['batch_guid'];
            $sessiondata = array(
                'batch_guid' => $batch_guid);
            $this->session->set_userdata($sessiondata);

            if($_SESSION['grn_by_weight'] == '0')// others client
            {
                $data = array(
                    'batch' => $this->greceive_model->batch_data($batch_guid),
                    'item' => $this->greceive_model->batch_item_data($batch_guid),
                    'backbutton' => site_url('greceive_controller/po_list'),
                    // 'grda_button' => $this->greceive_model->grda_button($batch_guid)->row('iconshow'),
                    // close by faizul 27/10/2017
                    'grda_button' => '-1',
                    'postButton' => $this->db->query("SELECT grn_by_weight_direct_post_grn FROM backend.xsetup")->row('grn_by_weight_direct_post_grn'),
                    'grn_id' => $this->db->query("SELECT grn_id FROM backend_warehouse.d_grn 
                        WHERE grn_guid = '".$_SESSION['grn_guid']."' ")->row('grn_id'),
                );
            }
            else// midas client
            {
                $data = array(
                    'batch' => $this->greceive_model->batch_data($batch_guid),
                    'item' => $this->greceive_model->batch_item_data($batch_guid),
                    'backbutton' => site_url('greceive_controller/po_batch'),
                    // 'grda_button' => '0',// close by faizul 27/10/2017
                    'grda_button' => $this->greceive_model->grda_button($batch_guid)->row('iconshow'), 
                    'postButton' => '0',
                    'grn_id' => $this->db->query("SELECT grn_id FROM backend_warehouse.d_grn 
                        WHERE grn_guid = '".$_SESSION['grn_guid']."' ")->row('grn_id'),
                );
                // $this->greceive_model->grda_button($batch_guid)->row('iconshow');
                // echo $this->db->last_query();die; 
            }
            

             $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/greceive/batch_entry', $data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('greceive/batch_entry', $data);
                        $this->load->view('footer');
                    }    
        
            
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function item_entry_flow()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $item_guid = $_REQUEST['item_guid'];

            $query = $this->db->query("SELECT * from backend_warehouse.d_grn_batch_item where item_guid='$item_guid'");
                // $posum_guid = $query->row('posum_guid');

            if ($query->num_rows() > 0)
            {
                if ($query->row('rec_type') == 'PO')
                {
                    redirect('greceive_controller/item_entry_edit?edit_item&item_guid='.$query->row('item_guid').'&batch_guid='.$query->row('batch_guid').'&posum_guid='.$query->row('posum_guid'));
                };
                
                if ($query->row('rec_type')=='RTV')
                {
                    if ($query->row('scan_itemcode') == '')
                    {
                        redirect('greceive_controller/entry_as_RTV?item_guid='.$query->row('item_guid'));
                    }
                    else
                    {
                        redirect('greceive_controller/entry_as_RTV_or_FOC?item_guid='.$query->row('item_guid').'&rec_type=RTV');
                    }
                };
                

                if ($query->row('rec_type')=='FOC')
                {
                    if ($query->row('scan_itemcode') == '')
                    {
                        redirect('greceive_controller/entry_as_RTV?item_guid='.$query->row('item_guid'));
                    }
                    else
                    {
                        redirect('greceive_controller/entry_as_RTV_or_FOC?item_guid='.$query->row('item_guid').'&rec_type=FOC');
                    }
                };
            }
            else
            {
                redirect('greceive_controller/scan_barcode');
            }
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function item_entry_edit()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            if(isset($_REQUEST['edit_item']))
            {
                $_SESSION['edit_item'] = 1;
            }
            else
            {
                $_SESSION['edit_item'] = 0;
            }

            if($_SESSION['grn_by_weight'] == 0)
            {
                $hide_weight = 'hidden';
            }
            else
            {
                $hide_weight = '';
            }

            $item_guid = $_REQUEST['item_guid'];

            $batch_item = $this->db->query("SELECT * from backend_warehouse.d_grn_batch_item where item_guid='$item_guid'");

            if ($batch_item->row('expiry_date') == '')
            {
                $getDate = date('Y-m-d');
                $getDate = strtotime(date("Y-m-d", strtotime($getDate)) . " +365 days");
                $expiry_date = date('Y-m-d',$getDate);
            }
            else
            {
               $expiry_date = $batch_item->row('expiry_date');
            };

            if($batch_item->row('WeightTraceQty') =='1')
            {
                $WeightTraceQtyUOM = $batch_item->row('WeightTraceQtyUOM');
                $WeightTraceQtyCount = $batch_item->row('WeightTraceQtyCount');
            }
            else
            {
                $WeightTraceQtyUOM = '';
                $WeightTraceQtyCount = '0';
            }

            $grn_posum = $this->db->query("SELECT * from backend_warehouse.d_grn_posum where posum_guid='".$batch_item->row('posum_guid')."'");

            $foc_qty = '0';
            if ($grn_posum->row('foc_qty') == '0')
            {
                $balance_qty = $grn_posum->row('grn_diff')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize')+$batch_item->row('qty_rec');
                 //if bal > po_bal, got foc change to po_bal qty
                if ($balance_qty > $grn_posum->row('po_bal')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize'))
                {
                    $balance_qty = $grn_posum->row('po_bal')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize');
                };

            }
            else
            {
                $balance_qty = $grn_posum->row('grn_diff')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize')+$batch_item->row('qty_rec');

                if (($balance_qty - $grn_posum->row('foc_qty')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize'))>0)
                {
                    $balance_qty = $balance_qty - $grn_posum->row('foc_qty')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize');
                    
                    $foc_qty = $grn_posum->row('foc_qty')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize');
                };

            };
            
            $data = array(
                'heading' => 'edit',
                'line_no' => $batch_item->row('lineno'),

                'description' => addslashes($batch_item->row('scan_description')),
                'do_qty' => $batch_item->row('qty_do'),
                'received_qty' => $batch_item->row('qty_rec'),
                'scan_weight' => $batch_item->row('scan_weight'),
                'expiry_date' => $expiry_date,
                'trace_qty' => $batch_item->row('WeightTraceQtyCount'),
                'check_trace_qty' => $batch_item->row('WeightTraceQty'),

                'order_qty' => $batch_item->row('po_packsize')/$batch_item->row('scan_packsize')*($grn_posum->row('po_qty')+$grn_posum->row('foc_qty')),
                'foc_qty' => $foc_qty,
                'balance_qty' => $balance_qty,

                'set_master_code' => $this->db->query("SELECT * FROM backend.set_master_code WHERE trans_type='GRN_REASON' ORDER BY code_desc"),

                'WeightTraceQty' => $batch_item->row('WeightTraceQty'),
                'WeightTraceQtyUOM' => $WeightTraceQtyUOM,
                'WeightTraceQtyCount' => $WeightTraceQtyCount,

                'PurTolerance_Std_plus' => $batch_item->row('PurTolerance_Std_plus'),
                'PurTolerance_Std_Minus' => $batch_item->row('PurTolerance_Std_Minus'),
                'reason' => $batch_item->row('reason'),
                'hide_weight' => $hide_weight,

                );
            $sessiondata =array(
                'item_guid' => $_REQUEST['item_guid'],
                'batch_guid' => $_REQUEST['batch_guid'],
                'posum_guid' => $_REQUEST['posum_guid'],
                );
            $this->session->set_userdata($sessiondata);

            if(isset($_REQUEST['item_c']))
            {
                $get_qty_to_delete = $this->db->query("SELECT * FROM backend_warehouse.`d_grn_batch_item_c` WHERE item_guid_c = '".$_REQUEST['item_guid_c']."';");

                if ($batch_item->row('expiry_date') == '')
                {
                    $getDate = date('Y-m-d');
                    $getDate = strtotime(date("Y-m-d", strtotime($getDate)) . " +365 days");
                    $expiry_date = date('Y-m-d',$getDate);
                }
                else
                {
                   $expiry_date = $batch_item->row('expiry_date');
                };

                $data= array(
                    'scan_weight'=> $batch_item->row('scan_weight'),
                    'qty_do'=> $batch_item->row('qty_do'),
                    'qty_rec'=> $batch_item->row('qty_rec')-$get_qty_to_delete->row('qty_rec'),
                    'scan_weight_total'=> $batch_item->row('qty_rec')-$get_qty_to_delete->row('qty_rec')*$batch_item->row('scan_weight'),

                    'qty_diff_is_foc'=> '0',
                    'qty_diff'=> ($batch_item->row('qty_rec')-$get_qty_to_delete->row('qty_rec'))-($balance_qty),

                    'WeightTraceQty'=> $batch_item->row('WeightTraceQty'),
                    'WeightTraceQtyUOM'=> $WeightTraceQtyUOM,
                    'WeightTraceQtyCount'=> $WeightTraceQtyCount,
                    'PurTolerance_Std_plus'=> $batch_item->row('PurTolerance_Std_plus'),
                    'PurTolerance_Std_Minus'=> $batch_item->row('PurTolerance_Std_Minus'),
                    'reason'=> $batch_item->row('reason'),

                    'updated_at'=> $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                    'updated_by'=> $_SESSION['username'],

                    'expiry_date'=> $expiry_date,
                    'rec_type'=> 'PO',
                    'hide_weight' => $hide_weight,
                );

                $posum_guid = $_SESSION['posum_guid'];
                $batch_guid = $_SESSION['batch_guid'];

                $this->greceive_model->item_entry_update($data);
                //sum po rec qty
                $this->greceive_model->d_grn_update_porec($posum_guid);
                //Sum goods weight
                $this->greceive_model->d_grn_goods_weight_by_batchguid($batch_guid);
                // echo $this->db->last_query();die;
                //Cal method weight
                $this->greceive_model->d_grn_method_weight_by_batchguid($batch_guid);
                //Sum pallet weight
                $this->greceive_model->d_grn_pallet_weight_by_batchguid($batch_guid);
                //Cal Variance
                $this->greceive_model->d_grn_recal_batch_variance($batch_guid);

                redirect('greceive_controller/batch_itemDelete_c?item_guid_c='.$_REQUEST['item_guid_c']);
            }

            if(isset($_SESSION['method']) && $_SESSION['method'] == 'by_batch' && $_SESSION['edit_item'] == 0)
            {
                // $this->session->set_userdata($data);
                // redirect('greceive_controller/item_entry_update?by_batch&item_guid='.$_SESSION['item_guid'].'&batch_guid='.$_SESSION['batch_guid'].'&posum_guid'.$_SESSION['posum_guid']);
                if ($batch_item->row('expiry_date') == '')
                {
                    $getDate = date('Y-m-d');
                    $getDate = strtotime(date("Y-m-d", strtotime($getDate)) . " +365 days");
                    $expiry_date = date('Y-m-d',$getDate);
                }
                else
                {
                   $expiry_date = $batch_item->row('expiry_date');
                };

                $data= array(
                    'scan_weight'=> $batch_item->row('scan_weight'),
                    'qty_do'=> $batch_item->row('qty_do'),
                    'qty_rec'=> $batch_item->row('qty_rec')+$_SESSION['decode_qty'],
                    'scan_weight_total'=> $batch_item->row('qty_rec')*$batch_item->row('scan_weight'),

                    'qty_diff_is_foc'=> '0',
                    'qty_diff'=> ($batch_item->row('qty_rec')+$_SESSION['decode_qty'])-($balance_qty),

                    'WeightTraceQty'=> $batch_item->row('WeightTraceQty'),
                    'WeightTraceQtyUOM'=> $WeightTraceQtyUOM,
                    'WeightTraceQtyCount'=> $WeightTraceQtyCount,
                    'PurTolerance_Std_plus'=> $batch_item->row('PurTolerance_Std_plus'),
                    'PurTolerance_Std_Minus'=> $batch_item->row('PurTolerance_Std_Minus'),
                    'reason'=> $batch_item->row('reason'),

                    'updated_at'=> $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                    'updated_by'=> $_SESSION['username'],

                    'expiry_date'=> $expiry_date,
                    'rec_type'=> 'PO',
                    'hide_weight' => $hide_weight,
                );

                $data_insert = array(

                    'item_guid' => $_SESSION['item_guid'] ,
                    'batch_guid' => $_SESSION['batch_guid'] ,
                    'item_guid_c' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid') ,
                    'lineno' => $this->db->query("SELECT COUNT(*)+1 AS reccount FROM backend_warehouse.d_grn_batch_item_c WHERE item_guid = '".$_SESSION['guid']."' ")->row('reccount'),
                    'scan_itemcode' => $_SESSION['scan_itemcode'],
                    'scan_description' => addslashes($_SESSION['scan_description']),
                    'scan_itemlink' => $_SESSION['scan_itemlink'],
                    'scan_packsize' => $_SESSION['scan_packsize'],
                    'scan_barcode' => $_SESSION['barcode'],
                    'scan_as_itemcode' => '0',

                    'scan_weight' => $batch_item->row('scan_weight'),
                    'qty_do' => $batch_item->row('qty_do'),
                    'qty_rec' => $_SESSION['decode_qty'],
                    'qty_diff_is_foc' => '0',
                    'qty_diff' => ($batch_item->row('qty_rec')+$_SESSION['decode_qty'])-($balance_qty),
                    'scan_weight_total' => $batch_item->row('qty_rec')*$batch_item->row('scan_weight'),
                    'posum_guid' => $_SESSION['posum_guid'],
                    
                    'created_at' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                    'created_by' => $_SESSION['username'],
                    'updated_at'=> $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                    'updated_by'=> $_SESSION['username'],
                );

                $posum_guid = $_SESSION['posum_guid'];
                $batch_guid = $_SESSION['batch_guid'];
                $this->greceive_model->item_entry_insert_c($data_insert);

                $this->greceive_model->item_entry_update($data);
                //sum po rec qty
                $this->greceive_model->d_grn_update_porec($posum_guid);
                //Sum goods weight
                $this->greceive_model->d_grn_goods_weight_by_batchguid($batch_guid);
                // echo $this->db->last_query();die;
                //Cal method weight
                $this->greceive_model->d_grn_method_weight_by_batchguid($batch_guid);
                //Sum pallet weight
                $this->greceive_model->d_grn_pallet_weight_by_batchguid($batch_guid);
                //Cal Variance
                $this->greceive_model->d_grn_recal_batch_variance($batch_guid);

                redirect('greceive_controller/convert_excess_to_foc?item_guid='.$item_guid);
            };

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/item_entry', $data, $sessiondata);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/item_entry', $data, $sessiondata);
                    $this->load->view('footer');
                }    

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function item_entry_update()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $posum_guid = $_SESSION['posum_guid'];
            $batch_guid = $_SESSION['batch_guid'];
            $item_guid = $_SESSION['item_guid'];

            // $posum_guid = $_REQUEST['posum_guid'];
            // $batch_guid = $_REQUEST['batch_guid'];
            // $item_guid = $_REQUEST['item_guid'];

            if($this->input->post('rec_qty')-$this->input->post('balance_qty') < 0 && $this->input->post('reason') == '')
            {
                $this->session->set_flashdata('message', '<span class="label label-warning" style="font-size: 14px;">Variance Qty Exist. Please Select Reason. </span>');
                    redirect('greceive_controller/item_entry_edit?item_guid='.$item_guid.'&batch_guid='.$batch_guid.'&posum_guid='.$posum_guid);
            }

            $datetime = $this->db->query("SELECT NOW() AS datetime");

            $batch_item = $this->db->query("SELECT * from backend_warehouse.d_grn_batch_item where item_guid='$item_guid'");
            
            $grn_posum = $this->db->query("SELECT * from backend_warehouse.d_grn_posum where posum_guid='".$batch_item->row('posum_guid')."'");
             
            $foc_qty = '0';
            if ($grn_posum->row('foc_qty') == '0')
            {
                $balance_qty = $grn_posum->row('grn_diff')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize')+$this->input->post('rec_qty');

                $dontknow_this = $grn_posum->row('po_bal')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize');

                echo $grn_posum->row('grn_diff'); echo $batch_item->row('po_packsize'); echo $batch_item->row('scan_packsize'); echo $this->input->post('rec_qty');
                // balance qty
                echo $balance_qty;
                echo $dontknow_this;
                //die;
                //if bal > po_bal, got foc change to po_bal qty
                if ($balance_qty > $grn_posum->row('po_bal')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize'))
                {
                    $balance_qty = $grn_posum->row('po_bal')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize');
                };
            }
            else
            {
                $balance_qty = $grn_posum->row('grn_diff')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize')+$this->input->post('rec_qty');

                if (($balance_qty - $grn_posum->row('foc_qty')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize'))>0)
                {
                    $balance_qty = $balance_qty - $grn_posum->row('foc_qty')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize');
                    
                    $foc_qty = $grn_posum->row('foc_qty')*$batch_item->row('po_packsize')/$batch_item->row('scan_packsize');
                };
            };

            $data= array(
                'scan_weight'=> $this->input->post('weight'),
                'qty_do'=> $this->input->post('do_qty'),
                'qty_rec'=> $this->input->post('rec_qty'),
                'scan_weight_total'=> $this->input->post('rec_qty')*$this->input->post('weight'),

                'qty_diff_is_foc'=> '0',
                'qty_diff'=> ($this->input->post('rec_qty'))-($this->input->post('balance_qty')),

                'WeightTraceQty'=> $this->input->post('WeightTraceQty'),
                'WeightTraceQtyUOM'=> $this->input->post('WeightTraceQtyUOM'),
                'WeightTraceQtyCount'=> $this->input->post('trace_qty'),
                'PurTolerance_Std_plus'=> $this->input->post('PurTolerance_Std_plus'),
                'PurTolerance_Std_Minus'=> $this->input->post('PurTolerance_Std_Minus'),
                'reason'=> $this->input->post('reason'),

                'updated_at'=> $datetime->row('datetime'),
                'updated_by'=> $_SESSION['username'],

                'expiry_date'=> $this->input->post('expiry_date'),
                'rec_type'=> 'PO',
                );
            $this->greceive_model->item_entry_update($data);

            //sum po rec qty
            $this->greceive_model->d_grn_update_porec($posum_guid);

            //Sum goods weight
            $this->greceive_model->d_grn_goods_weight_by_batchguid($batch_guid);
            // echo $this->db->last_query();die;
            //Cal method weight
            $this->greceive_model->d_grn_method_weight_by_batchguid($batch_guid);
            //Sum pallet weight
            $this->greceive_model->d_grn_pallet_weight_by_batchguid($batch_guid);
            //Cal Variance
            $this->greceive_model->d_grn_recal_batch_variance($batch_guid);

            redirect('greceive_controller/convert_excess_to_foc?item_guid='.$item_guid);
        }
        else
        {
            redirect('main_controller');
        }

    }

    public function item_entry_add()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $batch_guid = $_SESSION['batch_guid'];
            //$scan_itemcode = $_REQUEST['scan_itemcode'];
            $_SESSION['scan_itemcode'] = $_REQUEST['scan_itemcode'];

            $getDate = date('Y-m-d');
            $getDate = strtotime(date("Y-m-d", strtotime($getDate)) . " +365 days");
            $expiry_date = date('Y-m-d',$getDate);

            $xsetup = $this->db->query("SELECT
                grn_by_weight_doqty_aspoqty,grn_by_weight_hide_supplier_do_entry,
                grn_by_weight_hide_po_info,grn_by_weight_recbyweight,
                grn_by_weight_recqty_aspoqty FROM backend.xsetup");

            if($xsetup->num_rows() > 0)
            {
                $_SESSION['recbyweight']=$xsetup->row('grn_by_weight_recbyweight');
                $_SESSION['recqty_aspoqty']=$xsetup->row('grn_by_weight_recqty_aspoqty');
                $_SESSION['doqty_aspoqty']=$xsetup->row('grn_by_weight_doqty_aspoqty');
                $_SESSION['hide_supplier_do_entry']=$xsetup->row('grn_by_weight_hide_supplier_do_entry');
            }
            else
            {
                $_SESSION['recbyweight'] = 0;
                $_SESSION['recqty_aspoqty'] = 0;
                $_SESSION['doqty_aspoqty'] = 0;
                $_SESSION['hide_supplier_do_entry'] = 0;
            }

            $batch_item = $this->db->query("SELECT * FROM backend_warehouse.d_grn_batch_item  where batch_guid ='$batch_guid' and scan_itemcode='".$_SESSION['scan_itemcode']."' ");

            if($batch_item->num_rows() > 0)
            {
                redirect('greceive_controller/item_entry_edit?item_guid='.$batch_item->row('item_guid').'&batch_guid='.$batch_item->row('batch_guid').'&posum_guid='.$batch_item->row('posum_guid'));
            };

            $new_record = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid,itemcode,itemlink,description,packsize FROM backend.itemmaster
            WHERE itemcode='".$_SESSION['scan_itemcode']."'");

            $_SESSION['scan_description'] = addslashes($new_record->row('description'));
            $_SESSION['scan_itemlink'] = $new_record->row('itemlink');
            $_SESSION['scan_packsize'] = $new_record->row('packsize');
            $_SESSION['guid']=$new_record->row('guid');

            $grn_posum = $this->db->query("SELECT * from backend_warehouse.d_grn_posum where posum_guid='".$_SESSION['posum_guid']."'");

            $query_line_no = $this->db->query("SELECT COUNT(*)+1 AS reccount FROM backend_warehouse.d_grn_batch_item where batch_guid = '$batch_guid'");
            $_SESSION['line_no'] = $query_line_no->row('reccount');

            if ($_SESSION['recqty_aspoqty'] == 1)
            {
               $received_qty = $_SESSION['po_packsize']/$new_record->row('packsize')*($grn_posum->row('po_qty')+$grn_posum->row('foc_qty'));
            }
            else
            {
               $received_qty = 0;
            };

            if ($_SESSION['doqty_aspoqty'] == 1)
            {
               $do_qty = $_SESSION['po_packsize']/$new_record->row('packsize')*($grn_posum->row('po_qty')+$grn_posum->row('foc_qty'));
            }
            else
            {
               $do_qty = 0;
            };

            if($_SESSION['grn_by_weight'] == 0)
            {
                $hide_weight = 'hidden';
            }
            else
            {
                $hide_weight = '';
            }

            $data = array(
                'heading' => 'add',
                'hide_supplier_do_entry' => $xsetup->row('grn_by_weight_hide_supplier_do_entry'),
                'hide_po_info' => $xsetup->row('grn_by_weight_hide_po_info'),
                'check_trace_qty' => $grn_posum->row('WeightTraceQty'),
                
                'check_recqty_aspoqty' => $_SESSION['recqty_aspoqty'],
                'check_doqty_aspoqty' => $_SESSION['doqty_aspoqty'],
                'check_recbyweight' => $_SESSION['recbyweight'],
                'check_hide_supplier_do_entry' => $_SESSION['hide_supplier_do_entry'],

                'line_no' => $this->db->query("SELECT COUNT(*)+1 AS reccount FROM backend_warehouse.d_grn_batch_item
                 where batch_guid = '$batch_guid' ")->row('reccount'),
                
                'description' => addslashes($new_record->row('description')),
                'do_qty' => $do_qty,
                'received_qty' => $received_qty,

                'scan_weight' => '0',
                'expiry_date' => $expiry_date,
                
                'trace_qty' => $grn_posum->row('WeightTraceQtyCount'),
                
                'order_qty' => $_SESSION['po_packsize']/$new_record->row('packsize')*($grn_posum->row('po_qty')+$grn_posum->row('foc_qty')),
                
                'balance_qty' => $_SESSION['po_packsize']/$new_record->row('packsize')*
                                       ($grn_posum->row('po_bal')-$grn_posum->row('foc_qty')),

                'foc_qty' => $_SESSION['po_packsize']/$new_record->row('packsize')*
                                       $grn_posum->row('foc_qty'),                      

                'set_master_code' => $this->db->query("SELECT * FROM backend.set_master_code WHERE trans_type='GRN_REASON' ORDER BY code_desc"),

                'WeightTraceQty' => $grn_posum->row('WeightTraceQty'),
                'WeightTraceQtyUOM' => $grn_posum->row('WeightTraceQtyUOM'),
                'WeightTraceQtyCount' => $grn_posum->row('WeightTraceQtyCount'),

                'PurTolerance_Std_plus' => $grn_posum->row('PurTolerance_Std_plus'),
                'PurTolerance_Std_Minus' => $grn_posum->row('PurTolerance_Std_Minus'),
                'hide_weight' => $hide_weight,

                );

            if($_SESSION['method'] == 'by_batch')
            {
                $this->session->set_userdata($data);
                redirect('greceive_controller/item_entry_insert?item_guid=');
            };

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/item_entry_add', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/item_entry_add', $data);
                    $this->load->view('footer');
                }    

        }
        else
        {
            redirect('main_controller');
        }
        
        
    }

    public function item_entry_insert()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $posum_guid = $_SESSION['posum_guid'];
            $batch_guid = $_SESSION['batch_guid'];
            $item_guid = $_SESSION['guid'];

            if($_SESSION['method'] == 'by_qty')
            {
                $rec_qty = $this->input->post('rec_qty');
                $balance_qty = $this->input->post('balance_qty');
                $foc_qty = $this->input->post('foc_qty');
                $reason = $this->input->post('reason');
                $weight = $this->input->post('weight');
                $do_qty = $this->input->post('do_qty');
                $WeightTraceQty = $this->input->post('WeightTraceQty');
                $WeightTraceQtyUOM = $this->input->post('WeightTraceQtyUOM');
                $trace_qty = $this->input->post('trace_qty');
                $PurTolerance_Std_plus = $this->input->post('PurTolerance_Std_plus');
                $PurTolerance_Std_Minus = $this->input->post('PurTolerance_Std_Minus');
                $expiry_date = $this->input->post('expiry_date');
            }
            else
            {
                $rec_qty = $_SESSION['decode_qty'];
                $balance_qty = $_SESSION['balance_qty'];
                $foc_qty = $_SESSION['foc_qty'];
                $reason = '-';
                $weight = '0';
                $do_qty = $_SESSION['do_qty'];
                $WeightTraceQty = $_SESSION['WeightTraceQty'];
                $WeightTraceQtyUOM = $_SESSION['WeightTraceQtyUOM'];
                $trace_qty = $_SESSION['trace_qty'];
                $PurTolerance_Std_plus = $_SESSION['PurTolerance_Std_plus'];
                $PurTolerance_Std_Minus = $_SESSION['PurTolerance_Std_Minus'];
                $expiry_date = '';
            }

            if($rec_qty-$balance_qty < 0 && $reason == '')
            {
                $this->session->set_flashdata('message', '<span class="label label-warning" style="font-size: 14px;">Variance Qty Exist. Please Select Reason. </span>');
                    redirect('greceive_controller/item_entry_add?scan_itemcode='.$this->input->post('scan_itemcode'));
            }

            $datetime = $this->db->query("SELECT NOW() AS datetime");

            $data = array(

                'item_guid' => $_SESSION['guid'] ,
                'batch_guid' => $_SESSION['batch_guid'] ,
                'lineno' => $_SESSION['line_no'] ,
                'po_itemcode' => $_SESSION['po_itemcode'],
                'po_description' => addslashes($_SESSION['po_description']),
                'po_itemlink' => $_SESSION['po_itemlink'],
                'po_packsize' => $_SESSION['po_packsize'],
                'scan_itemcode' => $_SESSION['scan_itemcode'],
                'scan_description' => addslashes($_SESSION['scan_description']),
                'scan_itemlink' => $_SESSION['scan_itemlink'],
                'scan_packsize' => $_SESSION['scan_packsize'],
                'scan_barcode' => $_SESSION['barcode'],
                'scan_as_itemcode' => '0',

                'scan_weight' => $weight,
                'qty_do' => $do_qty,
                'qty_rec' => $rec_qty,
                'qty_diff_is_foc' => '0',
                'qty_diff' => ($rec_qty)-($balance_qty+$foc_qty),
                'scan_weight_total' => $rec_qty*$weight,
                'posum_guid' => $_SESSION['posum_guid'],

                'WeightTraceQty' => $WeightTraceQty,
                'WeightTraceQtyUOM' => $WeightTraceQtyUOM,
                'WeightTraceQtyCount' => $trace_qty,
                'PurTolerance_Std_plus' => $PurTolerance_Std_plus,
                'PurTolerance_Std_Minus' => $PurTolerance_Std_Minus,

                'created_at' => $datetime->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at'=> $datetime->row('datetime'),
                'updated_by'=> $_SESSION['username'],

                'expiry_date' => $expiry_date,
                'reason' => $reason
                );


            $this->greceive_model->item_entry_insert($data);
            if($_SESSION['method'] == 'by_batch')
            {
                $data = array(

                    'item_guid' => $_SESSION['guid'] ,
                    'batch_guid' => $_SESSION['batch_guid'] ,
                    'item_guid_c' => $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid') ,
                    'lineno' => $this->db->query("SELECT COUNT(*)+1 AS reccount FROM backend_warehouse.d_grn_batch_item_c WHERE item_guid = '".$_SESSION['guid']."' ")->row('reccount'),
                    'scan_itemcode' => $_SESSION['scan_itemcode'],
                    'scan_description' => addslashes($_SESSION['scan_description']),
                    'scan_itemlink' => $_SESSION['scan_itemlink'],
                    'scan_packsize' => $_SESSION['scan_packsize'],
                    'scan_barcode' => $_SESSION['barcode'],
                    'scan_as_itemcode' => '0',

                    'scan_weight' => $weight,
                    'qty_do' => $do_qty,
                    'qty_rec' => $rec_qty,
                    'qty_diff_is_foc' => '0',
                    'qty_diff' => ($rec_qty)-($balance_qty+$foc_qty),
                    'scan_weight_total' => $rec_qty*$weight,
                    'posum_guid' => $_SESSION['posum_guid'],

                    'created_at' => $datetime->row('datetime'),
                    'created_by' => $_SESSION['username'],
                    'updated_at'=> $datetime->row('datetime'),
                    'updated_by'=> $_SESSION['username'],

                );
                $this->greceive_model->item_entry_insert_c($data);
            };
            //sum po rec qty
            $this->greceive_model->d_grn_update_porec($posum_guid);
            //Sum goods weight
            $this->greceive_model->d_grn_goods_weight_by_batchguid($batch_guid);
            //Cal method weight
            $this->greceive_model->d_grn_method_weight_by_batchguid($batch_guid);
            //Sum pallet weight
            $this->greceive_model->d_grn_pallet_weight_by_batchguid($batch_guid);
            //Cal Variance
            $this->greceive_model->d_grn_recal_batch_variance($batch_guid);

            $this->db->query("UPDATE backend_warehouse.d_grn_batch_item SET po_description = REPLACE(po_description, '\\\', '') ");
            $this->db->query("UPDATE backend_warehouse.d_grn_batch_item SET scan_description = REPLACE(scan_description, '\\\', '') ");

            $this->db->query("CALL backend_warehouse.replace_description()");

            redirect('greceive_controller/convert_excess_to_foc?item_guid='.$item_guid);
        }
        else
        {
            redirect('main_controller');
        }

    }

    public function convert_excess_to_foc()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $item_guid = $_REQUEST['item_guid'];

            $batch_item = $this->db->query("SELECT * from backend_warehouse.d_grn_batch_item where item_guid='$item_guid'");
                //echo $this->db->last_query();die;
            if($batch_item->row('qty_diff') == '0')
            {
                if($_SESSION['method'] == 'by_batch')
                {
                    redirect('greceive_controller/barcode_scan?by_batch&'.$batch_item->row('qty_diff'));
                };

                redirect('greceive_controller/barcode_scan?by_qty&'.$batch_item->row('qty_diff'));
            }
            else
            {
                $data = array(
                    'description' => addslashes($batch_item->row('scan_description')),
                    'qty_diff' => $batch_item->row('qty_diff'),
                    'item_guid' => $item_guid,
                    );
                $update_data = array(
                    'qty_diff_is_foc' => '0',
                    );
                $this->greceive_model->convert_excess_to_foc($update_data, $item_guid);

                if($_SESSION['method'] == 'by_batch' && $_SESSION['edit_item'] == 0)
                {
                    redirect('greceive_controller/barcode_scan?by_batch&'.$batch_item->row('qty_diff'));
                };

                // $browser_id = $_SERVER["HTTP_USER_AGENT"];
                // if(strpos($browser_id,"Windows CE"))
                //     {
                //         $this->load->view('WinCe/header');
                //         $this->load->view('WinCe/greceive/convert_excess_to_foc', $data);
                //     }
                // else
                //     {
                //         $this->load->view('header');
                //         $this->load->view('greceive/convert_excess_to_foc', $data);
                //         $this->load->view('footer');
                //     } 

                redirect('greceive_controller/barcode_scan?by_qty&'.$batch_item->row('qty_diff'));  
            }
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function convert_excess_to_foc_1()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $item_guid = $_REQUEST['item_guid'];

            $update_data = array(
                'qty_diff_is_foc' => '1',
                );
            $this->greceive_model->convert_excess_to_foc($update_data, $item_guid);
            // redirect('greceive_controller/barcode_scan');
            $this->session->set_flashdata('message_update_success', 'PO BALANCE IS = ');
            redirect('greceive_controller/barcode_scan?'.$_SESSION['method']);
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function entry_as_itemcode_view()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/entry_as_itemcode_view');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/entry_as_itemcode_view');
                    $this->load->view('footer');                    
                }    

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function entry_as_itemcode()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $check_itemcode = $this->db->query("SELECT * from backend_warehouse.d_grn_po where grn_guid='".$_SESSION['grn_guid']."' and itemcode='".$this->input->post('itemcode')."' ");

            if($check_itemcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Item Code :'.$_REQUEST['itemcode']."<br>Not Exist in po no: ".$_SESSION['po_no']);
                redirect('greceive_controller/entry_as_itemcode_error');
            }
            else
            {
                redirect('greceive_controller/have_focitem?itemcode='.$this->input->post('itemcode'));
            }
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function entry_as_itemcode_error()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/barcode_not_found');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/barcode_not_found');
                    $this->load->view('footer');
                }    

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function entry_as_RTV()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $item_guid = $_REQUEST['item_guid'];

            $query = $this->db->query("SELECT * from backend_warehouse.d_grn_batch_item where item_guid='$item_guid'");

            if($item_guid == '')
            {
                $query_guid = $this->db->query('SELECT REPLACE(UPPER(UUID()),"-","") AS guid ');

                $item_guid = $query_guid->row('guid');
                $data = array(
                    'guid' => $query_guid->row('guid'),
                    'scan_barcode' => $query->row('scan_barcode'),
                    'description' => '',
                    'qty_do' => '0',
                    'type' => 'ADD',
                    'disabled' => '',
                    'form_action' => site_url('greceive_controller/entry_as_RTV_action?type=ADD&item_guid='.$item_guid),
                    );

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/greceive/entry_as_RTV', $data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('greceive/entry_as_RTV', $data);
                        $this->load->view('footer');                        
                    }

            }
            else
            {
                $data = array(
                    'guid' => $item_guid,
                    'scan_barcode' => $query->row('scan_barcode'),
                    'description' => addslashes($query->row('scan_description')),
                    'qty_do' => $query->row('qty_do'),
                    'type' => 'EDIT',
                    'disabled' => 'disabled',
                    'form_action' => site_url('greceive_controller/entry_as_RTV_action?type=EDIT&item_guid='.$item_guid),
                    );
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/greceive/entry_as_RTV', $data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('greceive/entry_as_RTV', $data);
                        $this->load->view('footer');
                    }
                

            }
        }
        else
        {
            redirect('main_controller');
        }

    }

    public function entry_as_RTV_action()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $type = $_REQUEST['type'];
            $item_guid = $_REQUEST['item_guid'];

            $query = $this->db->query("SELECT * from backend_warehouse.d_grn_batch_item where item_guid='$item_guid'");
            $query_now = $this->db->query("SELECT NOW() AS now");

            $data = array(
                'qty_do' => $this->input->post('qty_do'),
                'scan_packsize' => '1',
                'qty_diff_is_foc' => '0',
                'scan_barcode' => $_SESSION['barcode'],
                'updated_at' => $query_now->row('now'),
                'updated_by' => $_SESSION['username'],
                );

            if($type == 'EDIT')
            {
                $guid = $this->input->post('guid');
                $this->greceive_model->update_entry_as_RTV_action($data, $guid);
                $this->session->set_flashdata('message', 'Succesfully Edit ');
                redirect('greceive_controller/batch_entry?batch_guid='.$query->row('batch_guid'));

            }
            else
            {
                $data = array(
                    'lineno' => '999',
                    'batch_guid' => $_SESSION['batch_guid'],
                    'rec_type' => 'RTV',
                    'item_guid' => $this->input->post('guid'),
                    'created_at' => $query_now->row('now'),
                    'created_by' => $_SESSION['username'],
                    'scan_description' => 'RTV- '.addslashes($this->input->post('description')),

                    'qty_do' => $this->input->post('qty_do'),
                    'scan_packsize' => '1',
                    'qty_diff_is_foc' => '0',
                    'scan_barcode' => $_SESSION['barcode'],
                    'updated_at' => $query_now->row('now'),
                    'updated_by' => $_SESSION['username'],
                );
                $this->greceive_model->insert_entry_as_RTV_action($data);
                $this->session->set_flashdata('message', 'Succesfully Add ');
                redirect('greceive_controller/batch_entry?batch_guid='.$_SESSION['batch_guid']);

            }
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function entry_as_RTV_or_FOC()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $item_guid = $_REQUEST['item_guid'];
            $rec_type = $_REQUEST['rec_type'];

            $query = $this->db->query("SELECT * from backend_warehouse.d_grn_batch_item where item_guid='$item_guid'");

            if($item_guid == '')//add
            {
                $query_guid = $this->db->query('SELECT REPLACE(UPPER(UUID()),"-","") AS guid ');

                $data = array(
                    'title' => $rec_type,
                    'guid' => $query_guid->row('guid'),
                    'description' => addslashes($_SESSION['bardesc']),
                    // 'scan_barcode' => $query->row('scan_barcode'),
                    'qty_do' => '0',
                    'type' => 'ADD',
                    'form_action' => site_url('greceive_controller/entry_as_RTV_or_FOC_action?type=ADD&rec_type='.$rec_type."&item_guid=".$query_guid->row('guid')),
                    );
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/greceive/entry_as_RTV_or_FOC', $data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('greceive/entry_as_RTV_or_FOC', $data);
                        $this->load->view('footer');
                    }    
            }
            else
            {//edit
                $data = array(
                    'title' => $rec_type,
                    'guid' => $item_guid,
                    'description' => " ",
                    // 'scan_barcode' => $query->row('scan_barcode'),
                    'qty_do' => $query->row('qty_do'),
                    'type' => 'EDIT',
                    'form_action' => site_url('greceive_controller/entry_as_RTV_or_FOC_action?type=EDIT&rec_type='.$rec_type."&item_guid=".$item_guid),
                    );
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/greceive/entry_as_RTV_or_FOC', $data);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('greceive/entry_as_RTV_or_FOC', $data);
                        $this->load->view('footer');
                    }
            }
        }
        else
        {
            redirect('main_controller');
        }

    }

    public function entry_as_RTV_or_FOC_action()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $type = $_REQUEST['type'];
            $rec_type = $_REQUEST['rec_type'];
            $item_guid = $_REQUEST['item_guid'];

            $data = array(
                'qty_do' => $this->input->post('qty_do'),
                'qty_diff_is_foc' => '0',
                'scan_barcode' => $_SESSION['barcode'],
                'updated_at' => $this->db->query("SELECT NOW() AS now")->row('now'),
                'updated_by' => $_SESSION['username'],
                );

            if($type == 'EDIT')
            {
                $guid = $item_guid;
                $this->greceive_model->update_entry_as_RTV_action($data, $guid);
                $this->session->set_flashdata('message', 'Succesfully Edit ');
                redirect('greceive_controller/batch_entry?batch_guid='.$_SESSION['batch_guid']);

            }
            else
            {
                $data = array(
                    'lineno' => '999',
                    'batch_guid' => $_SESSION['batch_guid'],
                    'rec_type' => $rec_type,
                    'scan_itemcode' => $_SESSION['itemcode'],
                    'scan_itemlink' => $_SESSION['itemlink'],
                    'scan_packsize' => $_SESSION['packsize'],
                    'scan_weight' => '0',
                    'item_guid' => $item_guid,
                    'created_at' => $this->db->query("SELECT NOW() AS now")->row('now'),
                    'created_by' => $_SESSION['username'],
                    'scan_description' => $rec_type."- ".addslashes($_SESSION['bardesc']),

                    'qty_do' => $this->input->post('qty_do'),
                    'qty_diff_is_foc' => '0',
                    'scan_barcode' => $_SESSION['barcode'],
                    'updated_at' => $this->db->query("SELECT NOW() AS now")->row('now'),
                    'updated_by' => $_SESSION['username'],
                );
                $this->greceive_model->insert_entry_as_RTV_action($data);
                $this->session->set_flashdata('message', 'Succesfully Add ');
                redirect('greceive_controller/batch_entry?batch_guid='.$_SESSION['batch_guid']);

            }
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function batch_itemDelete()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $item_guid = $_REQUEST['item_guid'];
            $batch_guid = $_REQUEST['batch_guid'];

            $query = $this->db->query("SELECT scan_description,posum_guid from backend_warehouse.d_grn_batch_item where item_guid='$item_guid' ");
                $posum_guid = $query->row('posum_guid');

            $this->greceive_model->batch_itemDelete($item_guid);
            $this->greceive_model->batch_itemDelete2_c($item_guid);
            $this->greceive_model->d_grn_goods_weight_by_batchguid($batch_guid);
            $this->greceive_model->d_grn_update_porec($posum_guid);

            redirect('greceive_controller/batch_entry?batch_guid='.$batch_guid);
        }
        else
        {
            redirect('main_controller');
        }

    }

    public function batch_itemDelete_c()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $item_guid_c = $_REQUEST['item_guid_c'];
            $batch_guid = $_SESSION['batch_guid'];
            $item_guid = $_SESSION['item_guid'];

            $this->greceive_model->batch_itemDelete_c($item_guid_c);

            $check_record = $this->db->query("SELECT COUNT(*) AS total_row FROM backend_warehouse.`d_grn_batch_item_c` WHERE item_guid = '".$_SESSION['item_guid']."';")->row('total_row');
            if($check_record == 0)
            {
                $query = $this->db->query("SELECT scan_description,posum_guid from backend_warehouse.d_grn_batch_item where item_guid='".$_SESSION['item_guid']."' ");
                $posum_guid = $query->row('posum_guid');

                $this->greceive_model->batch_itemDelete($item_guid);
                $this->greceive_model->batch_itemDelete2_c($item_guid);
                $this->greceive_model->d_grn_goods_weight_by_batchguid($batch_guid);
                $this->greceive_model->d_grn_update_porec($posum_guid);
            }

            redirect('greceive_controller/item_c?item_guid='.$_SESSION['item_guid'].'&batch_guid='.$_SESSION['batch_guid']);
        }
        else
        {
            redirect('main_controller');
        }

    }

    public function item_c()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $get_item_c = $this->db->query("SELECT * FROM backend_warehouse.d_grn_batch_item_c a WHERE a.`item_guid` = '".$_REQUEST['item_guid']."' order by lineno DESC");
            $data = array(
                'get_item_c' => $get_item_c,
                'do_qty' => $get_item_c->row('qty_do')
            );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/item_c', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/item_c', $data);
                    $this->load->view('footer');
                }

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function item_c_update_do_qty()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $this->db->query("UPDATE backend_warehouse.`d_grn_batch_item` a INNER JOIN backend_warehouse.`d_grn_batch_item_c` b ON a.`item_guid` = b.`item_guid` SET a.`qty_do` = '".$this->input->post('do_qty')."', b.`qty_do` = '".$this->input->post('do_qty')."' WHERE a.`item_guid` = '".$_REQUEST['item_guid']."'");
            redirect('greceive_controller/item_c?item_guid='.$_REQUEST['item_guid'].'&batch_guid='.$_REQUEST['batch_guid']);
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function search_gr()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/scan_gr');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/scan_gr');
                    $this->load->view('footer');                    
                }
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function search_gr_result()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {   
            if(isset($_SESSION['gr_no']) && $this->input->post('gr_no') != '')
            {
                $gr_no = $this->input->post('gr_no');
                $_SESSION['gr_no'] = $gr_no;
                /*$_SESSION['method'] = '1';*/
            }
            elseif(isset($_SESSION['gr_no']) != $this->input->post('gr_no') && $this->input->post('gr_no') != '')
            {
                $gr_no = $this->input->post('gr_no');
                $_SESSION['gr_no'] = $gr_no;   
                /*$_SESSION['method'] = '2';*/
            }
            else
            {
             $gr_no = $_REQUEST['gr_no'];
                /*$_SESSION['method'] = '3';   */
            }
            // make sure that d_grn and grmain got the record
            $refno = $this->db->query("SELECT * from backend.grmain as a inner join backend_warehouse.d_grn  as b on a.refno = b.convert_grn_by where a.refno = '$gr_no'");
            /*echo var_dump($_SESSION);
            echo $this->db->last_query(); die;*/
            if($refno->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'GR not Found');
                redirect('greceive_controller/search_gr');
            };

            if($refno->row('BillStatus') == '1')
            {
                $this->session->set_flashdata('message', 'GR Already Posted.');
                redirect('greceive_controller/search_gr');
            };

            if($refno->row('Cancelled') == '1')
            {
                $this->session->set_flashdata('message', 'GR is Cancelled.');
                redirect('greceive_controller/search_gr');
            };

            $_SESSION['sup_code'] = $refno->row('Code');

            $data = array (
                'grmain_detail' => $refno,
                'back' => site_url('greceive_controller/search_gr'),
                'form_action' => site_url('greceive_controller/update_d_grn_grmain'),

            );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/greceive/scan_gr_result',$data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('greceive/scan_gr_result',$data);
                    $this->load->view('footer');                    
                }

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function update_d_grn_grmain()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {   
            $account_code = $this->db->query("SELECT a.`AccountCode` FROM backend.`supcus` a WHERE a.`Code` = '".$_SESSION['sup_code']."' ")->row('AccountCode');
            // $check_do_no = $this->db->query("SELECT * FROM backend_warehouse.d_grn WHERE do_no = '".$this->input->post('do_no')."' AND inv_no = '$inv_no' AND scode = '".$_SESSION['sup_code']."' ");
            $check_do_no = $this->db->query("SELECT * FROM backend_warehouse.d_grn a INNER JOIN backend.supcus b ON a.`scode` = b.`Code` WHERE do_no = '".$this->input->post('do_no')."' AND inv_no = '".$this->input->post('inv_no')."' AND a.scode = '".$_SESSION['sup_code']."' AND b.`AccountCode` = '$account_code'");

            /*if($check_do_no->num_rows() > 0)
            {
                $this->session->set_flashdata('message', 'Invoice Number already exist in: '.$_SESSION['gr_no']);
                redirect('greceive_controller/search_gr_result?gr_no='.$_SESSION['gr_no']);
            }*/

            $check_current_record = $this->db->query("SELECT * from backend_warehouse.d_grn where convert_grn_by = '".$_SESSION['grn_no']."'");

            if($this->input->post('inv_date') == '')
            {   
                $this->session->set_flashdata('message', 'Invoice Date Cannot be empty');
                redirect('greceive_controller/search_gr_result?gr_no='.$_SESSION['gr_no']);
            };

            if($this->input->post('inv_date') > $this->input->post('received_date'))
            {   
                $this->session->set_flashdata('message', 'Goods Received Date cannot be earlier than Invoice Date');
                redirect('greceive_controller/search_gr_result?gr_no='.$_SESSION['gr_no']);
            };


            if($this->input->post('received_date') > $check_current_record->row('created_at'))
            {
                $this->session->set_flashdata('message', 'Goods Received Date cannot be later than Created Date');
                redirect('greceive_controller/search_gr_result?gr_no='.$_SESSION['gr_no']);
            };

            /*if($this->input->post('inv_date') < $this->input->post('received_date'))
            {   
                $this->session->set_flashdata('message', 'Invoice Date Cannot be less than received date');
                redirect('greceive_controller/po_add?po_no='.$_SESSION['po_no']."&sname=".$_SESSION['sup_name']);
            };*/
 
            if(round($this->input->post('amt_exc_tax')+$this->input->post('gst_tax'),4) != round($this->input->post('amt_inc_tax'),4)  )
            {   
                $this->session->set_flashdata('message', "Amount Exclude Tax + Tax Amount does not tally".$this->input->post('amt_inc_tax')."$this->input->post('amt_exc_tax')+$this->input->post('gst_tax')");
                redirect('greceive_controller/search_gr_result?gr_no='.$_SESSION['gr_no']);
            };

            if($this->input->post('inv_no') == '')
            {
                $inv_no = $this->input->post('do_no');
            }
            else
            {
                $inv_no = $this->input->post('inv_no');
            }

            $data = array(
                'do_no' => strtoupper($this->input->post('do_no')),
                'inv_no' => strtoupper($inv_no),
                'inv_date' => $this->input->post('inv_date'),
                'received_date' => $this->input->post('received_date'),
                'amt_inc_tax' => $this->input->post('amt_inc_tax'), 
                'amt_exc_tax' => $this->input->post('amt_exc_tax'), 
                'gst_tax' => $this->input->post('gst_tax'), 
                'updated_at' => $this->db->query("SELECT NOW() as today")->row('today'),
                'updated_by' => $_SESSION['username'],
                );

            $this->greceive_model->po_edit_update($data);

            $this->db->query("UPDATE backend.grmain set dono = '".strtoupper($this->input->post('do_no'))."', invno = '".strtoupper($inv_no)."', docdate = '".$this->input->post('inv_date')."', grdate = '".$this->input->post('received_date')."' where refno = '".$_SESSION['gr_no']."'");

            $this->session->set_flashdata('message', 'Data Updated');
            redirect('greceive_controller/search_gr');
        }
        else
        {
            redirect('main_controller');   
        }
    }
    
}
?>