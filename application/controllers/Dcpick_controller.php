<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dcpick_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dcpick_model');
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


    public function index()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/dcpick/scan_reqNO');
            }
            else
            {
                $this->load->view('header');
                $this->load->view('dcpick/scan_reqNO');
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
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        { 
        
        $req_NO = $this->input->post('req_NO');

        $result = $this->db->query("SELECT trans_guid,refno,post_status,locto,converted FROM backend.dc_req where refno='$req_NO'");

            if($result->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'DC Doc No not found : '.$req_NO);
                redirect('dcpick_controller');
            };

            if($result->row('post_status') == '0')
            {
                $this->session->set_flashdata('message', 'DC Doc No not posted yet : '.$req_NO);
                redirect('dcpick_controller');
            };

            if($result->row('converted') != '0')
            {
                $this->session->set_flashdata('message', 'DC Doc No already converted: '.$req_NO);
                redirect('dcpick_controller');
            };

            $_SESSION['dc_refno'] = $result->row('refno');
            $_SESSION['dc_locto'] = $result->row('locto');
            $_SESSION['dc_trans_guid'] = $result->row('trans_guid');
            $dc_trans_guid = $_SESSION['dc_trans_guid'];
            
            $data = array(
                'dc_refno' => $_SESSION['dc_refno'],
                'dc_locto' => $result->row('locto'),
                'dc_trans_guid' => $result->row('trans_guid'),
                'result' => $this->dcpick_model->itemlist($dc_trans_guid),
                'count' => $this->db->query("SELECT count(child_guid) as count_rec from backend.dc_req_child where trans_guid = '". $_SESSION['dc_trans_guid']."'")->row('count_rec'),
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))    
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/dcpick/scan_item', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('dcpick/scan_item', $data);
                    $this->load->view('footer');
                }    
            

        }
        else
        {
            redirect('main_controller');
        }
        
    }

    public function scan_item_error()
    {
        $dc_trans_guid = $_SESSION['dc_trans_guid'];
        $data = array(
                'dc_refno' => $_SESSION['dc_refno'],
                'dc_locto' => $_SESSION['dc_locto'],
                'dc_trans_guid' => $_SESSION['dc_trans_guid'],
                'result' =>  $this->dcpick_model->itemlist($dc_trans_guid),
                'count' => $this->db->query("SELECT count(child_guid) as count_rec from backend.dc_req_child where trans_guid = '". $_SESSION['dc_trans_guid']."'")->row('count_rec'),
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))    
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/dcpick/scan_item', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('dcpick/scan_item', $data);
                    $this->load->view('footer');
                }    
            
    }
