<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class submitdoc_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('submitdoc_model');
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
		$browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/submitdoc/header');
            $this->load->view('WinCe/submitdoc/index');
        }

        else  
         {
            $this->load->view('submitdoc/header');
            $this->load->view('submitdoc/index');
            $this->load->view('submitdoc/footer');
         } 
	}

    public function backhome()
    {
        redirect('submitdoc_controller/home');
    }

    public function send_print()
    {
        $sl_guid = $_REQUEST['guid']; 

        $this->db->query("UPDATE backend_warehouse.sl_child SET send_print = '1' WHERE sl_guid = '$sl_guid'");
        if($this->db->affected_rows() > 0)
        {
            $this->db->query("UPDATE backend_warehouse.sl_main SET send_print = '1', print_at = NOW() WHERE sl_guid = '$sl_guid'");
            $this->session->set_flashdata('message', 'Succesfully Print: '.$_REQUEST['refno']);
                redirect('submitdoc_controller/transaction');
        }
        else
        {
            $this->session->set_flashdata('message', 'Failed Print: '.$_REQUEST['refno']);
                redirect('submitdoc_controller/transaction');
        }
        
    }

    public function delete_child()
    {
        $sl_guid_c = $_REQUEST['guid_c']; 
        $this->db->query("DELETE from backend_warehouse.sl_child where sl_guid_c = '$sl_guid_c' ");
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('message', 'Succesfully Delete: '.$_REQUEST['trans_refno']);
                redirect('submitdoc_controller/transaction_result?guid='.$_REQUEST['sl_guid']);
        }
        else
        {
            $this->session->set_flashdata('message', 'Failed Delete: '.$_REQUEST['trans_refno']);
                redirect('submitdoc_controller/transaction_resultguid='.$_REQUEST['sl_guid']);
        }
    }

    public function declare_session()
    {
        $userid = $this->input->post('userid');

        $user_ID_Data = array(
                                      
            'userid' => $userid   
            );
        $this->session->set_userdata($user_ID_Data);
        redirect('submitdoc_controller/transaction');
    }


    public function transaction()
    {
       
        $data = array(
            'result' => $this->db->query("SELECT * from backend_warehouse.sl_main order by created_at desc"),
            );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/submitdoc/header');
            $this->load->view('WinCe/submitdoc/transaction',$data);
        }

        else
        {
            $this->load->view('submitdoc/header');
            $this->load->view('submitdoc/transaction',$data);
            $this->load->view('submitdoc/footer');     
        }
       
    }

    public function transaction_result()
    {
        $sl_guid = $_REQUEST['guid']; 
        $data = array(
            'result' => $this->db->query("SELECT * FROM backend_warehouse.`sl_child` 
                WHERE sl_guid = '$sl_guid'"),
            );


        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/submitdoc/header');
            $this->load->view('WinCe/submitdoc/transaction_result',$data);
        }
        else
        {
            $this->load->view('submitdoc/header');
            $this->load->view('submitdoc/transaction_result',$data);
            $this->load->view('submitdoc/footer');
        }
       
    }

    public function insertMain()
    {
        $datetime = $this->db->query("SELECT NOW() AS datetime");
        $date = $this->db->query("SELECT CURDATE() as date");
        $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid");
        $location = $this->db->query("SELECT locgroup_branch AS location FROM backend.companyprofile ");

        $check_sysrun = $this->db->query("SELECT * from backend_warehouse.set_sysrun where run_type='SUBMISSIONLIST'");

        if($check_sysrun->row('run_date') == '')
        {
            $data = array(

                'run_type' => 'SUBMISSIONLIST',
                'run_code' => 'SL',
                'run_year' => $this->db->query("SELECT YEAR(CURRENT_TIMESTAMP) as year")->row('year'),
                'run_month' => $this->db->query("SELECT MONTH(CURRENT_TIMESTAMP) as month")->row('month'),
                'run_day' => $this->db->query("SELECT DAY(CURRENT_TIMESTAMP) as day")->row('day'),
                'run_date' => $date->row('date'),
                'run_currentno' => '0',
                'run_digit' => '4',
                );
            $this->submitdoc_model->insert_sysrun($data);
            $get_run_date = $this->db->query("SELECT * from backend_warehouse.set_sysrun where run_type='SUBMISSIONLIST'");
        };

        if($check_sysrun->row('run_date') < $date->row('date'))
        {
            $data= array(
                'run_date' => $date->row('date'),
                'run_currentno' => 1,
                );
            $this->submitdoc_model->update_sysrun($data);
        }
        else
        {
            $data= array(
                'run_currentno' => $check_sysrun->row('run_currentno')+1,
                );
            $this->submitdoc_model->update_sysrun($data);
        }

        $getRefNo = $this->db->query("SELECT CONCAT((SELECT locgroup_branch FROM backend.companyprofile ) ,run_code, LEFT(REPLACE(run_date, '-', ''), 6), REPEAT(0,run_digit-LENGTH(run_currentno + 1)), run_currentno) AS refno FROM backend_warehouse.set_sysrun WHERE run_type = 'SUBMISSIONLIST' ");

        $dataMain = array(
            'sl_guid' => $guid->row('guid'),
            'refno' => $getRefNo->row('refno'),
            'location' => $location->row('location'),
            'created_at' =>$datetime->row('datetime'),
            'created_by' =>$_SESSION['userid'],
            'updated_at' =>$datetime->row('datetime'),
            'updated_by' =>$_SESSION['userid'],
            );
        $this->submitdoc_model->insert_dataMain($dataMain);
        $this->session->set_flashdata('message', 'New record insert.');
        redirect('submitdoc_controller/menu?guid='.$guid->row('guid'));
    }

    public function menu()
    {
        $data = array(

            'result' => $this->db->query('SELECT * FROM backend_warehouse.sl_menu where hide_menu = 0 order by Sequence asc'),
            );

         $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/submitdoc/header');
            $this->load->view('WinCe/submitdoc/menu',$data);
        }
        else
        {
            $this->load->view('submitdoc/header');
            $this->load->view('submitdoc/menu',$data);
            $this->load->view('submitdoc/footer');
        }
        
    }


    public function scanbarcode()
    {
        $type = $_REQUEST['type'];
        $_SESSION['type'] = $_REQUEST['type'];
        $_SESSION['sl_guid'] = $_REQUEST['sl_guid'];
        
        if($type == 'GRN_or_GRDA')
        {
            $data = array(
                'form_action' => site_url('submitdoc_controller/GRN_or_GRDA'),
                'guid' => $_SESSION['sl_guid'],
                'title' => 'GRN / GRDA',
            );


        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/submitdoc/header');
            $this->load->view('WinCe/submitdoc/scanbarcode',$data);
        }

        else
        {
            $this->load->view('submitdoc/header');
            $this->load->view('submitdoc/scanbarcode', $data);
            $this->load->view('submitdoc/footer');
        }
            
        };

        if($type == 'DN_or_CN')
        {
            $data = array(
                'form_action' => site_url('submitdoc_controller/DN_or_CN'),
                'guid' => $_SESSION['sl_guid'],
                'title' => 'Purchase Return DN/CN & Purchase Amt DN/CN',
            );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/submitdoc/header');
            $this->load->view('WinCe/submitdoc/scanbarcode',$data);
        }

        else
        {
            $this->load->view('submitdoc/header');
            $this->load->view('submitdoc/scanbarcode', $data);
            $this->load->view('submitdoc/footer');
        }
        };

        if($type == 'SI')
        {
            $data = array(
                'form_action' => site_url('submitdoc_controller/SI'),
                'guid' => $_SESSION['sl_guid'],
                'title' => 'Sales Invoice',
            );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/submitdoc/header');
            $this->load->view('WinCe/submitdoc/scanbarcode',$data);
        }

        else
        {
            $this->load->view('submitdoc/header');
            $this->load->view('submitdoc/scanbarcode', $data);
            $this->load->view('submitdoc/footer');
        }
        };

        if($type == 'SIDN_or_SICN')
        {
            $data = array(
                'form_action' => site_url('submitdoc_controller/SIDN_or_SICN'),
                'guid' => $_SESSION['sl_guid'],
                'title' => 'Sales Invoice CN/DN & Sales Amt DN/CN',
            );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/submitdoc/header');
            $this->load->view('WinCe/submitdoc/scanbarcode',$data);
        }

        else
        {
            $this->load->view('submitdoc/header');
            $this->load->view('submitdoc/scanbarcode', $data);
            $this->load->view('submitdoc/footer');
        }

        };

        if($type == 'DI')
        {
            $data = array(
                'form_action' => site_url('submitdoc_controller/DI'),
                'guid' => $_SESSION['sl_guid'],
                'title' => 'Display Incentive',
            ); 
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/submitdoc/header');
            $this->load->view('WinCe/submitdoc/scanbarcode',$data);
        }

        else
        {
            $this->load->view('submitdoc/header');
            $this->load->view('submitdoc/scanbarcode', $data);
            $this->load->view('submitdoc/footer');
        }

        };

        if($type == 'PCI')
        {
            $data = array(
                'form_action' => site_url('submitdoc_controller/PCI'),
                'guid' => $_SESSION['sl_guid'],
                'title' => 'Promo Claim Invoice',
            );
           
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/submitdoc/header');
            $this->load->view('WinCe/submitdoc/scanbarcode',$data);
        }

        else
        {
            $this->load->view('submitdoc/header');
            $this->load->view('submitdoc/scanbarcode', $data);
            $this->load->view('submitdoc/footer');
        }

        };
        
    }

    public function GRN_or_GRDA()
    {
        $barcode = $this->input->post('barcode');

        $check_record = $this->db->query("SELECT * from backend_warehouse.sl_child where trans_refno = '$barcode' ");

        if($check_record->num_rows() > 0)
        {
            $this->session->set_flashdata('message', 'Reference Number already scanned.');
            redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
        }
        else
        {
            $check_barcode = $this->db->query("SELECT refno, location, doc_no, inv_no, doc_date, doc_type, grdate, issuestamp, CODE, NAME, total, gst_tax_sum, total_include_tax as total_include_tax, postdatetime
                FROM
                (SELECT refno, location, dono AS doc_no, invno AS inv_no, docdate AS doc_date, 'GRN' AS doc_type,  grdate, issuestamp, CODE, NAME, total, gst_tax_sum , total_include_tax+gst_adj+rounding_adj as total_include_tax, postdatetime FROM grmain WHERE refno = '$barcode' AND billstatus = '1'

                UNION ALL

                SELECT a.refno, location , sup_cn_no AS  doc_no, '' AS inv_no, sup_cn_date AS doc_date, 'GRDA' AS doc_type, '' AS grdate, created_at AS issuestamp, CODE, NAME, varianceamt AS total, a.gst_tax_sum, varianceamt+a.gst_tax_sum+a.gst_adjust+a.rounding_adj AS total_include_tax, a.created_at AS postdatetime FROM
                    grmain_dncn AS a INNER JOIN grmain AS b ON a.refno = b.refno WHERE a.refno = '$barcode' AND billstatus = '1')a");

            if ($check_barcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Document Not Found/Posted');
                redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
            }
            else
            {
                $trans_refno = $check_barcode->row('refno');
                $location = $check_barcode->row('location');
                $doc_type = $check_barcode->row('doc_type');
                $doc_no = $check_barcode->row('doc_no');
                $inv_no = $check_barcode->row('inv_no');
                $doc_date = $check_barcode->row('doc_date');
                $grdate = $check_barcode->row('grdate');
                $CODE = $check_barcode->row('CODE');
                $NAME = $check_barcode->row('NAME');
                $total = $check_barcode->row('total');
                $gst_tax_sum = $check_barcode->row('gst_tax_sum');
                $total_include_tax = $check_barcode->row('total_include_tax');
                    
                $issuestamp = $check_barcode->row('issuestamp');
                $postdatetime = $check_barcode->row('postdatetime');
                
                if($check_barcode->num_rows() > 1)
                {
                    $this->submitdoc_model->insert_dataChild_array($check_barcode);
                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', 'Done.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Failed.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                }
                
                else
                {
                    $this->submitdoc_model->insert_dataChild($trans_refno, $location, $doc_type, $doc_no, $inv_no, $doc_date, $grdate, $CODE, $NAME, $total, $total_include_tax, $gst_tax_sum, $issuestamp, $postdatetime);
                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', 'Done.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Failed.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                }
                
            }
        }
        
    }


    public function DN_or_CN()
    {
        $barcode = $this->input->post('barcode');

        $check_record = $this->db->query("SELECT * from backend_warehouse.sl_child where trans_refno = '$barcode' ");

        if($check_record->num_rows() > 0)
        {
            $this->session->set_flashdata('message', 'Reference Number already scanned.');
            redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
        }
        else
        {
            $check_barcode = $this->db->query("SELECT refno, location, CONCAT(TYPE, '-', SCTYPE) AS doc_type, docno AS doc_no, pono as inv_no, docdate AS doc_date, '' as gr_date,   CODE, NAME, amount AS total, gst_tax_sum , amount+gst_tax_sum+gst_adj+rounding_adj as total_include_tax, issuestamp,   postdatetime
                FROM backend.dbnotemain WHERE refno =  '$barcode'
                AND billstatus = '1' AND sctype = 'S'
                
                UNION ALL
                
                SELECT refno, location, CONCAT(TYPE, '-', SCTYPE) AS doc_type, docno AS doc_no, pono as inv_no,  docdate AS doc_date, '' as gr_date,CODE, NAME, amount AS total, gst_tax_sum , amount+gst_tax_sum+gst_adj+rounding_adj as total_include_tax, issuestamp, postdatetime
                FROM backend.cnnotemain WHERE refno =  '$barcode'
                AND billstatus = '1' AND sctype = 'S'
                
                UNION ALL
                
                SELECT refno, location,  trans_type AS doc_type, docno AS doc_no, sup_cn_no as inv_no, docdate AS doc_date, '' as gr_date, CODE, NAME,  amount AS total, gst_tax_sum, amount_include_tax+gst_adj+rounding_adj as total_include_tax, created_at AS issuestamp,  posted_at AS postdatetime
                FROM backend.cndn_amt WHERE refno =  '$barcode'
                AND posted = '1' AND trans_type IN ('PDNAMT','PCNAMT')
                
                UNION ALL
                
                SELECT refno, location, 'MARKDOWN' AS doc_type,  docno AS doc_no, sup_cn_no as inv_no, docdate AS doc_date, '' as gr_date, CODE, NAME,  amount AS total, gst_tax_sum, amount+gst_tax_sum+gst_adj+rounding_adj as total_include_tax, issuestamp,  postdatetime
                FROM backend.markdownamtmain WHERE refno =  '$barcode'
                AND billstatus = '1' ");

            if ($check_barcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Document Not Found/Posted. Please check document status');
                redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
            }
            else
            {
                $trans_refno = $check_barcode->row('refno');
                $location = $check_barcode->row('location');
                $doc_type = $check_barcode->row('doc_type');
                $doc_no = $check_barcode->row('doc_no');
                $inv_no = $check_barcode->row('inv_no');
                $doc_date = $check_barcode->row('doc_date');
                $grdate = $check_barcode->row('grdate');
                $CODE = $check_barcode->row('CODE');
                $NAME = $check_barcode->row('NAME');
                $total = $check_barcode->row('total');
                $gst_tax_sum = $check_barcode->row('gst_tax_sum');
                $total_include_tax = $check_barcode->row('total_include_tax');
                    
                $issuestamp = $check_barcode->row('issuestamp');
                $postdatetime = $check_barcode->row('postdatetime');
                
                if($check_barcode->num_rows() > 1)
                {
                    $this->submitdoc_model->insert_dataChild_array($check_barcode);
                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', 'Done.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Failed.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                }
                
                else
                {
                    $this->submitdoc_model->insert_dataChild($trans_refno, $location, $doc_type, $doc_no, $inv_no, $doc_date, $grdate, $CODE, $NAME, $total, $total_include_tax, $gst_tax_sum, $issuestamp, $postdatetime);
                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', 'Done.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Failed.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                }
                
            }
        }
        
    }

    public function SI()
    {
        $barcode = $this->input->post('barcode');

        $check_record = $this->db->query("SELECT * from backend_warehouse.sl_child where trans_refno = '$barcode' ");

        if($check_record->num_rows() > 0)
        {
            $this->session->set_flashdata('message', 'Reference Number already scanned.');
            redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
        }
        else
        {
            $check_barcode = $this->db->query("SELECT refno , loc_group AS location, 'SI' AS doc_type, docno AS doc_no, '' as inv_no, invoicedate as doc_date, '' as grdate,  CODE, NAME, total, gst_tax_sum,  total_include_tax+gst_adj as total_include_tax,  issuestamp, postdatetime FROM backend.simain WHERE refno = '$barcode' AND billstatus = '1'");

            if ($check_barcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Document Not Found/Posted');
                redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
            }
            else
            {
                $trans_refno = $check_barcode->row('refno');
                $location = $check_barcode->row('location');
                $doc_type = $check_barcode->row('doc_type');
                $doc_no = $check_barcode->row('doc_no');
                $inv_no = $check_barcode->row('inv_no');
                $doc_date = $check_barcode->row('doc_date');
                $grdate = $check_barcode->row('grdate');
                $CODE = $check_barcode->row('CODE');
                $NAME = $check_barcode->row('NAME');
                $total = $check_barcode->row('total');
                $gst_tax_sum = $check_barcode->row('gst_tax_sum');
                $total_include_tax = $check_barcode->row('total_include_tax');
                    
                $issuestamp = $check_barcode->row('issuestamp');
                $postdatetime = $check_barcode->row('postdatetime');
                
                if($check_barcode->num_rows() > 1)
                {
                    $this->submitdoc_model->insert_dataChild_array($check_barcode);
                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', 'Done.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Failed.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                }
                
                else
                {
                    $this->submitdoc_model->insert_dataChild($trans_refno, $location, $doc_type, $doc_no, $inv_no, $doc_date, $grdate, $CODE, $NAME, $total, $total_include_tax, $gst_tax_sum, $issuestamp, $postdatetime);
                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', 'Done.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Failed.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                }
                
            }
        }
        
    }


    public function SIDN_or_SICN()
    {
        $datetime = $this->db->query("SELECT NOW() AS datetime");
        $date = $this->db->query("SELECT CURDATE() as date");
        $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid");

        $barcode = $this->input->post('barcode');

        $check_rec = $this->db->query("SELECT * from backend_warehouse.sl_child where trans_refno = '$barcode'");
        
        if ($check_rec->num_rows() != 0)
        {
            $this->session->set_flashdata('message', 'Reference Number already scanned.');
            redirect('submitdoc_controller/scanbarcode?guid='.$_SESSION['sl_guid']);
        }
        else 
        {  

            $check_barcode = $this->db->query("SELECT refno, location, CONCAT(TYPE, '-', SCTYPE) AS doc_type, docno AS doc_no, pono AS inv_no, docdate AS doc_date, '' AS gr_date,   CODE, NAME, amount AS total, gst_tax_sum , amount+gst_tax_sum+gst_adj+rounding_adj AS total_include_tax, issuestamp,   postdatetime
                FROM backend.dbnotemain WHERE refno =  '$barcode'
                AND billstatus = '1' AND sctype = 'C'
                
                UNION ALL
                
                SELECT refno, location, CONCAT(TYPE, '-', SCTYPE) AS doc_type, docno AS doc_no, pono AS inv_no,  docdate AS doc_date, '' AS gr_date,CODE, NAME, amount AS total, gst_tax_sum , amount+gst_tax_sum+gst_adj+rounding_adj AS total_include_tax, issuestamp, postdatetime
                FROM backend.cnnotemain WHERE refno =  '$barcode'
                AND billstatus = '1' AND sctype = 'C'
                
                UNION ALL
                
                SELECT refno, location,  trans_type AS doc_type, docno AS doc_no, sup_cn_no AS inv_no, docdate AS doc_date, '' AS gr_date, CODE, NAME,  amount AS total, gst_tax_sum, amount_include_tax+gst_adj+rounding_adj AS total_include_tax, created_at AS issuestamp,  posted_at AS postdatetime
                FROM backend.cndn_amt WHERE refno =  '$barcode'
                AND posted = '1' AND trans_type IN  ('SDNAMT','SCNAMT')");

            if ($check_barcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Document Not Found/Posted');
                redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
            }
            else
            {
                $trans_refno = $check_barcode->row('refno');
                $location = $check_barcode->row('location');
                $doc_type = $check_barcode->row('doc_type');
                $doc_no = $check_barcode->row('doc_no');
                $inv_no = $check_barcode->row('inv_no');
                $doc_date = $check_barcode->row('doc_date');
                $grdate = $check_barcode->row('grdate');
                $CODE = $check_barcode->row('CODE');
                $NAME = $check_barcode->row('NAME');
                $total = $check_barcode->row('total');
                $gst_tax_sum = $check_barcode->row('gst_tax_sum');
                $total_include_tax = $check_barcode->row('total_include_tax');
                    
                $issuestamp = $check_barcode->row('issuestamp');
                $postdatetime = $check_barcode->row('postdatetime');
                
                if($check_barcode->num_rows() > 1)
                {
                    $this->submitdoc_model->insert_dataChild_array($check_barcode);
                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', 'Done.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Failed.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                }
                
                else
                {
                    $this->submitdoc_model->insert_dataChild($trans_refno, $location, $doc_type, $doc_no, $inv_no, $doc_date, $grdate, $CODE, $NAME, $total, $total_include_tax, $gst_tax_sum, $issuestamp, $postdatetime);
                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', 'Done.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Failed.');
                        redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                    }
                }
                
            }
        }
    }   

    public function DI()
        {
            $datetime = $this->db->query("SELECT NOW() AS datetime");
            $date = $this->db->query("SELECT CURDATE() as date");
            $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid");
    
            $barcode = $this->input->post('barcode');
    
            $check_rec = $this->db->query("SELECT * from backend_warehouse.sl_child where trans_refno = '$barcode'");
            
            if ($check_rec->num_rows() != 0)
            {
                $this->session->set_flashdata('message', 'Reference Number already scanned.');
                redirect('submitdoc_controller/scanbarcode?guid='.$_SESSION['sl_guid']);
            }
            else 
            {  
    
                $check_barcode = $this->db->query("SELECT a.refno, a.loc_group AS location, 'DISP' AS doc_type, a.docdate AS doc_date, inv_refno AS inv_no,'' AS gr_date
                    , sup_code AS CODE, sup_name AS NAME, total_bf_tax AS total, gst_value AS gst_tax_sum, total_af_tax+gst_adj+rounding_adj AS total_include_tax
                    , issuestamp, posted_at AS postdatetime 
                    FROM backend.discheme_taxinv AS a
                    INNER JOIN backend.dischememain AS b
                    ON a.refno = b.refno
                    WHERE b.billstatus = '1' AND a.posted = '1'
                    AND a.refno = '$barcode'
                    ORDER BY created_at DESC");
    
                if ($check_barcode->num_rows() == 0)
                {
                    $this->session->set_flashdata('message', 'Document Not Found/Posted');
                    redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                }
                else
                {
                    $trans_refno = $check_barcode->row('refno');
                    $location = $check_barcode->row('location');
                    $doc_type = $check_barcode->row('doc_type');
                    $doc_no = $check_barcode->row('doc_no');
                    $inv_no = $check_barcode->row('inv_no');
                    $doc_date = $check_barcode->row('doc_date');
                    $grdate = $check_barcode->row('grdate');
                    $CODE = $check_barcode->row('CODE');
                    $NAME = $check_barcode->row('NAME');
                    $total = $check_barcode->row('total');
                    $gst_tax_sum = $check_barcode->row('gst_tax_sum');
                    $total_include_tax = $check_barcode->row('total_include_tax');
                        
                    $issuestamp = $check_barcode->row('issuestamp');
                    $postdatetime = $check_barcode->row('postdatetime');
                    
                    if($check_barcode->num_rows() > 1)
                    {
                        $this->submitdoc_model->insert_dataChild_array($check_barcode);
                        if($this->db->affected_rows() > 0)
                        {
                            $this->session->set_flashdata('message', 'Done.');
                            redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                        }
                        else
                        {
                            $this->session->set_flashdata('message', 'Failed.');
                            redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                        }
                    }
                    
                    else
                    {
                        $this->submitdoc_model->insert_dataChild($trans_refno, $location, $doc_type, $doc_no, $inv_no, $doc_date, $grdate, $CODE, $NAME, $total, $total_include_tax, $gst_tax_sum, $issuestamp, $postdatetime);
                        if($this->db->affected_rows() > 0)
                        {
                            $this->session->set_flashdata('message', 'Done.');
                            redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                        }
                        else
                        {
                            $this->session->set_flashdata('message', 'Failed.');
                            redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                        }
                    }
                    
                }
            }
        }   

    public function PCI()
        {
            $datetime = $this->db->query("SELECT NOW() AS datetime");
            $date = $this->db->query("SELECT CURDATE() as date");
            $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid");
    
            $barcode = $this->input->post('barcode');
    
            $check_rec = $this->db->query("SELECT * from backend_warehouse.sl_child where trans_refno = '$barcode'");
            
            if ($check_rec->num_rows() != 0)
            {
                $this->session->set_flashdata('message', 'Reference Number already scanned.');
                redirect('submitdoc_controller/scanbarcode?guid='.$_SESSION['sl_guid']);
            }
            else 
            {  
    
                $check_barcode = $this->db->query("SELECT refno, loc_group AS location, promo_refno AS doc_no, inv_refno AS inv_no, docdate AS doc_date, 'PROMOINV' AS doc_type, '' AS grdate
                    , created_at AS issuestamp, sup_code AS CODE, sup_name AS NAME, total_bf_tax AS total, gst_value AS gst_tax_sum, total_net AS total_include_tax
                    , posted_at AS postdatetime
                    FROM backend.promo_taxinv
                    WHERE posted = '1'
                    AND refno = '$barcode'");
    
                if ($check_barcode->num_rows() == 0)
                {
                    $this->session->set_flashdata('message', 'Document Not Found/Posted');
                    redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                }
                else
                {
                    $trans_refno = $check_barcode->row('refno');
                    $location = $check_barcode->row('location');
                    $doc_type = $check_barcode->row('doc_type');
                    $doc_no = $check_barcode->row('doc_no');
                    $inv_no = $check_barcode->row('inv_no');
                    $doc_date = $check_barcode->row('doc_date');
                    $grdate = $check_barcode->row('grdate');
                    $CODE = $check_barcode->row('CODE');
                    $NAME = $check_barcode->row('NAME');
                    $total = $check_barcode->row('total');
                    $gst_tax_sum = $check_barcode->row('gst_tax_sum');
                    $total_include_tax = $check_barcode->row('total_include_tax');
                        
                    $issuestamp = $check_barcode->row('issuestamp');
                    $postdatetime = $check_barcode->row('postdatetime');
                    
                    if($check_barcode->num_rows() > 1)
                    {
                        $this->submitdoc_model->insert_dataChild_array($check_barcode);
                        if($this->db->affected_rows() > 0)
                        {
                            $this->session->set_flashdata('message', 'Done.');
                            redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                        }
                        else
                        {
                            $this->session->set_flashdata('message', 'Failed.');
                            redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                        }
                    }
                    
                    else
                    {
                        $this->submitdoc_model->insert_dataChild($trans_refno, $location, $doc_type, $doc_no, $inv_no, $doc_date, $grdate, $CODE, $NAME, $total, $total_include_tax, $gst_tax_sum, $issuestamp, $postdatetime);
                        if($this->db->affected_rows() > 0)
                        {
                            $this->session->set_flashdata('message', 'Done.');
                            redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                        }
                        else
                        {
                            $this->session->set_flashdata('message', 'Failed.');
                            redirect('submitdoc_controller/scanbarcode?sl_guid='.$_SESSION['sl_guid']."&type=".$_SESSION['type']);
                        }
                    }
                    
                }
            }
        }

}
?>


