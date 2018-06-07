<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productionentry_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        
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
        if($this->session->userdata('loginuser') == true)
        {  
            //$this->template->load('template' , 'home');

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/home');
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

    public function item()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $data = array(
                'direction' => site_url('Productionentry_controller/item_add?add'),
                'edit_direction' => site_url('Productionentry_controller/edit_main'),
                'production_batch' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE type = 'item' and posted = '0' order by created_at DESC "),
                'title' => 'ITEM',

            );

            //$this->template->load('template' , 'main', $data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/main', $data);
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

    public function item_add()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $code = $this->db->query("SELECT locgroup from backend.location limit 1")->row('locgroup');
            
            if(isset($_REQUEST['add']))
            {
                $autofocusBarcode = 'autofocus';
                $autofocusPresetqty = '';
                $current = $this->db->query("SELECT DATE_FORMAT(CURDATE(), '%Y-%m') as date")->row('date');
                $month = $this->db->query("SELECT DATE_FORMAT(run_date, '%Y-%m') as date FROM backend_warehouse.set_sysrun WHERE run_type = 'ITEM' ")->row('date');

                if($current != $month)
                {
                    $value = array(
                        'run_date' => $this->db->query("SELECT CURDATE() AS date")->row('date'),
                        'run_currentno' => '0',

                    );
                    $this->db->where('run_type', 'ITEM');
                    $this->db->update('backend_warehouse.set_sysrun', $value);
                };

                $result = $this->db->query("SELECT * from backend_warehouse.set_sysrun where run_type = 'ITEM' ");
                $date = $this->db->query("SELECT NOW() as date")->row('date');
                $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') as uuid ")->row('uuid');
                $refno = $this->db->query("SELECT CONCAT('".$code."', '".$result->row('run_code')."', RIGHT(LEFT(REPLACE(CURDATE(), '-', ''), 6), 4), LPAD('".$result->row('run_currentno')."', '".$result->row('run_digit')."', '0')) AS pad ")->row('pad');

                $info = array(
                    'trans_guid' => $guid,
                    'refno' => $refno,
                    'location' => '',
                    'type' => 'Item',
                    'docdate' => $this->db->query("SELECT CURDATE() as date")->row('date'),
                    /*'docno' => '',*/
                    /*'cross_refno' => '',*/
                    'created_at' => $date,
                    'created_by' => $_SESSION['username'],
                    'updated_at' => $date,
                    'updated_by' => $_SESSION['username'],

                );
                $this->db->insert('backend_warehouse.production_batch', $info);

                if($this->db->affected_rows() > 0)
                {
                    $infomation = array(
                        'run_currentno' => $result->row('run_currentno') + 1,

                    );
                    $this->db->where('run_type', 'ITEM');
                    $this->db->update('backend_warehouse.set_sysrun', $infomation);
                };
            }
            else
            {
                $autofocusBarcode = 'autofocus';
                $autofocusPresetqty = '';
                $guid = $_REQUEST['guid'];
                $refno = $_REQUEST['refno'];
            }
            
            $data = array(
                'production_batch' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE trans_guid = '$guid' AND posted = '1' "),
                'production_batch_c' => $this->db->query("SELECT * FROM backend_warehouse.production_batch_c WHERE trans_guid = '$guid' "),
                'main' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE trans_guid = '$guid' "),
                'ReferenceNo' => $refno,
                'Barcode' => '',
                'ItemCode' => '',
                'UnitMeasurement' => '',
                'Description' => '',
                'Batch' => '',
                'Quantity' => '',
                'guid' => $guid,
                'value' => '0',
                'autofocusBarcode' => $autofocusBarcode ,
                'autofocusPresetqty' => $autofocusPresetqty ,
                'location' => $this->db->query("SELECT code, description from backend.location"),

            );

            //$this->template->load('template' , 'add_item', $data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/add_item', $data);
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

    public function add_item()
    {
        if($this->session->userdata('loginuser') == true)
        {
            if($this->input->post('submit') == 'Submit_code')
            {
                $autofocusBarcode = '';
                $autofocusPresetqty = 'autofocus';
                $result_barcode = $this->db->query("SELECT * FROM backend.itembarcode a INNER JOIN backend.hamper_template b ON a.Itemcode = b.itemcode_h INNER JOIN itemmaster c ON b.itemcode_h = c.Itemcode WHERE Barcode = '".$this->input->post('Barcode')."' ");

                if($result_barcode->num_rows() > 0)
                {
                    $result_pbc = $this->db->query("SELECT * FROM backend_warehouse.production_batch_c WHERE itemcode = '".$result_barcode->row('Itemcode')."' AND trans_guid = '".$_REQUEST['guid']."' ");

                    if($result_pbc->num_rows() > 0)
                    {

                        $production_batch_location =  $this->input->post('location');
                        $production_batch_locgroup =  $this->db->query("SELECT locgroup from backend.location where code = '$production_batch_location'")->row('locgroup');

                $this->db->query("UPDATE backend_warehouse.production_batch set location = '$production_batch_location', locgroup = '$production_batch_locgroup' where trans_guid = '".$_REQUEST['guid']."'");

                        $data = array(
                            'production_batch' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE trans_guid = '".$_REQUEST['guid']."' AND posted = '1' "),
                            'production_batch_c' => $this->db->query("SELECT * FROM backend_warehouse.production_batch_c WHERE trans_guid = '".$_REQUEST['guid']."' "),
                            'main' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE trans_guid = '".$_REQUEST['guid']."' "),
                            'ReferenceNo' => $_REQUEST['refno'],
                            'Barcode' => $result_barcode->row('Barcode'),
                            'ItemCode' => $result_pbc->row('itemcode'),
                            'UnitMeasurement' => $result_pbc->row('um'),
                            'Description' => $result_pbc->row('description'),
                            //'Batch' => '1',
                            'Quantity' => $result_pbc->row('preset_qty'),
                            'guid' => $_REQUEST['guid'],
                            'add' => '0', //edit
                            'autofocusBarcode' => $autofocusBarcode ,
                            'autofocusPresetqty' => $autofocusPresetqty ,
                            'location' => $this->db->query("SELECT code, description from backend.location"),
                        );
                         
                    }
                    else
                    {
                        $production_batch_location =  $this->input->post('location');
                        $production_batch_locgroup =  $this->db->query("SELECT locgroup from backend.location where code = '$production_batch_location'")->row('locgroup');

                $this->db->query("UPDATE backend_warehouse.production_batch set location = '$production_batch_location', locgroup = '$production_batch_locgroup' where trans_guid = '".$_REQUEST['guid']."'");

                        $data = array(
                            'production_batch' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE trans_guid = '".$_REQUEST['guid']."' AND posted = '1' "),
                            'production_batch_c' => $this->db->query("SELECT * FROM backend_warehouse.production_batch_c WHERE trans_guid = '".$_REQUEST['guid']."' "),
                            'main' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE trans_guid = '".$_REQUEST['guid']."' "),
                            'ReferenceNo' => $_REQUEST['refno'],
                            'Barcode' => $result_barcode->row('Barcode'),
                            'ItemCode' => $result_barcode->row('Itemcode'),
                            'UnitMeasurement' => $result_barcode->row('UM'),
                            'Description' => $result_barcode->row('barDesc'),
                            //'Batch' => '1',
                            'Quantity' => '',
                            'guid' => $_REQUEST['guid'],
                            'add' => '1',
                            'autofocusBarcode' => $autofocusBarcode ,
                            'autofocusPresetqty' => $autofocusPresetqty ,
                            'location' => $this->db->query("SELECT code, description from backend.location"),
                        );
                        
                    }

                    //$this->template->load('template' , 'add_item', $data);

                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id, "Windows CE"))
                        {
                            /*$this->load->view('header');
                            $this->load->view('WinCe/po/po_main');
                            $this->load->view('footer');*/
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('productionentry/add_item', $data);
                            $this->load->view('footer');
                        }
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Item code or barcode not exists!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Productionentry_controller/item_add?guid=" .$_REQUEST['guid']. "&refno=" .$_REQUEST['refno']);
                }
            }
            elseif($this->input->post('submit') == 'Add')
            {
                $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') as uuid ")->row('uuid');
                $date = $this->db->query("SELECT NOW() as date")->row('date');

                $production_batch_location =  $this->input->post('location');
                $production_batch_locgroup =  $this->db->query("SELECT locgroup from backend.location where code = '$production_batch_location'")->row('locgroup');

                $this->db->query("UPDATE backend_warehouse.production_batch set location = '$production_batch_location', locgroup = '$production_batch_locgroup' where trans_guid = '".$_REQUEST['guid']."'");

                $info = array(
                    'trans_guid_c' => $guid,
                    'trans_guid' => $_REQUEST['guid'],
                    'itemcode' => $this->input->post('ItemCode'),
                    'description' => $this->input->post('Description'),
                    'um' => $this->input->post('UnitMeasurement'),
                    'preset_qty' => $this->input->post('Quantity'),
                    'batch' => '1',
                    'expected_qty' => '1' * $this->input->post('Quantity'),
                    'actual_qty' => '1' * $this->input->post('Quantity'),
                    'created_at' => $date,
                    'created_by' => $_SESSION['username'],
                    'updated_at' => $date,
                    'updated_by' => $_SESSION['username'],

                );
                $this->db->insert('backend_warehouse.production_batch_c', $info);
                

                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Add item successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to insert item<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                redirect("Productionentry_controller/item_add?guid=" .$_REQUEST['guid']. "&refno=" .$_REQUEST['refno']);
            }
            elseif($this->input->post('submit') == 'Save')
            {   

                $infomation = array(
                    'preset_qty' => $this->input->post('Quantity'),
                    'expected_qty' => '1' * $this->input->post('Quantity'),
                    'actual_qty' => '1' * $this->input->post('Quantity'),

                );

                $array = array(
                    'trans_guid' => $_REQUEST['guid'],
                    'itemcode' => $this->input->post('ItemCode'),
                );
                $this->db->where($array);
                $this->db->update('backend_warehouse.production_batch_c', $infomation);

                $location = $this->input->post('location');
                $checking_location = $this->db->query("SELECT * from backend_warehouse.production_batch where trans_guid = '".$_REQUEST['guid']."'");
                if($location != $checking_location)
                {
                    $production_batch_locgroup =  $this->db->query("SELECT locgroup from backend.location where code = '$location'")->row('locgroup');
                    $this->db->query("UPDATE backend_warehouse.production_batch 
                        set location = '$location', locgroup = '$production_batch_locgroup' where trans_guid = '".$_REQUEST['guid']."'");
                };

                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update item successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Data unchanged<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                redirect("Productionentry_controller/item_add?guid=" .$_REQUEST['guid']. "&refno=" .$_REQUEST['refno']);
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

    public function delete_item()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $main_guid = $_REQUEST['main_guid'];
            $guid = $_REQUEST['guid'];
            
            $this->db->where('trans_guid_c', $main_guid);
            $this->db->delete('backend_warehouse.production_batch_c');

            if($this->db->affected_rows() > 0)
            {
                $num = $this->db->query("SELECT * from backend_warehouse.production_batch_c where trans_guid = '".$_REQUEST['guid']."' ")->num_rows();

                if($num == '0')
                {
                    $this->db->where('trans_guid', $guid);
                    $this->db->delete('backend_warehouse.production_batch');

                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Item deleted successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                    redirect("Productionentry_controller/item");
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Item deleted successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                    redirect("Productionentry_controller/item_add?guid=" .$_REQUEST['guid']. "&refno=" .$_REQUEST['refno']);
                }
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to delete item<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                redirect("Productionentry_controller/item_add?guid=" .$_REQUEST['guid']. "&refno=" .$_REQUEST['refno']);
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
            $result_pbc = $this->db->query("SELECT * FROM backend_warehouse.production_batch_c WHERE trans_guid_c = '".$_REQUEST['main_guid']."' ");
            $result_barcode = $this->db->query("SELECT * FROM backend.itembarcode a INNER JOIN backend.hamper_template b ON a.Itemcode = b.itemcode_h WHERE Itemcode = '".$result_pbc->row('itemcode')."' ");

            $data = array(
                'production_batch' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE trans_guid = '".$_REQUEST['guid']."' AND posted = '1' "),
                'production_batch_c' => $this->db->query("SELECT * FROM backend_warehouse.production_batch_c WHERE trans_guid = '".$_REQUEST['guid']."' "),
                'main' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE trans_guid = '".$_REQUEST['guid']."' "),
                'ReferenceNo' => $_REQUEST['refno'],
                'Barcode' => $result_barcode->row('Barcode'),
                'ItemCode' => $result_pbc->row('itemcode'),
                'UnitMeasurement' => $result_pbc->row('um'),
                'Description' => $result_pbc->row('description'),
                //'Batch' => '1',
                'Quantity' => $result_pbc->row('preset_qty'),
                'guid' => $_REQUEST['guid'],
                'add' => '0', //edit
                'autofocusBarcode' => '',
                'autofocusPresetqty' => 'autofocus',
                'location' => $this->db->query("SELECT code, description from backend.location"),

            );

            //$this->template->load('template' , 'add_item', $data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/add_item', $data);
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

    public function post_item()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $date = $this->db->query("SELECT NOW() as date")->row('date');

            $checking_location = $this->db->query("SELECT location, refno, locgroup from backend_warehouse.production_batch where trans_guid = '".$_REQUEST['guid']."'");

            if($checking_location->row('location') == "")
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to post. Location not found for RefNo : '.$checking_location->row("refno").'  <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Productionentry_controller/item');
            }

            $infomation = array(
                'posted' => '1',
                'posted_at' => $date,
                'posted_by' => $_SESSION['username'],
                'updated_at' => $date,
                'updated_by' => $_SESSION['username'],

            );

            $this->db->where('trans_guid', $_REQUEST['guid']);
            $this->db->update('backend_warehouse.production_batch', $infomation);

            if($this->db->affected_rows() > 0)
            {
                $year = $this->db->query("SELECT right(year(now()),2) as year")->row('year');
                $month = $this->db->query("SELECT lpad(month(now()),2,0) as month")->row('month');
                $run_no = $this->db->query("SELECT  IFNULL(MAX(LPAD(RIGHT(refno,4)+1,4,0)),LPAD(1,4,0)) AS runno  FROM backend.transform_entry WHERE loc_group = '".$checking_location->row('locgroup')."' AND SUBSTRING(refno,-8,4) = CONCAT(RIGHT(YEAR(NOW()),2),LPAD(MONTH(NOW()),2,0))")->row('runno');
                $doccode = $this->db->query("SELECT code from backend.sysrun where type = 'TPD' ")->row('code');
                $refno = $this->db->query("SELECT concat('$doccode', '$year', '$month', '$run_no' ) as refno")->row('refno');
                //$_SESSION['refno'] = $refno;

                $this->db->query("update backend.sysrun set currentno = currentno +1 where type = 'TPD' ");

                $info = array(
                    'transform_guid' => $_REQUEST['guid'],
                    'RefNo' => $refno,
                    'DocDate' => $date,
                    'Remark' => $this->db->query("SELECT * from backend_warehouse.production_batch where trans_guid = '".$_REQUEST['guid']."' ")->row('refno'),
                    'posted' => '0',
                    'posted_at' => $date,
                    'created_at' => $date,
                    'created_by' => $_SESSION['username'],
                    'updated_at' => $date,
                    'updated_by' => $_SESSION['username'],
                    'location' => $this->db->query("SELECT * from backend_warehouse.production_batch where trans_guid = '".$_REQUEST['guid']."' ")->row('location'),
                    'loc_group' => $this->db->query("SELECT * from backend_warehouse.production_batch where trans_guid = '".$_REQUEST['guid']."' ")->row('locgroup'),

                );

                $this->db->insert('backend.transform_entry', $info);

                $pbc = $this->db->query("SELECT * from backend_warehouse.production_batch_c where trans_guid = '".$_REQUEST['guid']."' ");

                foreach($pbc->result() as $row => $value)
                {
                    $informations = array(
                        'detail_guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') as uuid ")->row('uuid'),
                        'transform_guid' => $_REQUEST['guid'],
                        'itemcode' => $value->itemcode,
                        'description' => $value->description,
                        'qty' => $value->actual_qty,
                        'um' => $value->um,
                        'created_at' => $date,
                        'created_by' => $_SESSION['username'],
                        'updated_at' => $date,
                        'updated_by' => $_SESSION['username'],
                        'transform_template' => $this->db->query("SELECT template FROM backend.hamper_template WHERE itemcode_h = '$value->itemcode' ")->row('template'),
                        //'hamper_line' => $_SESSION['username'],
                        //'hamper_type' => $_SESSION['username'],
                        'adjust_type' => $this->db->query("SELECT adjust_type FROM backend.hamper_template WHERE itemcode_h = '$value->itemcode' ")->row('adjust_type'),
                        

                    );

                    $this->db->insert('backend.transform_entry_c', $informations);
                }

                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Item posted successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to post item<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            redirect("Productionentry_controller/item");
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

    public function edit_main()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $data = array(
                'production_batch' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE trans_guid = '".$_REQUEST['guid']."' AND posted = '1' "),
                'production_batch_c' => $this->db->query("SELECT * FROM backend_warehouse.production_batch_c WHERE trans_guid = '".$_REQUEST['guid']."' "),
                'main' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE trans_guid = '".$_REQUEST['guid']."' "),
                'ReferenceNo' => $_REQUEST['refno'],
                'Barcode' => '',
                'ItemCode' => '',
                'UnitMeasurement' => '',
                'Description' => '',
                //'Batch' => '1',
                'Quantity' => '',
                'guid' => $_REQUEST['guid'],
                //'add' => '1',
                'value' => '0',
                'autofocusBarcode' => 'autofocus',
                'autofocusPresetqty' => '',
                'location' => $this->db->query("SELECT code, description FROM backend.location "),

            );

            //$this->template->load('template' , 'add_item', $data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/add_item', $data);
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

    public function setup()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $data = array(
                'set_template' => $this->db->query("SELECT * FROM backend_warehouse.set_template "),

            );

            //$this->template->load('template' , 'setup', $data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/setup', $data);
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

    public function setup_create_template()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') as uuid ")->row('uuid');

            $data = array(
                //'set_template' => $this->db->query("SELECT * FROM backend_warehouse.set_template "),
                'set_template_c' => $this->db->query("SELECT * FROM backend_warehouse.set_template_c WHERE trans_guid = '$guid' ORDER BY description ASC "),
                'direction' => site_url('Productionentry_controller/setup_create_main?guid=' .$guid),
                'Code' => '',
                'Name' => '',
                'ItemCode' => '',
                'Barcode' => '',
                'Quantity' => '',
                'UnitMeasurement' => '',
                'Description' => '',
                //'Active' => '',
                'create' => '1',
                'guid' => $guid,
                'autofocusCode' => 'autofocus',
                'location' => $this->db->query("SELECT code, description from backend.location"),

            );

            //$this->template->load('template' , 'create_template', $data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/create_template', $data);
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

    public function setup_create_main()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $result_template = $this->db->query("SELECT * from backend_warehouse.set_template where code = '".$this->input->post('Code')."' ");

            if($result_template->num_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Code already exists!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Productionentry_controller/create_template");
            }
            else
            {
                /*$guid = $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') as uuid ")->row('uuid');*/
                $date = $this->db->query("SELECT NOW() as date")->row('date');

                /*if($this->input->post('Active') == 'on')
                {
                    $Active = '1';
                }
                else
                {
                    $Active = '0';
                }*/

                $info = array(
                    'trans_guid' => $_REQUEST['guid'],
                    'code' => $this->input->post('Code'),
                    'name' => $this->input->post('Name'),
                    'isactive' => '1',
                    'created_at' => $date,
                    'created_by' => $_SESSION['username'],
                    'updated_at' => $date,
                    'updated_by' => $_SESSION['username'],

                );
                $this->db->insert('backend_warehouse.set_template', $info);

                $data = array(
                    //'set_template' => $this->db->query("SELECT * FROM backend_warehouse.set_template "),
                    'set_template_c' => $this->db->query("SELECT * FROM backend_warehouse.set_template_c WHERE trans_guid = '".$_REQUEST['guid']."' ORDER BY description ASC "),
                    'direction' => site_url('Productionentry_controller/setup_scanbarcode?guid=' .$_REQUEST['guid']),
                    'Code' => $this->input->post('Code'),
                    'Name' => $this->input->post('Name'),
                    'Barcode' => '',
                    'Quantity' => '',
                    'ItemCode' => '',
                    'UnitMeasurement' => '',
                    'Description' => '',
                    //'Active' => $Active,
                    'create' => '0', //hide create
                    'guid' => $_REQUEST['guid'],
                    'autofocusBarcode' => 'autofocus',
                    'autofocusPresetqty' => '',
                    'autofocusCode' => '',

                );

                //$this->template->load('template' , 'create_template', $data);

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id, "Windows CE"))
                    {
                        /*$this->load->view('header');
                        $this->load->view('WinCe/po/po_main');
                        $this->load->view('footer');*/
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('productionentry/create_template', $data);
                        $this->load->view('footer');
                    }
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

    public function setup_scanbarcode()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $result_barcode = $this->db->query("SELECT * FROM backend.itembarcode a INNER JOIN backend.hamper_template b ON a.Itemcode = b.itemcode_h INNER JOIN backend.itemmaster c ON b.itemcode_h = c.Itemcode WHERE Barcode = '".$this->input->post('Barcode')."'  ");

            if($result_barcode->num_rows() > 0)
            {
                $result_stc = $this->db->query("SELECT * FROM backend_warehouse.set_template_c where trans_guid = '".$_REQUEST['guid']."' AND itemcode = '".$result_barcode->row('Itemcode')."' ");

                if($result_stc->num_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Item code already exists!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Productionentry_controller/setup_back?guid=" .$_REQUEST['guid']);
                }
                else
                {
                    $data = array(
                        //'set_template' => $this->db->query("SELECT * FROM backend_warehouse.set_template "),
                        'set_template_c' => $this->db->query("SELECT a.*, b.Articleno FROM backend_warehouse.set_template_c a INNER JOIN backend.itemmaster b
                            ON a.itemcode = b.Itemcode WHERE trans_guid = '".$_REQUEST['guid']."' ORDER BY description ASC "),
                        'direction' => site_url('Productionentry_controller/setup_create_child?guid=' .$_REQUEST['guid']),
                        'Code' => $this->input->post('Code'),
                        'Name' => $this->input->post('Name'),
                        'Barcode' => $this->input->post('Barcode'),
                        'Quantity' => '',
                        'ItemCode' => $result_barcode->row('Itemcode'),
                        'UnitMeasurement' => $result_barcode->row('UM'),
                        'Description' => $result_barcode->row('barDesc'),
                        //'Active' => $this->input->post('active'),
                        'create' => '2',  //show add
                        'guid' => $_REQUEST['guid'],
                        'autofocusBarcode' => '',
                        'autofocusPresetqty' => 'autofocus',
                        'autofocusCode' => '',

                    );

                    //$this->template->load('template' , 'create_template', $data);

                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id, "Windows CE"))
                        {
                            /*$this->load->view('header');
                            $this->load->view('WinCe/po/po_main');
                            $this->load->view('footer');*/
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('productionentry/create_template', $data);
                            $this->load->view('footer');
                        }
                }
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Item code or barcode not exists!<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Productionentry_controller/setup_back?guid=" .$_REQUEST['guid']);
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

    public function setup_create_child()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $check_preset_qty = $this->input->post('Quantity');

            if($check_preset_qty <= '0.00')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Preset Quantity Cannot Be 0.00 or Less Than 0.00<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect("Productionentry_controller/setup_back?guid=" .$_REQUEST['guid']);
            }
            else
            {
                $date = $this->db->query("SELECT NOW() as date")->row('date');

                $info = array(
                    'trans_guid_c' => $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') as uuid ")->row('uuid'),
                    'trans_guid' => $_REQUEST['guid'],
                    'itemcode' => $this->input->post('ItemCode'),
                    'description' => $this->input->post('Description'),
                    'um' => $this->input->post('UnitMeasurement'),
                    'preset_qty' => $this->input->post('Quantity'),
                    'created_at' => $date,
                    'created_by' => $_SESSION['username'],
                    'updated_at' => $date,
                    'updated_by' => $_SESSION['username'],

                );
                $this->db->insert('backend_warehouse.set_template_c', $info);

                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Add item successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to add item<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }

                redirect("Productionentry_controller/setup_back?guid=" .$_REQUEST['guid']);
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

    public function setup_back()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $result = $this->db->query("SELECT * FROM  backend_warehouse.set_template where trans_guid = '".$_REQUEST['guid']."' ");

            $data = array(
                //'set_template' => $this->db->query("SELECT * FROM backend_warehouse.set_template "),
                'set_template_c' => $this->db->query("SELECT a.*, b.Articleno FROM backend_warehouse.set_template_c a INNER JOIN backend.itemmaster b
                    ON a.itemcode = b.Itemcode WHERE trans_guid = '".$_REQUEST['guid']."' ORDER BY description ASC "),
                'direction' => site_url('Productionentry_controller/setup_scanbarcode?guid=' .$_REQUEST['guid']),
                'Code' => $result->row('code'),
                'Name' => $result->row('name'),
                'Barcode' => '',
                'Quantity' => '',
                'ItemCode' => '',
                'UnitMeasurement' => '',
                'Description' => '',
                //'Active' => $result->row('isactive'),
                'create' => '0', //hide create
                'guid' => $_REQUEST['guid'],
                'autofocusBarcode' => 'autofocus',
                'autofocusPresetqty' => '',
                'autofocusCode' => '',

            );

            //$this->template->load('template' , 'create_template', $data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/create_template', $data);
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

    public function setup_edit_child()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $result_st = $this->db->query("SELECT * FROM backend_warehouse.set_template WHERE trans_guid = '".$_REQUEST['guid']."' ");
            $result_stc = $this->db->query("SELECT * FROM backend_warehouse.set_template_c WHERE trans_guid_c = '".$_REQUEST['main_guid']."' ");
            $result_barcode = $this->db->query("SELECT * FROM backend.itembarcode a INNER JOIN backend.hamper_template b ON a.Itemcode = b.itemcode_h WHERE Itemcode = '".$result_stc->row('itemcode')."' ");

            $data = array(
                //'set_template' => $this->db->query("SELECT * FROM backend_warehouse.set_template "),
                'set_template_c' => $this->db->query("SELECT a.*, b.Articleno FROM backend_warehouse.set_template_c a INNER JOIN backend.itemmaster b
                    ON a.itemcode = b.Itemcode WHERE trans_guid = '".$_REQUEST['guid']."' ORDER BY description ASC "),
                'direction' => site_url('Productionentry_controller/update_setup?guid=' .$_REQUEST['guid']. '&main_guid=' .$_REQUEST['main_guid']),
                'Code' => $result_st->row('code'),
                'Name' => $result_st->row('name'),
                'Barcode' => $result_barcode->row('Barcode'),
                'Quantity' => $result_stc->row('preset_qty'),
                'ItemCode' => $result_stc->row('itemcode'),
                'UnitMeasurement' => $result_stc->row('um'),
                'Description' => $result_stc->row('description'),
                //'Active' => $result_st->row('isactive'),
                'create' => '3', //hide create
                'guid' => $_REQUEST['guid'],
                'autofocusBarcode' => '',
                'autofocusPresetqty' => 'autofocus',
                'autofocusCode' => '',

            );

            //$this->template->load('template' , 'create_template', $data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/create_template', $data);
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

    public function delete_setup()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $main_guid = $_REQUEST['main_guid'];
            $guid = $_REQUEST['guid'];
            
            $this->db->where('trans_guid_c', $main_guid);
            $this->db->delete('backend_warehouse.set_template_c');

            if($this->db->affected_rows() > 0)
            {
                $num = $this->db->query("SELECT * from backend_warehouse.set_template_c where trans_guid = '".$_REQUEST['guid']."' ")->num_rows();

                if($num == '0')
                {
                    $this->db->where('trans_guid', $guid);
                    $this->db->delete('backend_warehouse.set_template');

                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Item deleted successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                    redirect("Productionentry_controller/setup");
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Item deleted successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                    redirect("Productionentry_controller/setup_back?guid=" .$_REQUEST['guid']);
                }
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to delete item<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');

                redirect("Productionentry_controller/setup_back?guid=" .$_REQUEST['guid']);
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

    public function update_setup()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $info = array(
                'preset_qty' => $this->input->post('Quantity'),

            );
            $this->db->where('trans_guid_c', $_REQUEST['main_guid']);
            $this->db->update('backend_warehouse.set_template_c', $info);

            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update item successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Data unchanged<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }

            redirect("Productionentry_controller/setup_back?guid=" .$_REQUEST['guid']);
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

    public function setup_save()
    {
        if($this->session->userdata('loginuser') == true)
        {  
            $isactive = $this->input->post('isactive');
            $trans_guid = $this->input->post('trans_guid');
            $template_name = $this->input->post('template_name');
            
            foreach ($trans_guid as $key => $value) 
            {   
                $this->db->query("UPDATE backend_warehouse.set_template SET isactive = '$isactive[$key]', name = '$template_name[$key]' WHERE trans_guid = '$value' ");
            }
            
            redirect("Productionentry_controller/setup");
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

    public function template()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $data = array(
                'direction' => site_url('Productionentry_controller/select_template'),
                'edit_direction' => site_url('Productionentry_controller/edit_main_template'),
                'production_batch' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE type = 'template' and posted = '0' order by updated_at DESC"),
                'title' => 'TEMPLATE',

            );

            //$this->template->load('template' , 'main', $data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/main', $data);
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

    public function select_template()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $data = array(
                'set_template' => $this->db->query("SELECT * FROM backend_warehouse.set_template WHERE isactive = '1' order by name, created_at "),

            );

            //$this->template->load('template' , 'select_template', $data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/select_template', $data);
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

    public function view_template_item()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $data = array(
                'set_template_c' => $this->db->query("SELECT * FROM backend_warehouse.set_template_c WHERE trans_guid = '".$_REQUEST['guid']."' ORDER BY description ASC "),
                'main' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE trans_guid = '".$_REQUEST['guid']."' "),
                'set_master_code' => $this->db->query("SELECT * FROM backend.set_master_code WHERE code_group = 'disposal' AND TRANS_TYPE = 'ADJUST_REASON' "),
                'title' => $this->db->query("SELECT * FROM backend_warehouse.set_template WHERE trans_guid = '".$_REQUEST['guid']."' ")->row('name'),
                'guid' => $_REQUEST['guid'],
                'button_name' => 'Save',
                'location' => $this->db->query("SELECT code, description from backend.location"),
                'method' => 'ADD',

            );

            //$this->template->load('template' , 'view_template', $data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/view_template', $data);
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

    public function edit_main_template()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $data = array(
                'set_template_c' => $this->db->query("SELECT * FROM backend_warehouse.production_batch_c WHERE trans_guid = '".$_REQUEST['guid']."' "),
                'main' => $this->db->query("SELECT * FROM backend_warehouse.production_batch WHERE trans_guid = '".$_REQUEST['guid']."' "),
                'set_master_code' => $this->db->query("SELECT * FROM backend.set_master_code WHERE code_group = 'disposal' AND TRANS_TYPE = 'ADJUST_REASON' "),
                'title' => $this->db->query("SELECT * FROM backend_warehouse.set_template WHERE trans_guid = '".$_REQUEST['cross_refno']."' ")->row('name'),
                'guid' => $_REQUEST['guid'],
                'edit' => 'done',
                'button_name' => 'Save',
                'location' => $this->db->query("SELECT code, description from backend.location"),
                'method' => 'EDIT',

            );

            //$this->template->load('template' , 'add_item', $data);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id, "Windows CE"))
                {
                    /*$this->load->view('header');
                    $this->load->view('WinCe/po/po_main');
                    $this->load->view('footer');*/
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('productionentry/view_template', $data);
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

    public function submit_template()
    {
        if($this->session->userdata('loginuser') == true)
        {
            if($this->input->post('method') == 'ADD')
            {
                /*if($this->input->post('location') == '')
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Please select location<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                    redirect("Productionentry_controller/view_template_item?guid=" .$_REQUEST['guid']);
                };*/

                $current = $this->db->query("SELECT DATE_FORMAT(CURDATE(), '%Y-%m') as date")->row('date');
                $month = $this->db->query("SELECT DATE_FORMAT(run_date, '%Y-%m') as date FROM backend_warehouse.set_sysrun WHERE run_type = 'ITEM' ")->row('date');

                if($current != $month)
                {
                    $value = array(
                        'run_date' => $this->db->query("SELECT CURDATE() AS date")->row('date'),
                        'run_currentno' => '0',

                    );
                    $this->db->where('run_type', 'ITEM');
                    $this->db->update('backend_warehouse.set_sysrun', $value);
                };

                $code = $this->db->query("SELECT locgroup from backend.location limit 1")->row('locgroup');
                $result = $this->db->query("SELECT * from backend_warehouse.set_sysrun where run_type = 'ITEM' ");
                $date = $this->db->query("SELECT NOW() as date")->row('date');
                $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') as uuid ")->row('uuid');
                $refno = $this->db->query("SELECT CONCAT('".$code."', '".$result->row('run_code')."', RIGHT(LEFT(REPLACE(CURDATE(), '-', ''), 6), 4), LPAD('".$result->row('run_currentno')."', '".$result->row('run_digit')."', '0')) AS pad ")->row('pad');

                $info = array(
                    'trans_guid' => $guid,
                    'refno' => $refno,
                    'location' => $this->input->post('location'),
                    'locgroup' => $this->db->query("SELECT locgroup from backend.location where code = '".$this->input->post('location')."'")->row('locgroup'),
                    'type' => 'Template',
                    'docdate' => $this->db->query("SELECT CURDATE() as date")->row('date'),
                    /*'docno' => '',*/
                    'cross_refno' => $_REQUEST['guid'],
                    'posted' => '0',
                    'posted_at' => $date,
                    'posted_by' => $_SESSION['username'],
                    'created_at' => $date,
                    'created_by' => $_SESSION['username'],
                    'updated_at' => $date,
                    'updated_by' => $_SESSION['username'],

                );
                $this->db->insert('backend_warehouse.production_batch', $info);

                if($this->db->affected_rows() > 0)
                {
                    $infomation = array(
                        'run_currentno' => $result->row('run_currentno') + 1,

                    );
                    $this->db->where('run_type', 'ITEM');
                    $this->db->update('backend_warehouse.set_sysrun', $infomation);
                };

                $result_stc = $this->db->query("SELECT * from backend_warehouse.set_template_c where trans_guid = '".$_REQUEST['guid']."' ");
                $batch = $this->input->post('batch');
                $expectedqty = $this->input->post('expectedqty');
                $quantity = $this->input->post('quantity');
                $variance = $this->input->post('variance');
                $reason = $this->input->post('reason');

                foreach($result_stc->result() as $row => $value) 
                {
                    $variable[] = $value;
                }

                foreach($batch as $row => $value) 
                {
                    //$result_qty = ($variable[$row]->preset_qty * $value) - ($quantity[$row]);

                    $pbc = array(
                        'trans_guid_c' => $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') as uuid ")->row('uuid'),
                        'trans_guid' => $guid,
                        'itemcode' => $variable[$row]->itemcode,
                        'description' => $variable[$row]->description,
                        'um' => $variable[$row]->um,
                        'preset_qty' => $variable[$row]->preset_qty,
                        'batch' => $value,
                        'expected_qty' => $expectedqty[$row],
                        'actual_qty' => $quantity[$row],
                        'variance' => $variance[$row],
                        'reason' => $reason[$row],
                        'created_at' => $date,
                        'created_by' => $_SESSION['username'],
                        'updated_at' => $date,
                        'updated_by' => $_SESSION['username'],

                    );
                    $this->db->insert('backend_warehouse.production_batch_c', $pbc);
                }

                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Add items of template successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
            }
            elseif($this->input->post('method') == 'EDIT')
            {
                //$result_stc = $this->db->query("SELECT * from backend_warehouse.set_template_c where trans_guid = '".$_REQUEST['guid']."' ");
                $date = $this->db->query("SELECT NOW() as date")->row('date');
                $variance = $this->input->post('variance');
                $batch = $this->input->post('batch');
                $expectedqty = $this->input->post('expectedqty');
                $quantity = $this->input->post('quantity');
                $tgc = $this->input->post('tgc');
                $reason = $this->input->post('reason');
                $location  =  $this->input->post('location');
                $trans_guid = $_REQUEST['guid'];


                $prev_data = $this->db->query("SELECT * from backend_warehouse.production_batch where trans_guid = '$trans_guid'");
                if($prev_data->row('location') != $this->input->post('location'))
                {
                    $production_batch_locgroup =  $this->db->query("SELECT locgroup from backend.location where code = '$location'")->row('locgroup');
                    $this->db->query("UPDATE backend_warehouse.production_batch set location = '$location', locgroup = '$production_batch_locgroup' where trans_guid = '$trans_guid'");
                };


                /*foreach($result_stc->result() as $row => $value) 
                {
                    $variable[] = $value;
                }*/

                foreach($batch as $row => $value) 
                {
                    //$result_qty = ($variable[$row]->preset_qty * $value) - ($quantity[$row]);

                    $pbc = array(
                        'batch' => $value,
                        'expected_qty' => $expectedqty[$row],
                        'actual_qty' => $quantity[$row],
                        'variance' => $variance[$row],
                        'reason' => $reason[$row],
                        'updated_at' => $date,
                        'updated_by' => $_SESSION['username'],

                    );
                    $this->db->where('trans_guid_c', $tgc[$row]);
                    $this->db->update('backend_warehouse.production_batch_c', $pbc);
                }

                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Update items of template successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Items unchanged<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
            }

            redirect('Productionentry_controller/template');
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

    public function post_template()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $date = $this->db->query("SELECT NOW() as date")->row('date');

            $checking_location = $this->db->query("SELECT refno, location from backend_warehouse.production_batch where trans_guid = '".$_REQUEST['guid']."'");
            if($checking_location->row('location') == '')
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to post. Location not found for RefNo : '.$checking_location->row("refno").'  <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Productionentry_controller/template');
            };

            $check_batch_child = $this->db->query("SELECT * FROM (
                SELECT * FROM backend_warehouse.`production_batch_c`
                WHERE trans_guid = '".$_REQUEST['guid']."' 
                AND actual_qty <> '0.00'
                UNION ALL
                SELECT * FROM backend_warehouse.`production_batch_c`
                WHERE trans_guid = '".$_REQUEST['guid']."' 
                AND batch <> '0.00' ) a;");

            if($check_batch_child->num_rows() == 0 )
            {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail To Post. Total Actual Quantity 0 <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                redirect('Productionentry_controller/template');
            }
            else
            {
                 
                $infomation = array(
                    'posted' => '1',
                    'posted_at' => $date,
                    'posted_by' => $_SESSION['username'],
                    'updated_at' => $date,
                    'updated_by' => $_SESSION['username'],

                );

                $this->db->where('trans_guid', $_REQUEST['guid']);
                $this->db->update('backend_warehouse.production_batch', $infomation);

                if($this->db->affected_rows() > 0)
                {
                    $year = $this->db->query("SELECT right(year(now()),2) as year")->row('year');
                    $month = $this->db->query("SELECT lpad(month(now()),2,0) as month")->row('month');
                    $run_no = $this->db->query("SELECT  IFNULL(MAX(LPAD(RIGHT(refno,4)+1,4,0)),LPAD(1,4,0)) AS runno  FROM backend.transform_entry WHERE loc_group = '".$_SESSION['location']."' AND SUBSTRING(refno,-8,4) = CONCAT(RIGHT(YEAR(NOW()),2),LPAD(MONTH(NOW()),2,0))")->row('runno');
                    $doccode = $this->db->query("SELECT code from backend.sysrun where type = 'TPD' ")->row('code');
                    $refno = $this->db->query("SELECT concat('$doccode', '$year', '$month', '$run_no' ) as refno")->row('refno');
                    //$_SESSION['refno'] = $refno;

                    $this->db->query("update backend.sysrun set currentno = currentno +1 where type = 'TPD' ");

                    $info = array(
                        'transform_guid' => $_REQUEST['guid'],
                        'RefNo' => $refno,
                        'DocDate' => $date,
                        'Remark' => $this->db->query("SELECT * from backend_warehouse.production_batch where trans_guid = '".$_REQUEST['guid']."' ")->row('refno'),
                        'posted' => '0',
                        'posted_at' => $date,
                        'created_at' => $date,
                        'created_by' => $_SESSION['username'],
                        'updated_at' => $date,
                        'updated_by' => $_SESSION['username'],
                        'location' => $this->db->query("SELECT * from backend_warehouse.production_batch where trans_guid = '".$_REQUEST['guid']."' ")->row('location'),
                        'loc_group' => $this->db->query("SELECT * from backend_warehouse.production_batch where trans_guid = '".$_REQUEST['guid']."' ")->row('locgroup'),

                    );

                    $this->db->insert('backend.transform_entry', $info);

                    $pbc = $this->db->query("SELECT * from backend_warehouse.production_batch_c where trans_guid = '".$_REQUEST['guid']."' AND actual_qty <> '0.00'");

                    foreach($pbc->result() as $row => $value)
                    {
                        $informations = array(
                            'detail_guid' => $this->db->query("SELECT REPLACE(UPPER(UUID()), '-', '') as uuid ")->row('uuid'),
                            'transform_guid' => $_REQUEST['guid'],
                            'itemcode' => $value->itemcode,
                            'description' => $value->description,
                            'qty' => $value->actual_qty,
                            'um' => $value->um,
                            'created_at' => $date,
                            'created_by' => $_SESSION['username'],
                            'updated_at' => $date,
                            'updated_by' => $_SESSION['username'],
                            'transform_template' => $this->db->query("SELECT template FROM backend.hamper_template WHERE itemcode_h = '$value->itemcode' ")->row('template'),
                            //'hamper_line' => $_SESSION['username'],
                            //'hamper_type' => $_SESSION['username'],
                            'adjust_type' => $this->db->query("SELECT adjust_type FROM backend.hamper_template WHERE itemcode_h = '$value->itemcode' ")->row('adjust_type'),

                        );

                        $this->db->insert('backend.transform_entry_c', $informations);
                    }

                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" style="font-size: 18px">Item posted successfully<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center" style="font-size: 18px">Fail to post item<button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br></div>');
                }

            }
            redirect("Productionentry_controller/template");
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
