<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class obatch_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('obatch_model');
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
                'result' => $this->db->query("SELECT * FROM backend_warehouse.b_trans WHERE location_from='".$_SESSION['location']."' AND trans_type='BATCH_TRANS' AND delivered='0' AND canceled='0' ORDER BY created_at DESC"),
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/obatch/main', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('obatch/main', $data);
                    $this->load->view('footer');
                }    
        }
        else
        {
           redirect('main_controller');
        }
    }

    public function add_remark()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            if(!isset($_REQUEST['trans_guid']))
            {
                $data = array( 
                'slocation' => $this->db->query("SELECT sublocation FROM backend_warehouse.set_sublocation WHERE location<>'".$_SESSION['location']."' GROUP BY sublocation"),
                'remarks' => $this->db->query("select remark from backend_warehouse.b_trans where trans_guid = ''"),
                'trans_guid' => '',
                );
            }
            else
            {
                $data = array( 
                'slocation' => $this->db->query("SELECT sublocation FROM backend_warehouse.set_sublocation WHERE location<>'".$_SESSION['location']."' GROUP BY sublocation"),
                'remarks' => $this->db->query("SELECT remark from backend_warehouse.b_trans where trans_guid = '".$_REQUEST['trans_guid']."'"),
                'trans_guid' => $_REQUEST['trans_guid'],
                );
            }
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/obatch/add_remark',$data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('obatch/add_remark',$data);
                    $this->load->view('footer');
                }    
            
        }  
        else
        {
          redirect('main_controller');
        } 
    }


    public function create_batch()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
         if($this->input->post('trans_guid') == '') // to check if dont have trans_guid 
         {
            $checkBATCH = $this->db->query("SELECT * from backend_warehouse.set_sysrun where run_type='BATCH_TRANS'");
            $remark = addslashes($this->input->post('remarks'));
            $get_subloc = $this->input->post('locationto');
            $get_loc = $this->db->query("SELECT location from backend_warehouse.set_sublocation where sublocation='$get_subloc'")->row('location');

            if($checkBATCH->num_rows() == 0)
            {
                 $this->obatch_model->insertsysrun();
            };
            if($checkBATCH->row('run_date') != date("Y-m-d") )
            {
                $this->obatch_model->updatesysrun();
            };

            $this->obatch_model->updaterunningnum();
            $resultBATCH = $this->db->query("SELECT * from backend_warehouse.set_sysrun where run_type='BATCH_TRANS'");

            $data = array(
                'refno' =>$this->db->query("SELECT CONCAT(run_code, run_year, LPAD(run_month,2,0), LPAD(run_day,2,0) ,LPAD(run_currentno, run_digit, 0), LPAD(FLOOR(RAND()*99),2,0)) AS refno FROM backend_warehouse.set_sysrun WHERE run_type='BATCH_TRANS'")->row('refno') ,
                );
            $this->session->set_userdata($data);
            $this->obatch_model->insert_batchno($remark,$get_subloc,$get_loc);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    redirect("obatch_controller/main");
                }
            else
                {
                    $this->load->view('header');
                    redirect("obatch_controller/main");
                    $this->load->view('footer');
                }    
         }
         else // edit mode
         {
            $trans_guid = $this->input->post('trans_guid');
            $remark = addslashes($this->input->post('remarks'));
            $get_subloc = $this->input->post('locationto');
            $get_loc = $this->db->query("SELECT location from backend_warehouse.set_sublocation where sublocation='$get_subloc'")->row('location');
            $this->obatch_model->updateremark($remark,$get_subloc,$get_loc,$trans_guid);
            redirect("obatch_controller/main");
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
            $checkbatch = $this->db->query("SELECT * from backend_warehouse.b_trans WHERE trans_guid='".$_REQUEST['trans_guid']."'");

            $data = array(
                'result' => $this->db->query("SELECT * FROM backend_warehouse.b_trans_c WHERE trans_guid='".$checkbatch->row('trans_guid')."' GROUP BY created_at DESC"),
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
                    $this->load->view('WinCe/obatch/itemlist', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('obatch/itemlist', $data);
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
            /*$refno = $_SESSION['refno'];*/

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/obatch/scan_item');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('obatch/scan_item');
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
        
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            if ($this->input->post('barcode') != '')
            {
                $barcode = $this->input->post('barcode');
                $trans_type = $this->db->query("SELECT trans_type FROM backend_warehouse.b_trans WHERE trans_guid='".$_SESSION['trans_guid']."'")->row('trans_type');
                $location = $_SESSION['location'];
                $trans_guid = $_SESSION['trans_guid'];
            }
            else
            {
                $barcode = $this->db->query("SELECT batch_barcode from backend_warehouse.b_trans_c where child_guid = '".$_REQUEST['child_guid']."'")->row('batch_barcode');
                $trans_type = $this->db->query("SELECT trans_type FROM backend_warehouse.b_trans WHERE trans_guid='".$_SESSION['trans_guid']."'")->row('trans_type');
                $location = $_SESSION['location'];
                $trans_guid = $_SESSION['trans_guid'];
            }
            $check_barcode = $this->db->query("SELECT goods_pallet_weight as pick_gdpl_weight, a.* FROM backend_warehouse.d_grn_batch a WHERE 
                batch_barcode='$barcode' AND stock>0 AND location='".$_SESSION['location']."'");

            $check_record = $this->db->query("SELECT * FROM backend_warehouse.b_trans a INNER JOIN backend_warehouse.b_trans_c b ON a.trans_guid=b.trans_guid WHERE a.location_from='$location'AND a.trans_type='$trans_type'AND a.delivered='0' AND batch_barcode='$barcode'AND a.trans_guid<>'$trans_guid' ORDER BY a.created_at DESC");

            $qty_default = $this->db->query("SELECT * FROM backend_warehouse.b_trans_c where batch_barcode = '$barcode' AND trans_guid = '".$_SESSION['trans_guid']."'");

            if ($check_barcode->num_rows() > '0') // barcode exist? 
            {
                if($check_record->num_rows() == '0') // item not scanned yet
                {
                    if($qty_default->num_rows() == '0') //new record
                    {
                    $data = array (
                        'item' => $check_barcode,
                        'qty' => $check_barcode,
                        );

                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/obatch/scan_itemresult', $data);
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('obatch/scan_itemresult', $data);
                            $this->load->view('footer');
                        }    
                    }
                    else // record exist, edit mode
                    {
                     $data = array (
                        'item' => $check_barcode,
                        'qty' => $qty_default,
                        );
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/obatch/scan_itemresult', $data);
                        } 
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('obatch/scan_itemresult', $data);
                            $this->load->view('footer');                            
                        }    

                    }

                }
                else
                {
                    $this->session->set_flashdata('message', 'Barcode '.$barcode.' already scanned in '.$check_record->row('refno') );
                    redirect('obatch_controller/scan_item');
                }
            }
            else 
            {   
                $this->session->set_flashdata('message', 'Barcode '.$barcode.' not found ');
                redirect('obatch_controller/scan_item');
            }
        } 
        else
        {
           redirect('main_controller/home');
        } 
    } 

    public function add_qty()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
        
        $barcode = $this->input->post('barcode');
        $remark = addslashes($this->input->post('remarks'));
        $goods_pallet_weight = $this->input->post('goods_pallet_weight');
        $iqty = $this->input->post('iqty');
        $variance = $iqty - $goods_pallet_weight;
        $batch_guid = $this->db->query("SELECT * FROM backend_warehouse.d_grn_batch WHERE batch_barcode = '$barcode'")->row('batch_guid');
        
        $child_guid = $this->db->query("SELECT child_guid FROM backend_warehouse.b_trans_c where batch_barcode = '$barcode' AND trans_guid = '".$_SESSION['trans_guid']."'")->row('child_guid');

            if ($child_guid != '')
            {
            $this->obatch_model->update_child($child_guid,$iqty,$variance,$remark);

             $this->load->view('header');
             redirect('obatch_controller/itemlist?trans_guid='.$_SESSION['trans_guid']);
             $this->load->view('footer');
        
            }
            else
            {
            $this->obatch_model->insert_b_child($barcode,$batch_guid, $goods_pallet_weight, $iqty,$variance,$remark);
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/obatch/scan_item');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('obatch/scan_item');
                    $this->load->view('footer');                    
                }    

            }
                    
        }
        else
        {
           redirect('main_controller');
        }
    }

    public function delete_batch()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $trans_guid = $_REQUEST['trans_guid'];
            $deletem = $this->db->query("DELETE FROM backend_warehouse.b_trans where trans_guid = '$trans_guid'");
            $deletec = $this->db->query("DELETE FROM backend_warehouse.b_trans_c where trans_guid = '$trans_guid'");
            redirect('obatch_controller/main');
        }
        else
        {
           redirect('main_controller');
        } 
    }

    public function delete_item()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $child_guid = $_REQUEST['child_guid'];
            $trans_guid = $_REQUEST['trans_guid'];
            $deletec = $this->db->query("DELETE FROM backend_warehouse.b_trans_c where child_guid = '$child_guid'");
            redirect('obatch_controller/itemlist?trans_guid='.$trans_guid);
        }
         else
        {
           redirect('main_controller');
        } 
    }


    public function print_job()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $printed = $this->db->query("UPDATE backend_warehouse.b_trans SET send_print='1' WHERE trans_guid='".$_SESSION['trans_guid']."'");
            redirect('obatch_controller/itemlist?trans_guid='.$_SESSION['trans_guid']);
        }
    }

    public function post_scan()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
    
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                   $this->load->view('WinCe/obatch/post');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('obatch/post');
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
            $check_transguid = $this->db->query("SELECT * from backend_warehouse.b_trans where refno = '$refno' and canceled = '0' and delivered= '0' ");
            $trans_guid = $check_transguid->row('trans_guid');
            
            if ($check_transguid->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Barcode '.$refno.' not found');
                redirect('obatch_controller/post_scan');
            }
            else
            {
                // $this->session->set_flashdata('message', 'Post this transaction  '.$refno.'  ');
                // redirect('main_controller/general_post?post_type=trx_out&trans_guid='.$trans_guid);
                redirect('main_controller/confirm_post?post_type=trx_out&trans_guid='.$trans_guid."&refno=".$refno);
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

            redirect('main_controller/general_post?post_type=trx_out&trans_guid='.$trans_guid);
        }
        else
        {
            redirect('main_controller');
        }
    }

}
?>