<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once BASEPATH.'core/CodeIgniter.php';
class main_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('Main_Model');
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
    
	
	public function index()
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
                $this->load->view('index', $data);
                $this->load->view('footer');   
            }       
		
	}


    public function login_form()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('userpass', 'Password', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'trim|required');

        if($this->form_validation->run() == FALSE)
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
                    $this->load->view('index', $data);
                    $this->load->view('footer');
                }
        }
        else
        {   
            $username = $this->input->post('username');
            $userpass = $this->input->post('userpass');
            $location = $this->input->post('location');
            
                $result  = $this->Main_Model->login_data($username, $userpass);
                if($result > 0)
                {
                    $query = $this->db->query("SELECT location from backend_warehouse.set_sublocation where sublocation='$location'");
                    $locationSession = $query->row('location');

                    $query1 = $this->db->query("SELECT locgroup_branch from backend.companyprofile ");
                    $locationGroup = $query1->row('locgroup_branch');

                    $check_allow_chinese_char = $this->db->query("SELECT a.`allow_chinese_character` FROM backend.`xsetup` a ");
                    
                    //set the session variables
                    $sessiondata = array(
                              
                        'username' => $username,
                        'userpass' => $userpass,
                        'sub_location' => $location,
                        'location' => $locationSession,
                        'loc_group' => $locationGroup,
                        'chinese_char' => $check_allow_chinese_char->row('allow_chinese_character'),
                        'loginuser' => TRUE
                             
                    );
                    $_SESSION['chinese_char'] = $check_allow_chinese_char->row('allow_chinese_character');                        
                    $this->session->set_userdata($sessiondata);
                    redirect("main_controller/home", $sessiondata);
                    echo "<script> alert('succesfully loged in');</script>";     
                }
                else
                {
                    echo "<script> alert('Incorrect username or password');</script>";
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
                        $this->load->view('index', $data);
                        $this->load->view('footer');
                    }    
                }
            
            
        }
    }


    public function login_form2()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('userpass', 'Password', 'trim|required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->load->view('header');
            $this->load->view('index');
            $this->load->view('footer');
        }
        else
        {   
            $username = $this->input->post('username');
            $userpass = $this->input->post('userpass');
            
            if ($this->input->post('login') == "Login")
            {
                $result  = $this->Main_Model->login_data($username, $userpass);
                if($result > 0)
                {
                    $query = $this->db->query("SELECT location from backend_warehouse.set_sublocation where sublocation='$location'");
                    $locationSession = $query->row('location');

                    $query1 = $this->db->query("SELECT locgroup_branch from backend.companyprofile ");
                    $locationGroup = $query1->row('locgroup_branch');

                     $check_allow_chinese_char = $this->db->query("SELECT a.`allow_chinese_character` FROM backend.`xsetup` a ");
                    
                    //set the session variables
                    $sessiondata = array(
                              
                        'username' => $username,
                        'userpass' => $userpass,
                        'sub_location' => $location,
                        'location' => $locationSession,
                        'loc_group' => $locationGroup,
                        'chinese_char' => $check_allow_chinese_char->row('allow_chinese_character'),
                        'loginuser' => TRUE
                             
                    );
                         
                    $this->session->set_userdata($sessiondata);
                    redirect("main_controller/home", $sessiondata);
                    echo "<script> alert('succesfully loged in');</script>";     
                }
                else
                {
                    echo "<script> alert('cannot loged in');</script>";
                    redirect('main_controller');

                }
            }
            
        }
    }


    public function home()
    {
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            /*redirect('logout_c/clearSession');*/
            redirect('main_controller/homemenu');
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function homemenu()
    {
        
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $this->load->database();
            $this->load->model('Main_Model');  
            $check_guid = $this->db->query("SELECT user_group_guid from backend_warehouse.set_user where user_name = '".$_SESSION['username']."'")->row('user_group_guid');

            $check_file_path =  $this->db->query("SELECT file_path from backend_warehouse.set_parameter limit 1")->row('file_path');

            if($check_file_path == '')
            {
                $show = '0';
            };

            if(is_dir($check_file_path))
            {
                $show = '1';
            }
            else
            {
                $show ='0';
            };

            $xsetup_send_print = array(
                'xsetup_send_print' => $this->db->query("SELECT grnbyweight_send_print from backend.xsetup limit 1")->row('grnbyweight_send_print')
                                );
            $this->session->set_userdata($xsetup_send_print);

            $data = array (
                'user_group' => $this->db->query("SELECT user_name, user_group_guid from backend_warehouse.set_user where user_group_guid = '$check_guid' limit 1"),
                'menu' => $this->Main_Model->home_data(),
                'show_dropbox' => $show,
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/home',$data);
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
            redirect('main_controller');
        }
    }

    public function confirm_post()
    {
        if ($_REQUEST['post_type'] =='trx_out')
        {
            $data = array(
                'title' => 'POST BATCH TRANSFER OUT',
                'content' => 'Post This Transaction: '.$_REQUEST['refno'],
                'back_button' => site_url('obatch_controller/post_scan'),
                'action' => site_url('main_controller/general_post?post_type=trx_out&trans_guid='.$_REQUEST['trans_guid'])
                );
        };

        if ($_REQUEST['post_type'] =='trx_rec_child')
        {
            $data = array(
                'title' => 'POST BATCH TRANSFER IN (CHILD)',
                'content' => 'Post This Transaction: '.$_REQUEST['refno'],
                'back_button' => site_url('rbatch_controller/scan_item'),
                'action' => site_url('main_controller/general_post?post_type=trx_rec_child&child_guid='.$_REQUEST['child_guid']."&trans_guid=".$_REQUEST['trans_guid'])
                );  
        };

        if ($_REQUEST['post_type'] =='trx_rec')
        {
            $data = array(
                'title' => 'POST BATCH TRANSFER IN',
                'content' => 'Post This Transaction: '.$_REQUEST['refno'],
                'back_button' => site_url('rbatch_controller/scan_batch'),
                'action' => site_url('main_controller/general_post?post_type=trx_rec&trans_guid='.$_REQUEST['trans_guid'])
                );
        };

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/confirm_post', $data);
            }
        else
            {
                $this->load->view('header');
                $this->load->view('confirm_post', $data);
                $this->load->view('footer');                
            }    


    }
    
    public function general_post()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            if ($_REQUEST['post_type'] =='trx_out')
            {
                $trans_guid = $_REQUEST['trans_guid'];
                $data = array(
                    'delivered' => '1',
                    'send_print' => '0',

                    'delivered_at' => $this->db->query("SELECT now() as datetime")->row('datetime'),
                    'delivered_by' => $_SESSION['username'],
                    );
                
                $this->Main_Model->general_post_trx_out($data,$trans_guid);
                redirect('obatch_controller/main');

            };

            if ($_REQUEST['post_type'] =='trx_rec_child')
            {
                $child_guid = $_REQUEST['child_guid'];
                $data = array(
                    'verified' => '1',
                    'verified_at' => $this->db->query("SELECT now() as datetime")->row('datetime'),
                    'verified_by' => $_SESSION['username'],
                    );

               $this->Main_Model->general_post_trx_rec_child($data, $child_guid);
               redirect('rbatch_controller/itemlist?trans_guid='.$_REQUEST['trans_guid']);

            };

            if ($_REQUEST['post_type'] =='trx_rec')
            {
                $trans_guid = $_REQUEST['trans_guid'];
                $data = array(

                    'received' => '1',
                    'received_at' => $this->db->query("SELECT now() as datetime")->row('datetime'),
                    'received_by' => $_SESSION['username'],
                    );
                
                $this->Main_Model->general_post_trx_rec($data, $trans_guid);
                $this->Main_Model->b_transfer_rec_post($trans_guid);
                redirect('rbatch_controller/main');

            };

            if ($_REQUEST['post_type'] =='grn_rec')
            {
                $grn_guid = $_REQUEST['grn_guid'];
                $data = array(
                    'received' => '1',
                    'received_at' => $this->db->query("SELECT now() as datetime")->row('datetime'),
                    'received_by' => $_SESSION['username'],
                    );

                $this->Main_Model->general_post_grn($data,$grn_guid);
                $this->db->query("UPDATE backend_warehouse.d_grn_batch set stock=1 where grn_guid='".$grn_guid."'");

                $check_grnbyweight_send_print = $this->db->query("SELECT grnbyweight_send_print from backend.xsetup")->row('grnbyweight_send_print');
                if($check_grnbyweight_send_print == '1' )
                {
                    redirect('general_scan_controller/general_post?type=GRN&header_guid='.$grn_guid.'&redirect_controller=greceive_controller&redirect_function=po_list&location='.$_SESSION['location']);
                };

                redirect('greceive_controller/po_list');

            };
            
        }
        else
        {
            redirect('main_controller');
        }

    }

    public function reload_from_dropbox()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $file_path = $this->db->query("SELECT file_path from backend_warehouse.set_parameter limit 1")->row('file_path');

            $destination_path = $this->db->query("SELECT destination_path from backend_warehouse.set_parameter limit 1")->row('destination_path');
            $permission = '0777';

            if($file_path != '')
            {
            // to update file
            /*$controllers = $file_path."controllers";
            $models = $file_path."models";*/
            $source = $file_path."application";

            function recurse_copy($source,$destination_path) {
                $dir = opendir($source); 
                @mkdir($destination_path); 
                while(false !== ( $file = readdir($dir)) ) { 
                    if (( $file != '.' ) && ( $file != '..' )) { 
                        if ( is_dir($source . '/' . $file) ) { 
                            recurse_copy($source . '/' . $file,$destination_path . '/' . $file); 
                        } 
                        else { 
                            copy($source . '/' . $file,$destination_path . '/' . $file); 
                        } 
                    } 
                } 
                closedir($dir); 
            }

            recurse_copy($source, $destination_path);

            // to update database
            $file_name = $file_path.'panda_web_scriptupdate.sql';
            $file_time = date("Y-m-d H:i:s", filemtime($file_name));
            $file_gmt = date("Y-m-d H:i:s",  strtotime($file_time));


            if($fp = file_get_contents($file_name)) 
                {
                    $var_array = explode(';',$fp);

                  //echo var_dump($var_array);
                    
                    foreach($var_array as $value) 
                    {   
                        if($value != '')
                        {
                            $this->db->query($value."; ");
                        }
                        else
                        {   
                            $this->db->query("UPDATE backend_warehouse.set_parameter set script_datetime = '$file_gmt'");
                            $this->db->query("UPDATE backend_warehouse.set_parameter set updated_at = now()");
                            redirect("main_controller/homemenu");
                        }
                        //die;
                    }
                 //   echo $this->db->last_query();die;
                }
            }
            else
            {
                // empty file path
                redirect('main_controller');
            }
        }
        else
        {
            redirect('main_controller');
        }    
    }

    public function group_setting()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $data = array(
                'user_group' => $this->db->query("SELECT group_name, a.user_group_guid, IFNULL(show_cost,0) AS show_cost FROM backend_warehouse.set_user_group AS a LEFT JOIN backend_warehouse.`set_user_group_setting` AS b ON a.`user_group_guid` = b.`user_group_guid`"), 
                );
            $this->load->view('header');
            $this->load->view('group_setting', $data);
            $this->load->view('footer');

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function add_trans()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $user_group_guid = $this->input->post('user_group_guid[]');

                    foreach($user_group_guid as $i => $guid) 
                    {
                        $check_record = $this->db->query("SELECT * FROM backend_warehouse.set_user_group_setting where user_group_guid = '$guid'");
                        $show_cost = $this->input->post('show_cost[]');
                        if($check_record->num_rows() == 0)
                        {
                            $data = array (
                            'user_group_guid' => $guid, 
                            'show_cost' => $show_cost[$i], 
                            );
                           /* echo $this->db->last_query();die;*/
                           $this->Main_Model->add_detail($data);
                        }
                        else
                        {
                            $data = array (
                            'show_cost' => $show_cost[$i], 
                            );
                           $this->Main_Model->update_details($data,$guid);
                        }
                    }
                    redirect('main_controller/group_setting');
                    
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function scan_log()
    {
        if(isset($_REQUEST['delete_scan']))
        {
            $get_record = $this->db->query("SELECT * FROM backend_warehouse.d_batch_scan_log a WHERE a.`scan_guid` = '".$_REQUEST['scan_guid']."' ");
            
            if($_REQUEST['type'] == 'DC PICK')
            {
                $this->db->query("UPDATE backend.dc_req_child set qty_mobile=qty_mobile-('".$get_record->row('scan_qty')."'/packsize) where CHILD_GUID='".$_REQUEST['uniq_guid']."' ");
                //echo $this->db->last_query();die;
                $data = array(
                    'deleted' => 1,
                    'deleted_at' => $this->db->query("SELECT now() as datetime")->row('datetime'),
                    'deleted_by' => $_SESSION['username']
                );
                $this->db->where('scan_guid', $_REQUEST['scan_guid']);
                $this->db->update('backend_warehouse.d_batch_scan_log', $data);
                redirect('Main_controller/scan_log?type='.$_REQUEST['type'].'&item_guid='.$_REQUEST['item_guid'].'&dc_child_guid='.$_REQUEST['uniq_guid']);
            };

            if($_REQUEST['type'] == 'SI PICK')
            {
                $this->db->query("UPDATE backend.sochild set qty_mobile=qty_mobile-('".$get_record->row('scan_qty')."'/packsize) where refno='".$_SESSION['si_refno']."' AND line='".$_REQUEST['uniq_guid']."' ");
                // $sql = "UPDATE backend.sochild SET qty_mobile='".$get_record->row('scan_qty')."' WHERE refno='".$_SESSION['si_refno']."' AND line='".$_REQUEST['si_line']."'";
                $data = array(
                    'deleted' => 1,
                    'deleted_at' => $this->db->query("SELECT now() as datetime")->row('datetime'),
                    'deleted_by' => $_SESSION['username']
                );
                $this->db->where('scan_guid', $_REQUEST['scan_guid']);
                $this->db->update('backend_warehouse.d_batch_scan_log', $data);
                redirect('Main_controller/scan_log?type='.$_REQUEST['type'].'&item_guid='.$_REQUEST['item_guid'].'&si_line='.$_REQUEST['uniq_guid']);
            };

            if($_REQUEST['type'] == 'IBT Req' || $_REQUEST['type'] == 'Adjust-In' || $_REQUEST['type'] == 'Adjust-Out' || $_REQUEST['type'] == 'Simple SO' || $_REQUEST['type'] == 'PO' || $_REQUEST['type'] == 'Sales Order' || $_REQUEST['type'] == 'Sales SO' )
            {
                $data = array(
                    'deleted' => 1,
                    'deleted_at' => $this->db->query("SELECT now() as datetime")->row('datetime'),
                    'deleted_by' => $_SESSION['username']
                );
                $this->db->where('scan_guid', $_REQUEST['scan_guid']);
                $this->db->update('backend_warehouse.d_batch_scan_log', $data);

                $get_data = $this->db->query("SELECT IF(c.`module_desc` <> 'Sales Order',b.`LastCost`, b.`SellingPrice`) AS cost_type,b.`LastCost`,b.`SellingPrice`,a.* FROM web_trans_c a INNER JOIN itemmaster b ON a.`itemcode` = b.`Itemcode` INNER JOIN web_trans c ON c.`web_guid` = a.`web_guid` WHERE web_c_guid = '".$_REQUEST['uniq_guid']."' ");

                $web_c_guid = $_REQUEST['uniq_guid'];
                $itemcode = $get_data->row('itemcode');
                $description = $get_data->row('description');
                $sellingprice = $get_data->row('SellingPrice');
                $foc_qty = $get_data->row('qty_foc');
                $barcode = $get_data->row('barcode');
                $SinglePackQOH = $this->adjout_model->itemQOH($itemcode)->row('SinglePackQOH');
                $remark = $get_data->row('remark');
                $totalqty = $get_data->row('qty')-$_REQUEST['delete_batch_scan'];
                $_amount = ($get_data->row('qty')-$_REQUEST['delete_batch_scan'])*$get_data->row('cost_type');

                $this->PO_model->update_qty($web_c_guid,$itemcode,$description,$sellingprice,$foc_qty,$barcode,$SinglePackQOH,$remark,$totalqty,$_amount);

                redirect('Main_controller/scan_log?type='.$_REQUEST['type'].'&item_guid='.$_REQUEST['item_guid'].'&web_c_guid='.$_REQUEST['uniq_guid']);
            }
            
        }

        $get_record = $this->db->query("SELECT * FROM backend_warehouse.d_batch_scan_log a WHERE a.`item_guid` = '".$_REQUEST['item_guid']."' ");

        if($_REQUEST['type'] == 'DC PICK')
        {
            $back_button = site_url('Dcpick_controller/scan_item_error');
            $uniq_guid = $_REQUEST['dc_child_guid'];
        };
        
        if($_REQUEST['type'] == 'SI PICK')
        {
            $back_button = site_url('Sipick_controller/scan_item?refno='.$get_record->row('refno'));
            $uniq_guid = $_REQUEST['si_line'];
        };

        if($_REQUEST['type'] == 'IBT Req')
        {
            $back_button = site_url('IBT_controller/item_in_IBT?web_guid='.$_SESSION['web_guid']);
            $uniq_guid = $_REQUEST['web_c_guid'];
        };

        if($_REQUEST['type'] == 'Adjust-In')
        {
            $back_button = site_url('adjin_controller/itemlist?web_guid='.$_SESSION['web_guid']);
            $uniq_guid = $_REQUEST['web_c_guid'];
        };

        if($_REQUEST['type'] == 'Adjust-Out')
        {
            $back_button = site_url('adjout_controller/itemlist?web_guid='.$_SESSION['web_guid']);
            $uniq_guid = $_REQUEST['web_c_guid'];
        };

        if($_REQUEST['type'] == 'PO')
        {
            $back_button = site_url('PO_controller/item_in_po?web_guid='.$_SESSION['web_guid'].'&acc_code='.$_SESSION['acc_code']);
            $uniq_guid = $_REQUEST['web_c_guid'];
        };

        if($_REQUEST['type'] == 'Sales Order')
        {
            $back_button = site_url('SO_controller/item_in_so?web_guid='.$_SESSION['web_guid']);
            $uniq_guid = $_REQUEST['web_c_guid'];
        };

        if($_REQUEST['type'] == 'Simple SO')
        {
            $back_button = site_url('simpleso_controller/itemlist?web_guid='.$_SESSION['web_guid']);
            $uniq_guid = $_REQUEST['web_c_guid'];
        };

        $data = array(
            'uniq_guid' => $uniq_guid,
            'refno' => $get_record->row('refno'),
            'back_button' => $back_button,
            'type' => $_REQUEST['type'],
            'result' => $get_data = $this->db->query("SELECT * FROM backend_warehouse.d_batch_scan_log a WHERE a.`type` = '".$_REQUEST['type']."' AND a.`item_guid` = '".$_REQUEST['item_guid']."' AND a.deleted = 0 order by created_at desc")
        );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/scan_log',$data);
            }
        else
            {
                $this->load->view('header');
                $this->load->view('scan_log', $data);
                $this->load->view('footer');
            }

    }
 
}
?>