/* things to do
------- auto calculate req qty to smallest unit itemcode    done
------- display all item related to the itemlink done
------- check input qty to which itemcode then reset to smallest unit done
------- check total qty based on packsize done
------- able to record the inputed qty to the selected itemcode maybe need array done
------- able to know if 3box, he key in 2box, 90 unit.. system know 3 box... done
changes 20170420
-- IF REQ 
looose code 24unit, scan ctn code, pick 2 ctn ONLY
2 ctn, scan ctn code, pick 2 ctn ONLY
2 ctn, scan loose code, pick 24 unit ONLY
loose code 24unit, scan ctn code, 1 ctn, 1 loose
therefore it is based on itemlink but display based on barcode
*/

    public function scan_item_result()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            if(isset($_REQUEST['exist_barcode']))
            {
                $barcode = $_REQUEST['exist_barcode'];
                $_SESSION['scan_barcode'] = $barcode;
            }
            else
            {
                $barcode = $this->input->post('barcode');
                $_SESSION['scan_barcode'] = $barcode;
            }
            $check_barcode = $this->db->query("SELECT a.`itemlink`,a.`itemcode`,a.description,barcode FROM itemmaster a INNER JOIN itembarcode b ON a.`itemcode`=b.`itemcode` where b.barcode='$barcode' ");
            
            if($check_barcode->num_rows() == 0)
            {
                $barcode = $this->main_model->decode_barcode_general($barcode);
                if($this->input->post('barcode') == $barcode)
                {
                    $this->session->set_flashdata('message', 'Barcode not found : '.$this->input->post('barcode'));
                    redirect('dcpick_controller/scan_item_error');
                }
                else
                {
                    redirect('dcpick_controller/scan_item_result?exist_barcode='.$barcode);
                }
            };

            if($check_barcode->num_rows() > 0 && !isset($_REQUEST['exist_barcode']))
            {
                //echo $this->db->last_query();die;
                $_SESSION['decode_qty'] = 0;
            }


            $dc_req_child = $this->db->query("SELECT a.`Barcode`,a.child_guid,a.`itemcode`,b.`itemlink`,a.description,a.um,a.qty,a.qty_mobile,a.packsize, round(a.qty*a.packsize,4) as smallqty, a.soldbyweight FROM backend.dc_req_child a INNER JOIN backend.itemmaster b ON a.`Itemcode`=b.`Itemcode` where b.itemlink='".$check_barcode->row('itemlink')."' and trans_guid='".$_SESSION['dc_trans_guid']."' AND a.itemcode = '".$check_barcode->row('itemcode')."' ");
            //echo $this->db->last_query();die;
            if($dc_req_child->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Barcode '.$check_barcode->row('barcode').' is not in the request list. Please scan the loose item');
                redirect('dcpick_controller/scan_item_error');
            };

            $_SESSION['dc_barcode'] = $dc_req_child->row('Barcode');
            $_SESSION['dc_itemcode'] = $dc_req_child->row('itemcode');
            $_SESSION['dc_description'] = $dc_req_child->row('description');
            $_SESSION['dc_itemlink'] = $dc_req_child->row('itemlink');

            $_SESSION['dc_um'] = $dc_req_child->row('um');
            $_SESSION['dc_qty'] = $dc_req_child->row('qty');
            $_SESSION['dc_qty_mobile'] = $dc_req_child->row('qty_mobile');
            $_SESSION['dc_packsize'] = $dc_req_child->row('packsize');
            $_SESSION['dc_child_guid'] = $dc_req_child->row('child_guid');
            $_SESSION['dc_smallqty'] = $dc_req_child->row('smallqty');
            $_SESSION['soldbyweight'] = $dc_req_child->row('soldbyweight');

            $smallqty = $dc_req_child->row('smallqty');
            $check_qty_mobile = round($dc_req_child->row('qty_mobile')*$dc_req_child->row('packsize'),4);
            $var_qty = $smallqty - $check_qty_mobile;

            $data = array (
                'dc_refno' => $_SESSION['dc_refno'],
                'dc_qty' => $_SESSION['dc_qty'],
                'dc_smallqty' => $_SESSION['dc_smallqty'],
                'dc_qty_mobile' => $_SESSION['dc_qty_mobile'],
                'check_related_item' => $this->db->query("SELECT a.itemcode,a.itemlink,a.description,concat('P/S: ',a.packsize,' UOM: ',a.um)as iteminfo, IF(a.packsize <> 1, CONCAT(FORMAT(($smallqty-($smallqty MOD a.packsize))/a.packsize,0), ' ctn' , ' & ' , round($smallqty MOD a.packsize,2), ' unit'), CONCAT($smallqty, ' unit')) as sizeinfo ,a.um, a.packsize, qty_mobile, IF(a.packsize <> 1, CONCAT(FORMAT(($check_qty_mobile-($check_qty_mobile MOD a.packsize))/a.packsize,0), ' ctn' , ' & ' , round($check_qty_mobile MOD a.packsize,2), ' unit'), CONCAT($check_qty_mobile, ' unit')) as check_qty, IF($var_qty > 0 AND a.packsize <> 1, CONCAT( 'Variance ', FORMAT(($var_qty-($var_qty MOD a.packsize))/a.packsize,0), ' ctn' , ' & ' , $var_qty MOD a.packsize, ' unit'), IF('$var_qty' = 0, '', CONCAT('Variance ','$var_qty', ' unit'))) AS var_msg FROM backend.itemmaster as a left join backend.dc_req_child as b on a.itemlink = b.itemlink  WHERE a.itemcode='".$check_barcode->row('itemcode')."' group by a.itemcode ORDER BY a.itemcode asc "),
                'check_bar'=> $this->db->query("SELECT a.itemcode,barcode,itemlink,description,concat('P/S: ',packsize,' UOM: ',um)as iteminfo, $smallqty/packsize as sizeinfo ,um, packsize FROM backend.itemmaster as a inner join backend.itembarcode as b on a.itemcode = b.itemcode WHERE a.itemcode='".$check_barcode->row('itemcode')."' ORDER BY a.itemcode, barcode asc "),
                'QOH' => $this->db->query("SELECT IF(SUM(IF(b.OnHandQty IS NULL,0,b.OnHandQty)*a.`PackSize`) IS NULL,0,SUM(IF(b.OnHandQty IS NULL,0,b.OnHandQty)*a.`PackSize`)) AS SinglePackQOH FROM (SELECT b.itemlink,b.`Itemcode`,b.`PackSize` FROM backend.itemmaster a INNER JOIN backend.itemmaster b ON a.`ItemLink`=b.`ItemLink`  WHERE a.itemcode='".$check_barcode->row('itemcode')."') a INNER JOIN backend.locationstock b ON b.`Itemcode`=a.itemcode"),
                'set_master_code' => $this->db->query("SELECT CODE_DESC FROM set_master_code WHERE TRANS_TYPE = 'IBTPICKING' "),
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE")) 
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/dcpick/item_entry', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('dcpick/item_entry', $data);
                    $this->load->view('footer');
                }
           
        }

        else
        {
            redirect('main_controller');
        }
    }

    public function item_entry_add()
    {
        if($this->session->userdata('loginuser')== true && $this->session->userdata('username') != '')
        {
            $itemcode = $this->input->post('itemcode[]');
            $description = $this->input->post('description[]');
            $packsize = $this->input->post('packsize[]');
            $qty_input = $this->input->post('qty_input[]');
            $dc_child_guid = $_SESSION['dc_child_guid'];
            $reason_input = $this->input->post('reason_input');
            
            $db_qty = $this->db->query("SELECT qty_mobile*packsize as qty_mobile FROM dc_req_child where child_guid = '$dc_child_guid'")->row('qty_mobile');
            
            foreach($itemcode as $i => $id) 
            {
                if($id != '')
                { 
                    $sum_min += $qty_input[$i]*$packsize[$i];
                }
            }

            if ($sum_min > 10000)
            {
                $this->session->set_flashdata('message', "Data Not Saved : Qty input is over 10000.");
                redirect('dcpick_controller/scan_item_error');
                
            };

            $check_decimal = $this->db->query("SELECT LENGTH(SUBSTR((qty_mobile+('$sum_min'/packsize)),INSTR((qty_mobile+('$sum_min'/packsize)),'.'))) AS check_dec FROM dc_req_child where soldbyweight = 0  and child_guid = '$dc_child_guid'")->row('check_dec');

            if ($check_decimal > 0)
            {
                $this->session->set_flashdata('message', "Data Not Saved : Total Qty input has decimal point. Please enter the requested carton qty if you are scanning loose item.");
                redirect('dcpick_controller/scan_item_error');
            };

            $get_item_guid = $this->db->query("SELECT * FROM backend_warehouse.`d_batch_scan_log` a WHERE a.`type` = 'DC PICK' AND a.scan_itemcode = '".$_SESSION['dc_itemcode']."'");
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
                'type' => 'DC PICK',
                'refno' => $_SESSION['dc_refno'],
                'scan_barcode' => $_SESSION['scan_barcode'],
                'scan_itemcode' => $_SESSION['dc_itemcode'],
                'scan_description' => addslashes($_SESSION['dc_description']),
                'scan_itemlink' => $_SESSION['dc_itemlink'],
                'scan_packsize' => $_SESSION['dc_packsize'],
                'scan_as_itemcode' => '0',
                'scan_qty' => $this->input->post('qty_input_actual'),

                'scan_weight' => '',
                'created_at' => $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                'created_by' => $_SESSION['username'],
                'updated_at'=> $this->db->query("SELECT NOW() AS datetime")->row('datetime'),
                'updated_by' => $_SESSION['username'],
            );

            $this->db->insert('backend_warehouse.d_batch_scan_log', $data);

            if ($_SESSION['dc_smallqty'] < $sum_min+$db_qty  && $_SESSION['soldbyweight'] == 0)
            {
                $this->dcpick_model->item_entry_add($sum_min, $dc_child_guid, $reason_input);
                $this->session->set_flashdata('message', "Warning : Input Qty is More than Requested Qty.");
                redirect('dcpick_controller/scan_item_error');
            }
            elseif ($_SESSION['dc_smallqty'] < $sum_min+$db_qty  && $_SESSION['soldbyweight'] == 1 )
            {
                $this->dcpick_model->item_entry_add($sum_min, $dc_child_guid, $reason_input);
                $this->session->set_flashdata('message', 'Warning : Input Qty is More than Requested Qty.');
                redirect('dcpick_controller/scan_item_error');
            }
            elseif ($_SESSION['dc_smallqty'] > $sum_min+$db_qty && $_SESSION['soldbyweight'] == 0)
            {
                $this->dcpick_model->item_entry_add($sum_min, $dc_child_guid, $reason_input);
                $this->session->set_flashdata('message', 'Warning : Input Qty is Less than Requested Qty. Please scan another barcode to complete the record.');
                redirect('dcpick_controller/scan_item_error');
            }
            else
            {
                /*this temporary make reason field to be empty*/
                $reason_input = '';
                $this->dcpick_model->item_entry_add($sum_min, $dc_child_guid, $reason_input);
                $this->session->set_flashdata('message', 'Data Saved.');
                redirect('dcpick_controller/scan_item_error');
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
            $dc_trans_guid = $_REQUEST['dc_trans_guid'];

            $data['result'] = $this->dcpick_model->itemlist($dc_trans_guid);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE")) 
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/dcpick/itemlist', $data);
            
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('dcpick/itemlist', $data);
                    $this->load->view('footer');
                }    
            
            
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
            if($_REQUEST['type'] == 'DC PICK')
            {
                $get_record = $this->db->query("SELECT * FROM backend_warehouse.d_batch_scan_log a WHERE a.`scan_guid` = '".$_REQUEST['scan_guid']."' ");
                $this->db->query("UPDATE backend.dc_req_child set qty_mobile=qty_mobile-('".$get_record->row('scan_qty')."'/packsize) where CHILD_GUID='".$_SESSION['dc_child_guid']."'");
                $this->db->query("DELETE FROM backend_warehouse.d_batch_scan_log WHERE scan_guid = '".$_REQUEST['scan_guid']."' ");
                redirect('Dcpick_controller/scan_log?type='.$_REQUEST['type'].'&item_guid='.$_REQUEST['item_guid']);
            }
            
        }

        $data = array(
            'back_button' => site_url('Dcpick_controller/scan_item_error'),
            'type' => $_REQUEST['type'],
            'result' => $get_data = $this->db->query("SELECT * FROM backend_warehouse.d_batch_scan_log a WHERE a.`type` = '".$_REQUEST['type']."' AND a.`item_guid` = '".$_REQUEST['item_guid']."' order by created_at desc")
        );

        $this->load->view('header');
        $this->load->view('dcpick/scan_log', $data);
        $this->load->view('footer');
    }
    
}
?>