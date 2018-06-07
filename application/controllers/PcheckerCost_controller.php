<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pcheckercost_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pchecker_model');
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
        $this->load->library('form_validation');

    }

    public function scan_barcode()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {

            $sessionData = array(
                   'show_cost'  => '1'
               );
            $this->session->set_userdata($sessionData);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/pchecker/scan_barcode');
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('pchecker/scan_barcode');
                    $this->load->view('footer');
                }    
            
        }
        else
        {
            redirect('main_controller/index');
        }
        
    }


    public function scan_result()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            // if($this->input->post('barcode') == '')
            // {
            //     $barcode = $_REQUEST['barcode'];
            //     $sessionData = array(
            //            'barcode'  => $barcode,
            //        );
            //     $this->session->set_userdata($sessionData);
            //     $data['result']=$this->pchecker_model->scan_result($barcode);

            //     $browser_id = $_SERVER["HTTP_USER_AGENT"];
            //     if(strpos($browser_id,"Windows CE"))
            //         {
            //             $this->load->view('WinCe/header');
            //             $this->load->view('WinCe/pchecker/scan_result', $data);
            //         }
            //     else
            //         {
            //             $this->load->view('header');
            //             $this->load->view('pchecker/scan_result', $data);
            //             $this->load->view('footer');
            //         }    
                
            // }
            // else
            // {
            //     $barcode = $this->input->post('barcode');
            //     $sessionData = array(
            //            'barcode'  => $barcode,
            //        );
            //     $this->session->set_userdata($sessionData);
            //     $data['result']=$this->pchecker_model->scan_result($barcode);

            //     $browser_id = $_SERVER["HTTP_USER_AGENT"];
            //     if(strpos($browser_id,"Windows CE"))
            //         {
            //             $this->load->view('WinCe/header');
            //             $this->load->view('WinCe/pchecker/scan_result', $data);
            //         }
            //     else
            //         {
            //             $this->load->view('header');
            //             $this->load->view('pchecker/scan_result', $data);
            //             $this->load->view('footer');
            //         }    
                
            // }

            $module = 'POS';
            $barcode = $this->input->post('barcode');
            $result = $this->pchecker_model->scan_result($barcode);

            if($result->num_rows() > 0)
            {
                $sessionData = array(
                       'encode' => 'hidden',
                       'encode_barcode' => $this->input->post('barcode'),
                       'barcode'  => $barcode,
                       'itemlink' => $result->row('itemlink')
                   );
                $this->session->set_userdata($sessionData);
                redirect('PcheckerCost_controller/sku_info');
            }
            else
            {
                $this->Main_Model->decode_barcode($barcode,$module);
                if($this->Main_Model->decode_barcode($barcode,$module) == $this->input->post('barcode'))
                {
                    $this->session->set_flashdata('message', 'Barcode Not Found!!! : '.$barcode);
                    redirect('PcheckerCost_controller/scan_barcode');
                }
                else
                {
                    $sessionData = array(
                       'encode' => '',
                       'encode_barcode' => $this->input->post('barcode'),
                       'barcode'  => $this->Main_Model->decode_barcode($barcode,$module),
                       'itemlink' => $result->row('itemlink')
                    );
                    $this->session->set_userdata($sessionData);
                    redirect('PcheckerCost_controller/sku_info');
                }
                
            }
                

        }
        else
        {
            redirect('main_controller');
        }

    }


    public function itemlink()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $itemlink = $_REQUEST['itemlink'];

            $data['result'] = $this->pchecker_model->itemlink($itemlink);
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/pchecker/itemlink', $data);   
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('pchecker/itemlink', $data);
                    $this->load->view('footer');
                }
            

        }
        else
        {
            redirect('main_controller');
        }

    }


    public function stock()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $itemlink = $_REQUEST['itemlink'];
            $packsize = $_REQUEST['packsize'];

            $data['result'] = $this->pchecker_model->stock($itemlink, $packsize);
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/pchecker/stock', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('pchecker/stock', $data);
                    $this->load->view('footer');

                }    
           
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function sku_info()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            if(isset($_REQUEST['propose_price']) == 1)
            {
                $active_itemdetails = '';
                $active_propose_price = 'active';
            }
            else
            {
                $active_itemdetails = 'active';
                $active_propose_price = '';
            }

            $itemlink = $_SESSION['itemlink'];
            $data = array(

                'itemlink' => $this->pchecker_model->itemlink($itemlink),
                'item_details'  => $this->pchecker_model->get_itemdetails(),
                'item_qoh'  => $this->pchecker_model->get_item_qoh($itemlink),
                'item_qoh_c'  => $this->pchecker_model->get_item_qoh_c(),
                'item_promo'  => $this->pchecker_model->get_item_promo(),
                'po_details'  => $this->pchecker_model->get_podetails(),
                'gr_details'  => $this->pchecker_model->get_grdetails(),
                'active_itemdetails' => $active_itemdetails,
                'active_propose_price' => $active_propose_price,
                );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/pchecker/sku_info', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('pchecker/sku_info', $data);
                    $this->load->view('footer');
                }    

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function save_propose_price()
    {
        $get_data = $this->db->query("SELECT a.itemcode,a.itemlink,b.barcode,b.bardesc,a.packsize,a.`UM` FROM backend.itemmaster a INNER JOIN backend.itembarcode b ON a.itemcode=b.itemcode WHERE barcode='".$_SESSION['barcode']."' ;");
        
        $itemcode = $get_data->row('itemcode');
        $itemlink = $_SESSION['itemlink'];

        if($this->input->post('price_include_tax') == $this->input->post('ori_price_include_tax') && $this->input->post('price_exc_tax') == $this->input->post('ori_price_exc_tax'))
        {
            $this->session->set_flashdata('message', 'Nothing To Save');
                redirect('PcheckerCost_controller/sku_info');
        }
        else
        {
            $data = array(

                'itemcode' => $get_data->row('itemcode'),
                'barcode' => $get_data->row('barcode'),
                'description' => $get_data->row('bardesc'),
                // 'itemlink' => $get_data->row('itemlink'),
                'current_price_inc_tax' => $this->input->post('ori_price_include_tax'),
                'current_price_exc_tax' => $this->input->post('ori_price_exc_tax'),
                'propose_price_inc_tax' => $this->input->post('price_include_tax'),
                'propose_price_exc_tax' => $this->input->post('price_exc_tax'),
                'created_at' => $this->db->query("SELECT NOW() as datetime")->row('datetime'),
                'created_by' => $_SESSION['username'],
            );
            $this->db->insert('backend.propose_price_change',$data);

            //echo $this->db->last_query();die;

            $this->session->set_flashdata('message_success', 'Succesful');
                redirect('PcheckerCost_controller/sku_info?propose_price='.$_REQUEST['propose_price']);

            
        }
    }
}
?>

