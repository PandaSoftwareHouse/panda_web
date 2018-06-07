<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class formpallet_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('formpallet_model');
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
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $getToday = $this->db->query("SELECT curdate() as date")->row('date');

            $grn_guid = $_SESSION['sub_location'].'_'.$_SESSION['username'].'_'.date('Y',strtotime($getToday)).'-'.date('m',strtotime($getToday)).'-'.date('d',strtotime($getToday));

            $_SESSION['grn_guid']= $grn_guid;

            $check_grn_guid = $this->formpallet_model->check_grn_guid($grn_guid);
            
            if($check_grn_guid->num_rows() != 0)
            {
                redirect('formpallet_controller/m_batch');
            };

            if($check_grn_guid->row('grn_guid') == '')
            {
                $datetime = $this->db->query("SELECT NOW() AS datetime");
                $date = $this->db->query("SELECT CURDATE() as date");
                $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid");
                
                $check_sysrun = $this->db->query("SELECT * from backend_warehouse.set_sysrun where run_type='MANUAL_BATCH'");

                $run_year = $this->db->query("SELECT YEAR(CURRENT_TIMESTAMP) as year");
                $run_month = $this->db->query("SELECT MONTH(CURRENT_TIMESTAMP) as month");
                $run_day = $this->db->query("SELECT DAY(CURRENT_TIMESTAMP) as day");

                if($check_sysrun->row('run_date') == '')
                {
                    $data = array(

                        'run_type' => 'MANUAL_BATCH',
                        'run_code' => 'MB',
                        'run_year' => $run_year->row('year'),
                        'run_month' => $run_month->row('month'),
                        'run_day' => $run_day->row('day'),
                        'run_date' => $date->row('date'),
                        'run_currentno' => '0',
                        'run_digit' => '4',
                        );
                    $this->formpallet_model->insert_sysrun($data);
                    $get_run_date = $this->db->query("SELECT * from backend_warehouse.set_sysrun where run_type='GRNBATCH'");
                };

                if($check_sysrun->row('run_date') < $date->row('date'))
                {
                    $data= array(
                        'run_date' => $date->row('date'),
                        'run_currentno' => 1,
                        );
                    $this->formpallet_model->update_sysrun($data);
                }
                else
                {
                    $data= array(
                        'run_currentno' => $check_sysrun->row('run_currentno')+1,
                        );
                    $this->formpallet_model->update_sysrun($data);
                }

                $getRefNo = $this->db->query("SELECT CONCAT(run_code, REPLACE(run_date, '-', ''), REPEAT(0,run_digit-LENGTH(run_currentno + 1)), run_currentno,LPAD(FLOOR(RAND() * 99),2,0))
                    AS refno FROM backend_warehouse.set_sysrun WHERE run_type = 'MANUAL_BATCH' ");


                $data = array(

                    'grn_guid' => $_SESSION['grn_guid'],
                    'grn_id' => $getRefNo->row('refno'),
                    'trans_type' => 'MANUAL_BATCH',
                    'loc_group' => $_SESSION['loc_group'],
                    'location' => $_SESSION['location'],
                    'sublocation' => $_SESSION['sub_location'],
                    'po_no' =>'',
                    'scode' => '',
                    's_name' => '',
                    'send_print' => '0',
                    'convert_grn' => '0',
                    'do_no' => '',
                    'inv_no' => '',

                    'created_at' => $datetime->row('datetime'),
                    'created_by' => $_SESSION['username'],
                    'updated_at' => $datetime->row('datetime'),
                    'updated_by' => $_SESSION['username'],
                );

                    $this->formpallet_model->po_add_insert($data);
                    redirect('formpallet_controller/m_batch');
            }

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_batch()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $grn_guid = $_SESSION['grn_guid'];
            $data = array(

                'result' => $this->formpallet_model->m_batch($grn_guid),
                'postButton' => $this->db->query("SELECT grn_by_weight_direct_post_grn FROM backend.xsetup")->row('grn_by_weight_direct_post_grn'),
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/formpallet/m_batch', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('formpallet/m_batch', $data);
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }

    }

    public function m_batch_add()
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

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/formpallet/m_batch_add', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('formpallet/m_batch_add', $data);
                    $this->load->view('footer');
                }    

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_batch_add_save()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $method_name = $this->input->post('method_name');
            $bin_ID = $this->input->post('bin_ID');
            $grn_guid = $_SESSION['grn_guid'];

            $query = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS batch_guid, IF(MAX(batch_id) IS NULL,0,MAX(batch_id))+1 AS MaxBatch_Id FROM backend_warehouse.d_grn_batch WHERE grn_guid ='$grn_guid'");
            $MaxBatch_Id = $query->row('MaxBatch_Id');
            $batch_guid = $query->row('batch_guid');

            $query2 = $this->db->query("SELECT grn_id FROM backend_warehouse.d_grn WHERE grn_guid= '$grn_guid' ");
            $grn_id = $query2->row('grn_id');

            $this->formpallet_model->delete_data($batch_guid);

            $data = array(
                'batch_guid' => $batch_guid,
                'grn_guid' => $grn_guid,
                'loc_group' => $_SESSION['loc_group'],
                'trans_type' => 'MANUAL_BATCH',
                'location' => $_SESSION['location'],
                'batch_id' => $MaxBatch_Id,
                'goods_weight' => '0',
                'pallet_weight' => '0',
                'goods_pallet_weight' => '0',
                'goods_pallet_variance' => '0',
                'batch_barcode' => $grn_id.sprintf("%02d", $MaxBatch_Id),
                'method_name' => $method_name,
                'Stock' => '0',
                'bin_id' => $bin_ID

                );
            $this->formpallet_model->insert_data($data);
            $this->formpallet_model->d_grn_create_batch($batch_guid, $method_name);
            $this->formpallet_model->d_grn_recal_batch_variance_before($batch_guid);
            redirect('formpallet_controller/m_batch');
            // redirect('greceive_controller/po_batch?grn_guid='.$grn_guid."&po_no=".$_SESSION['po_no']);
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_po_print()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            if ($_REQUEST['print_type']=='batch_only')
            {
                $batch_guid = $_REQUEST['batch_guid'];
                $query = $this->db->query("SELECT batch_id from backend_warehouse.d_grn_batch where batch_guid= '$batch_guid' ");
                $batch_id = $query->row('batch_id');

                $this->formpallet_model->m_po_print_batch_only($batch_guid);
                $this->session->set_flashdata('message', 'Printing Pallet ID : '.$batch_id);
                redirect('formpallet_controller/m_batch');
                // redirect('greceive_controller/po_batch?grn_guid='.$grn_guid);
            };
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_post_stock()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/formpallet/m_post_stock');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('formpallet/m_post_stock');
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_post_stock_scan()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            
            $batch_barcode = $this->input->post('batch_barcode');
            
            $result = $this->formpallet_model->m_post_stock_scan($batch_barcode);
            if($result->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Batch ID not found : '.$batch_barcode);
                redirect('formpallet_controller/m_post_stock');
            }
            else
            {
                $data = array(
                    'Stock' => '1'
                    );
                $this->formpallet_model->update_m_post_stock_scan($batch_barcode, $data);
                $this->session->set_flashdata('message', 'Batch ID Posted : '.$batch_barcode.' OK');
                redirect('formpallet_controller/m_post_stock');
            }
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_batch_weight()
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
                    $this->load->view('WinCe/formpallet/m_batch_weight', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('formpallet/m_batch_weight', $data);
                    $this->load->view('footer');
                }    
            
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_batch_weight_save()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $method_guid = $this->input->post('guid');
            $batch_guid = $_SESSION['batch_guid'];
            $data = array(

                'StockValue' => $this->input->post('StockValue'), 
                'MultiplyQty' => $this->input->post('Multiply'), 
                );
            
            $this->formpallet_model->batch_weight_save($data, $method_guid);
            
            //sum item weight and qty by batch_guid
            $this->formpallet_model->d_grn_goods_weight_by_batchguid($batch_guid);
            //update method weight
            $this->formpallet_model->d_grn_method_weight_by_batchguid($batch_guid);
            //update pallet weight
            $this->formpallet_model->d_grn_pallet_weight_by_batchguid($batch_guid);
            //recal variance
            $this->formpallet_model->d_grn_recal_batch_variance();
            
            redirect('formpallet_controller/m_batch');
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_batch_gross_weight()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $batch_guid = $_REQUEST['batch_guid'];
            $data['result'] = $this->formpallet_model->batch_gross_weight($batch_guid);
            $sessiondata = array(
                'batch_guid' => $batch_guid);
            $this->session->set_userdata($sessiondata);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/formpallet/m_batch_gross_weight', $data, $sessiondata);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('formpallet/m_batch_gross_weight', $data, $sessiondata);
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

            $this->formpallet_model->goods_pallet_weight_update($goods_pallet_weight);
            $this->formpallet_model->d_grn_recal_batch_variance();
            $this->session->set_flashdata('message', 'Succesfully add. ');
            redirect('formpallet_controller/m_batch');
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_batch_entry()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $batch_guid = $_REQUEST['batch_guid'];
            
            $batch = $this->formpallet_model->batch_data($batch_guid);
            $item = $this->formpallet_model->batch_item_data($batch_guid);

            $data = array(
                'batch' => $batch,
                'item' => $item,
                );

            $sessiondata = array(
                'batch_guid' => $batch_guid,
                'manual_batch_barcode' => $batch->row('batch_barcode'),
                );
            $this->session->set_userdata($sessiondata);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/formpallet/m_batch_entry', $data, $sessiondata);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('formpallet/m_batch_entry', $data, $sessiondata);
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_barcode_scan()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/formpallet/m_barcode_scan');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('formpallet/m_barcode_scan');
                    $this->load->view('footer');
                }    
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_barcode_scan_result()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $grn_guid = $_SESSION['grn_guid'];
            $barcode = $this->input->post('barcode');
            $sessiondata = array(
                'barcode' => $barcode
                );
            $this->session->set_userdata($sessiondata);
            
            $result = $this->formpallet_model->barcode_scan_result($barcode);
            $itemlink = $result->row('itemlink');

            if($result->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Barcode Not Found : '.$barcode);
                redirect('formpallet_controller/m_barcode_scan');
                
            }
            else
            {
                $_SESSION['bardesc'] = addslashes($result->row('bardesc'));
                $_SESSION['itemcode'] = $result->row('itemcode');
                $_SESSION['itemlink'] = $result->row('itemlink');
                $_SESSION['packsize'] = $result->row('packsize');

                $query = $this->db->query("SELECT * from backend.itemmaster where itemlink='".$_SESSION['itemlink']."' ");

                if($query->num_rows() > 1)
                {
                    redirect('formpallet_controller/m_have_itemlink');
                };

                redirect('formpallet_controller/m_item_entry_add?scan_itemcode='.$_SESSION['itemcode']);

            }
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_have_itemlink()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $query = $this->db->query("SELECT itemcode,itemlink,description,packsize from backend.itemmaster where ItemLink='".$_SESSION['itemlink']."' ");

            $_SESSION['po_itemlink'] = $query->row('itemlink');
            $_SESSION['po_itemcode'] = $query->row('itemcode');
            $_SESSION['po_description'] = addslashes($query->row('description'));
            $_SESSION['po_packsize'] = $query->row('packsize');
            $_SESSION['po_qty'] = '0';
            $_SESSION['foc_qty'] = '0';
            $_SESSION['po_bal'] = '0';
            $_SESSION['grn_diff'] = '0';

            $query2 = $this->db->query("SELECT itemcode,itemlink,description,packsize from backend.itemmaster where ItemLink='".$_SESSION['itemlink']."' order by packsize");

            $data = array(
                'query_heading' => $query,
                'query_item' => $query2,
                'po_itemcode' => $_SESSION['po_itemcode'],
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/formpallet/m_have_itemlink', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('formpallet/m_have_itemlink', $data);
                    $this->load->view('footer');
                }    

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function m_item_entry_add()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $batch_guid = $_SESSION['batch_guid'];
            //$scan_itemcode = $_REQUEST['scan_itemcode'];
            $_SESSION['scan_itemcode'] = $_REQUEST['scan_itemcode'];

            $batch_item = $this->db->query("SELECT * FROM backend_warehouse.d_grn_batch_item  where batch_guid ='$batch_guid' and scan_itemcode='".$_SESSION['scan_itemcode']."' ");

            if($batch_item->num_rows() > 0)
            {
                redirect('formpallet_controller/m_item_entry_edit?item_guid='.$batch_item->row('item_guid'));
            };

            $new_record = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid,itemcode,itemlink,description,packsize,PurTolerance_Std_plus,PurTolerance_Std_Minus,WeightTraceQty,WeightTraceQtyUOM FROM backend.itemmaster
            WHERE itemcode='".$_SESSION['scan_itemcode']."'");

            $_SESSION['scan_description'] = addslashes($new_record->row('description'));
            $_SESSION['scan_itemlink'] = $new_record->row('itemlink');
            $_SESSION['scan_packsize'] = $new_record->row('packsize');
            $_SESSION['guid']=$new_record->row('guid');

            $_SESSION['WeightTraceQty'] = $new_record->row('WeightTraceQty');
            $_SESSION['PurTolerance_Std_plus'] = $new_record->row('PurTolerance_Std_plus');
            $_SESSION['PurTolerance_Std_Minus'] = $new_record->row('PurTolerance_Std_Minus');

            if($_SESSION['WeightTraceQty'] =='1')
            {
                $_SESSION['WeightTraceQtyUOM'] = $new_record->row('WeightTraceQtyUOM');
            }
            else
            {
                $_SESSION['WeightTraceQtyUOM'] = '';
            }

            $_SESSION['line_no'] = $this->db->query("SELECT COUNT(*)+1 AS reccount FROM backend_warehouse.d_grn_batch_item where batch_guid = '$batch_guid' ")->row('reccount');

            $data = array(
                'heading' => 'add',
                'check_trace_qty' => $new_record->row('WeightTraceQty'),
                'line_no' => $this->db->query("SELECT COUNT(*)+1 AS reccount FROM backend_warehouse.d_grn_batch_item where batch_guid = '$batch_guid' "),
                
                'description' => addslashes($new_record->row('description')),
                'received_qty' => '0',
                'scan_weight' => '0',

                'trace_qty' => '0',
                'WeightTraceQtyUOM' => $_SESSION['WeightTraceQtyUOM']

                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/formpallet/m_item_entry_add', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('formpallet/m_item_entry_add', $data);
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
            $_SESSION['posum_guid'] = '';
            $posum_guid = $_SESSION['posum_guid'];
            $batch_guid = $_SESSION['batch_guid'];
            $item_guid = $_SESSION['guid'];

            $datetime = $this->db->query("SELECT NOW() AS datetime");

            $data = array(

                'item_guid' => $_SESSION['guid'] ,
                'batch_guid' => $_SESSION['batch_guid'] ,
                'lineno' => $_SESSION['line_no'] ,
                'po_itemcode' => $_SESSION['scan_itemcode'],
                'po_description' => addslashes($_SESSION['scan_description']),
                'po_itemlink' => $_SESSION['scan_itemlink'],
                'po_packsize' => $_SESSION['scan_packsize'],
                'scan_itemcode' => $_SESSION['scan_itemcode'],
                'scan_description' => addslashes($_SESSION['scan_description']),
                'scan_itemlink' => $_SESSION['scan_itemlink'],
                'scan_packsize' => $_SESSION['scan_packsize'],
                'scan_barcode' => $_SESSION['barcode'],
                'scan_as_itemcode' => '0',

                'scan_weight' => $this->input->post('weight'),
                'qty_do' => $this->input->post('rec_qty'),
                'qty_rec' => $this->input->post('rec_qty'),
                'qty_diff_is_foc' => '0',
                'qty_diff' => '0',
                'scan_weight_total' => $this->input->post('rec_qty')*$this->input->post('weight'),
                'posum_guid' => $_SESSION['posum_guid'],

                'WeightTraceQty' => $_SESSION['WeightTraceQty'],
                'WeightTraceQtyUOM' => $_SESSION['WeightTraceQtyUOM'],
                'WeightTraceQtyCount' => $this->input->post('trace_qty'),
                'PurTolerance_Std_plus' => $_SESSION['PurTolerance_Std_plus'],
                'PurTolerance_Std_Minus' => $_SESSION['PurTolerance_Std_Minus'],

                'created_at' => $datetime->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at'=> $datetime->row('datetime'),
                'updated_by'=> $_SESSION['username'],

                );

            $this->formpallet_model->item_entry_insert($data);
            //sum po rec qty
            $this->formpallet_model->d_grn_update_porec($posum_guid);
            //Sum goods weight
            $this->formpallet_model->d_grn_goods_weight_by_batchguid($batch_guid);
            //Cal method weight
            $this->formpallet_model->d_grn_method_weight_by_batchguid($batch_guid);
            //Sum pallet weight
            $this->formpallet_model->d_grn_pallet_weight_by_batchguid($batch_guid);
            //Cal Variance
            $this->formpallet_model->d_grn_recal_batch_variance();

            redirect('formpallet_controller/m_batch_entry?batch_guid='.$_SESSION['batch_guid']);
        }
        else
        {
            redirect('main_controller');
        }

    }

    public function m_item_entry_edit()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $_SESSION['item_guid'] = $_REQUEST['item_guid']  ;

            $batch_item = $this->db->query("SELECT * FROM backend_warehouse.d_grn_batch_item  where item_guid='".$_REQUEST['item_guid']."' ");

            $_SESSION['posum_guid'] = $batch_item->row('posum_guid');
            $_SESSION['scan_description'] = addslashes($batch_item->row('scan_description'));
            $_SESSION['scan_itemlink'] = $batch_item->row('scan_itemlink');
            $_SESSION['scan_packsize'] = $batch_item->row('scan_packsize');
            $_SESSION['po_packsize']=$batch_item->row('po_packsize');

            $_SESSION['WeightTraceQty'] = $batch_item->row('WeightTraceQty');
            $_SESSION['PurTolerance_Std_plus'] = $batch_item->row('PurTolerance_Std_plus');
            $_SESSION['PurTolerance_Std_Minus'] = $batch_item->row('PurTolerance_Std_Minus');

            if($_SESSION['WeightTraceQty'] =='1')
            {
                $_SESSION['WeightTraceQtyUOM'] = $batch_item->row('WeightTraceQtyUOM');
            }
            else
            {
                $_SESSION['WeightTraceQtyUOM'] = '';
            }

            $data = array(
                'heading' => 'edit',
                'check_trace_qty' => $batch_item->row('WeightTraceQty'),

                'line_no' => $batch_item->row('lineno'),
                
                'description' => addslashes($batch_item->row('scan_description')),
                'received_qty' => $batch_item->row('qty_rec'),
                'scan_weight' => $batch_item->row('scan_weight'),

                'trace_qty' => '0',
                'WeightTraceQtyUOM' => $_SESSION['WeightTraceQtyUOM']

                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/formpallet/m_item_entry_edit', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('formpallet/m_item_entry_edit', $data);
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

            $datetime = $this->db->query("SELECT NOW() AS datetime");

            $data= array(
                'scan_weight'=> $this->input->post('weight'),
                'qty_do'=> $this->input->post('rec_qty'),
                'qty_rec'=> $this->input->post('rec_qty'),
                'scan_weight_total'=> $this->input->post('rec_qty')*$this->input->post('weight'),

                'qty_diff_is_foc'=> '0',
                'qty_diff'=> '0',

                'WeightTraceQty' => $_SESSION['WeightTraceQty'],
                'WeightTraceQtyUOM' => $_SESSION['WeightTraceQtyUOM'],
                'WeightTraceQtyCount' => $this->input->post('trace_qty'),
                'PurTolerance_Std_plus' => $_SESSION['PurTolerance_Std_plus'],
                'PurTolerance_Std_Minus' => $_SESSION['PurTolerance_Std_Minus'],

                'updated_at'=> $datetime->row('datetime'),
                'updated_by'=> $_SESSION['username'],
                
                );
            $this->formpallet_model->item_entry_update($data);
            
            //sum po rec qty
            $this->formpallet_model->d_grn_update_porec($posum_guid);
            //Sum goods weight
            $this->formpallet_model->d_grn_goods_weight_by_batchguid($batch_guid);
            //Cal method weight
            $this->formpallet_model->d_grn_method_weight_by_batchguid($batch_guid);
            //Sum pallet weight
            $this->formpallet_model->d_grn_pallet_weight_by_batchguid($batch_guid);
            //Cal Variance
            $this->formpallet_model->d_grn_recal_batch_variance();

            redirect('formpallet_controller/m_batch_entry?batch_guid='.$_SESSION['batch_guid']);
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

            $this->formpallet_model->batch_itemDelete($item_guid);
            $this->formpallet_model->d_grn_goods_weight_by_batchguid($batch_guid);
            $this->formpallet_model->d_grn_update_porec($posum_guid);

            redirect('formpallet_controller/m_batch_entry?batch_guid='.$batch_guid);
        }
        else
        {
            redirect('main_controller');
        }

    }

}
?>