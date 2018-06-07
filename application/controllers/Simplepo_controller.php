<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class simplepo_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('simplepo_model');
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

    public function main()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $data = array( 
                'result' => $this->db->query("SELECT a.*,ROUND(PRICE_PURCHASE,2) as Price FROM backend.mobile_po as a WHERE CONVERTED <> 1  
                     AND created_by= '' ORDER BY CREATED_AT DESC"),
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/simplepo/main', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('simplepo/main', $data);
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
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/simplepo/scan_item');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('simplepo/scan_item');
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
            
            $barcode = $this->input->post('barcode');
            $check_barcode = $this->db->query("SELECT itemcode from backend.itembarcode where barcode = '$barcode'");
            $itemcode = $this->db->query("SELECT itemcode from backend.itembarcode where barcode = '$barcode'")->row('itemcode');
            if ($check_barcode->num_rows() > 0)
            {

            $data = array(
                'item' => $this->db->query("SELECT a.Itemcode,a.Description,ROUND(SalesTempQty,0) AS SalesTempQty,ROUND(a.OnHandQty,2) AS OnHandQty
                    ,a.LastCost,a.AverageCost, b.BarPrice
                    ,ROUND(((b.BarPrice-a.LastCost)/b.BarPrice)*100,2) AS Margin, barcode 
                    FROM backend.itemmaster a 
                    INNER JOIN backend.itembarcode b 
                    ON a.itemcode=b.itemcode 
                    WHERE barcode = '$barcode'"),
                'grn' => $this->db->query("SELECT a.GRDate,a.Code,a.Name,b.Itemcode,b.Description,b.Qty,b.UnitPrice 
                    FROM backend.grmain a 
                    INNER JOIN backend.grchild b 
                    ON a.refno=b.refno 
                    WHERE itemcode='$itemcode'
                    ORDER BY a.GRDate DESC LIMIT 3"),
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/simplepo/scan_itemresult', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('simplepo/scan_itemresult', $data);
                    $this->load->view('footer');                    
                }    

            }// end if barcode exist or not
            else 
            {   
                $this->session->set_flashdata('message', 'Barcode not found : '.$barcode);
                redirect('simplepo_controller/scan_item');
            }

        } // end login = true
        else
        {
           redirect('main_controller/home');
        } // end else login = false
    } // end function

 public function add_qty()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
       
        $itemcode = $this->input->post('itemcode');
        $description = addslashes($this->input->post('description'));
        $barprice = $this->input->post('barprice');
        $barcode = $this->input->post('barcode');
        $iqty = $this->input->post('iqty');
        $lastcost = $this->input->post('lastcost');

        $check_supplier = $this->db->query("SELECT a.GRDate,a.Code,a.Name,b.Itemcode,b.Description,b.Qty,b.UnitPrice FROM backend.grmain a INNER JOIN backend.grchild b ON a.refno=b.refno 
            WHERE itemcode='$itemcode' ORDER BY a.GRDate DESC LIMIT 1");
         if($check_supplier-> num_rows() > 0)
            {
                $code = $check_supplier->row('Code');
                $name = addslashes($check_supplier->row('Name'));
                $ppurchase =  $check_supplier->row('UnitPrice');
            }
            else
            {
                $code = '';
                $name = '';
                $ppurchase = '999';
            }

        $result = $this->simplepo_model->add_qty($itemcode, $description,$code,$name, $iqty, $ppurchase, $barprice, $barcode);

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/simplepo/scan_item');
            }
        else
            {

                $this->load->view('header');
                $this->load->view('simplepo/scan_item');
                $this->load->view('footer');            
            }    
        }
        else
        {
           redirect('main_controller');
        }
    }

    public function view_item()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $po_guid = $_REQUEST['po_guid'];
            $data = array (
                'chekview' => $this->db->query("SELECT * FROM backend.mobile_po where po_guid = '$po_guid'"),
                );
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/simplepo/view_item', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('simplepo/view_item', $data);
                    $this->load->view('footer');
                }    
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
            $po_guid = $_REQUEST['po_guid'];
            $delete = $this->db->query("DELETE FROM backend.mobile_po where po_guid = '$po_guid'");
            redirect('simplepo_controller/main');
        }
         else
        {
           redirect('main_controller');
        } 
    }

}
?>