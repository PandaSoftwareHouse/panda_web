<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class stktake_pre_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('stktake_pre_model');
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

            $check_status = $this->db->query("SELECT count(*) as cc FROM backend_stktake.`set_date` WHERE STATUS_CLOSED = '0'");
            if($check_status->row('cc') >= 2)
            {
                $data = array(
                    'button_hidden' => 'hidden',
                );
                $this->session->set_flashdata('message', '<span class="label label-warning" style="font-size: 12px;">Previous Stock Take not close. Prelisting Not Allowed!</span>');
            }
            else
            {
                $data = array(
                    'button_hidden' => '',
                );
                $this->session->set_flashdata('message', '');
            }

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/stktake_pre/main', $data);
            }
        else
            {
                $this->load->view('header');
                $this->load->view('stktake_pre/main', $data);
                $this->load->view('footer');
            }    
        

        }
        else
        {
            redirect('main_controller');
        }
    }


    public function pre_item()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $data['pre_item'] = $this->stktake_pre_model->pre_item();
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE")) 
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/stktake_pre/pre_item', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('stktake_pre/pre_item', $data);
                    $this->load->view('footer');
                }    
               
        }
        else
        {
           redirect('main_controller');
        }
        
    }

    public function pre_batch()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $data['result'] = $this->stktake_pre_model->pre_batch(); 

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/stktake_pre/pre_batch', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('stktake_pre/pre_batch', $data);
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
            $data = array(
                'form_action' => site_url('stktake_pre_controller/pre_itemlist'),
                'back' => site_url('stktake_pre_controller/pre_item'),
                'heading' => 'Stock take - prelisting',
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/stktake_pre/scan_binID', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('stktake_pre/scan_binID', $data);
                    $this->load->view('footer');
                }      
        }
        else
        {
            redirect('main_controller');
        }
        
    }


    public function scan_binIDBatch()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $data = array(
                'form_action' => site_url('stktake_pre_controller/pre_batch_itemlist'),
                'back' => site_url('stktake_pre_controller/pre_batch'),
                'heading' => 'Stock take - by pallet',
                );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/stktake_pre/scan_binID', $data);   
       
            }
        else 
            {
                $this->load->view('header');
                $this->load->view('stktake_pre/scan_binID', $data);
                $this->load->view('footer');   
            }    
          }
        else
        {
            redirect('main_controller');
        }
        
    }

    public function pre_itemlist()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        { 
            if($this->input->post('bin_ID') == null)
            {
                $bin_ID = $_REQUEST['bin_ID'];

                $data['result'] = $result  = $this->stktake_pre_model->check_binID($bin_ID);   
                if($result->num_rows() != 0 )
                {
                    $bin_ID_Data = array(
                                              
                    'bin_ID' => $bin_ID,
                    'locBin' => $result->row('Location')
                    );
                    $this->session->set_userdata($bin_ID_Data);
                    $data['itemlist'] = $result2 = $this->stktake_pre_model->pre_itemlist($bin_ID);
                    if($result2->num_rows() != 0)
                    {

                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                                $this->load->view('WinCe/header');
                                $this->load->view('WinCe/stktake_pre/pre_itemlist', $data, $bin_ID_Data);
                            }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('stktake_pre/pre_itemlist', $data, $bin_ID_Data);
                                $this->load->view('footer');
                            }
                    }
                    else
                    {
                        $bin_ID_Data = array(
                                          
                            'bin_ID' => $bin_ID,
                            'locBin' => $result->row('Location')
                            );
                        $this->session->set_userdata($bin_ID_Data);
                        $data = array(
                            'result' => $this->stktake_pre_model->check_binID($bin_ID),
                            'last_scan' => $this->stktake_pre_model->last_scan($bin_ID),
                            'back' => 'scan_binID'
                            );
                        
                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                              $this->load->view('WinCe/header');
                              $this->load->view('WinCe/stktake_pre/pre_itemscan', $data, $bin_ID_Data);
                            }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('stktake_pre/pre_itemscan', $data, $bin_ID_Data);
                                $this->load->view('footer');
                            }    
                        
                    }

                }
                else
                {
                    $data = array(
                        'form_action' => site_url('stktake_pre_controller/pre_itemlist'),
                        'back' => site_url('stktake_pre_controller/pre_item'),
                        'heading' => 'Stock take - prelisting',
                    );
                    $this->session->set_flashdata('message', 'Bin ID Not Exist. ');
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/stktake_pre/scan_binID', $data);
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('stktake_pre/scan_binID', $data);
                            $this->load->view('footer');
                        }    
                    
                } 
            }
            else
            {
                $bin_ID = $this->input->post('bin_ID');
                $data['result'] = $result  = $this->stktake_pre_model->check_binID($bin_ID);   
                if($result->num_rows() != 0 )
                {
                    $bin_ID_Data = array(
                                          
                    'bin_ID' => $bin_ID,
                    'locBin' => $result->row('Location')
                    );
                    $this->session->set_userdata($bin_ID_Data);
                    $data['itemlist'] = $result2 = $this->stktake_pre_model->pre_itemlist($bin_ID);
                    if($result2->num_rows() != 0)
                    {
                        
                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                                $this->load->view('WinCe/header');
                                $this->load->view('WinCe/stktake_pre/pre_itemlist', $data, $bin_ID_Data);
                            }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('stktake_pre/pre_itemlist', $data, $bin_ID_Data);
                                $this->load->view('footer');
                            }    
                    }
                    else
                    {
                        $bin_ID_Data = array(
                                          
                            'bin_ID' => $bin_ID,
                            'locBin' => $result->row('Location')
                            );
                        $this->session->set_userdata($bin_ID_Data);
                        $data = array(
                            'result' => $this->stktake_pre_model->check_binID($bin_ID),
                            'last_scan' => $this->stktake_pre_model->last_scan($bin_ID),
                            'back' => 'scan_binID'
                            );
                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                          {
                             $this->load->view('WinCe/header');
                             $this->load->view('WinCe/stktake_pre/pre_itemscan', $data, $bin_ID_Data);
                          }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('stktake_pre/pre_itemscan', $data, $bin_ID_Data);
                                $this->load->view('footer');
                            }    
                    }

                }
                else
                {
                    $data = array(
                        'form_action' => site_url('stktake_pre_controller/pre_itemlist'),
                        'back' => site_url('stktake_pre_controller/pre_item'),
                        'heading' => 'Stock take - prelisting',
                    );
                    $this->session->set_flashdata('message', 'Bin ID Not Exist. ');
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                                $this->load->view('WinCe/header');
                                $this->load->view('WinCe/stktake_pre/scan_binID', $data);
                            }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('stktake_pre/scan_binID', $data);
                                $this->load->view('footer');
                            }          
                } 
            }

        }
        else
        {
            redirect('main_controller');
        }
    }


    public function pre_batch_itemlist()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        { 
            if($this->input->post('bin_ID') == '')
            {
                $bin_ID = $_REQUEST['bin_ID'];

                $data['result'] = $result  = $this->stktake_pre_model->check_binID($bin_ID);   
                if($result->num_rows() != 0 )
                {
                    $bin_ID_Data = array(
                                              
                    'bin_ID' => $bin_ID
                    );
                    $this->session->set_userdata($bin_ID_Data);
                    $data['itemlist'] = $result2 = $this->stktake_pre_model->pre_batch_itemlist($bin_ID);
                    if($result2->num_rows() != 0)
                    {

                      $browser_id = $_SERVER["HTTP_USER_AGENT"];
                      if(strpos($browser_id,"Windows CE"))
                        {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/stktake_pre/pre_batch_itemlist',$data, $bin_ID_Data);
                        }
                        else
                          {
                            $this->load->view('header');
                            $this->load->view('stktake_pre/pre_batch_itemlist', $data, $bin_ID_Data);
                            $this->load->view('footer');
                          }  
                        
                    }
                    else
                    {
                        $data['result'] = $this->stktake_pre_model->check_binID($bin_ID);
                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                           {
                             $this->load->view('WinCe/header');
                             $this->load->view('WinCe/stktake_pre/pre_batch_itemlist', $data, $bin_ID_Data);
                           }
                        else
                           {
                             $this->load->view('header');
                             $this->load->view('stktake_pre/pre_batch_itemlist', $data, $bin_ID_Data);
                             $this->load->view('footer');
                           }     
                        
                    }

                }
                else
                {
                    $data = array(
                        'form_action' => site_url('stktake_pre_controller/pre_batch_itemlist'),
                        'back' => site_url('stktake_pre_controller/pre_batch'),
                        'heading' => 'Stock take - by pallet',
                    );
                    $this->session->set_flashdata('message', 'Bin ID Not Exist. ');
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/stktake_pre/scan_binID', $data);
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('stktake_pre/scan_binID', $data);
                            $this->load->view('footer');
                        }    
                } 
            }
            else
            {
                $bin_ID = $this->input->post('bin_ID');
                $data['result'] = $result  = $this->stktake_pre_model->check_binID($bin_ID);   
                if($result->num_rows() != 0 )
                {
                    $bin_ID_Data = array(
                                          
                    'bin_ID' => $bin_ID
                    );
                    $this->session->set_userdata($bin_ID_Data);
                    $data['itemlist'] = $result2 = $this->stktake_pre_model->pre_batch_itemlist($bin_ID);
                    if($result2->num_rows() != 0)
                    {
                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                              $this->load->view('WinCe/header');
                              $this->load->view('WinCe/stktake_pre/pre_batch_itemlist', $data, $bin_ID_Data);
                            }
                        else
                            {
                              $this->load->view('header');
                              $this->load->view('stktake_pre/pre_batch_itemlist', $data, $bin_ID_Data);
                              $this->load->view('footer');
                            }    
                        
                    }
                    else
                    {
                        $data['result'] = $this->stktake_pre_model->check_binID($bin_ID);
                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                          {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/stktake_pre/pre_batch_itemlist', $data, $bin_ID_Data);
                          }
                        else
                          {    
                            $this->load->view('header');
                            $this->load->view('stktake_pre/pre_batch_itemlist', $data, $bin_ID_Data);
                            $this->load->view('footer');
                          }

                    }

                }
                else
                {
                    $data = array(
                        'form_action' => site_url('stktake_pre_controller/pre_batch_itemlist'),
                        'back' => site_url('stktake_pre_controller/pre_batch'),
                        'heading' => 'Stock take - by pallet',
                    );
                    $this->session->set_flashdata('message', 'Bin ID Not Exist. ');
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                      {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/stktake_pre/scan_binID' ,$data);
                      }
                    else
                      {
                        $this->load->view('header');
                        $this->load->view('stktake_pre/scan_binID' ,$data);
                        $this->load->view('footer');
                      }  
                    
                } 
            }

        }
        else
        {
            redirect('main_controller');
        }
        
    }


    public function pre_itemscan()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $locBin = $_REQUEST['locBin'];
            $bin_ID = $_SESSION['bin_ID'];
            
            $locBin_Data = array(
                                      
                'locBin' => $locBin
            );
            $this->session->set_userdata($locBin_Data);
            $data['result'] = $this->stktake_pre_model->check_binID($bin_ID);
            $data['last_scan'] = $this->stktake_pre_model->last_scan($bin_ID);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/stktake_pre/pre_itemscan', $data, $locBin_Data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('stktake_pre/pre_itemscan', $data, $locBin_Data);
                    $this->load->view('footer');
                }    
               
        }
        else
        {
            redirect('main_controller');
        }
        
    }

    public function pre_batch_itemscan()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $locBin = $this->input->post('locBin');
            $bin_ID = $_SESSION['bin_ID'];
            
            $locBin_Data = array(
                                      
                'locBin' => $locBin
            );
            $this->session->set_userdata($locBin_Data);
            $data['result'] = $this->stktake_pre_model->check_binID($bin_ID);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/stktake_pre/pre_batch_itemscan', $data, $locBin_Data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('stktake_pre/pre_batch_itemscan', $data, $locBin_Data);
                    $this->load->view('footer');
                }    
               
        }
        else
        {
            redirect('main_controller');
        }
        
    }


    public function pre_itemEdit()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            if ($this->input->post('barcode') == '' && $this->input->post('locBin') == '' && $this->input->post('binID') == '' )
            {
                $barcode = $_REQUEST['Barcode'];
                $locBin = $_REQUEST['locBin'];
                $binID = $_REQUEST['binID'];
            }
            else
            {
                $barcode = $this->input->post('barcode');
                $locBin = $this->input->post('locBin');
                $binID = $this->input->post('binID');
            }
            
            $sessiondata = array(
                                      
            'locBin' => $locBin,
            'binID' => $binID
            );
            
            $check_weightItem = $this->db->query("SELECT a.* FROM backend.itembarcode a INNER JOIN backend.itemmaster b ON a.itemcode=b.itemcode WHERE b.soldbyweight=1 AND a.barcode='".substr($barcode,0,7)."' ");

            if($check_weightItem->num_rows() > 0)
            {
                $barcode = substr($barcode,0,7);
            };

            $check_itembarcode = $this->db->query("SELECT a.itemcode,a.BarDesc,a.barcode,b.price_include_tax
            FROM backend.itembarcode a 
            INNER JOIN backend.itemmaster b 
            ON a.itemcode=b.itemcode WHERE barcode='".$barcode."'");

            $data = array(

                'Itemcode' => $check_itembarcode->row('itemcode') ,
                'BarDesc' => $check_itembarcode->row('BarDesc'),
                'barcode' => $check_itembarcode->row('barcode') ,
                'price_include_tax' => $check_itembarcode->row('price_include_tax') ,
            );
            $itemcode = $check_itembarcode->row('itemcode');
            if($check_itembarcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Record Not Found !!!');
                $data['result'] = $this->stktake_pre_model->check_binID($binID);
                $data['last_scan'] = $this->stktake_pre_model->last_scan($binID);

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/stktake_pre/pre_itemscan', $data, $sessiondata);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('stktake_pre/pre_itemscan', $data, $sessiondata);
                        $this->load->view('footer');
                    }    
            }
            else
            {
                $data['itemEdit'] = $this->stktake_pre_model->pre_itemEdit2($itemcode);
                $this->session->set_userdata($sessiondata);
                
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/stktake_pre/pre_itemEdit', $data, $sessiondata);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('stktake_pre/pre_itemEdit', $data, $sessiondata);
                        $this->load->view('footer');
                    }    
            }
            
            // $result = $this->stktake_pre_model->pre_itemEdit($barcode);
            // $itemcode = $result->row('itemcode');
            
            // $data = array(

            //     'Itemcode' => $result->row('itemcode') ,
            //     'BarDesc' => $result->row('BarDesc'),
            //     'barcode' => $result->row('barcode') ,
            // );
                   
            //     if($result->num_rows() != 0 )
            //     {
            //         $data['weightItem'] = $result2 = $this->stktake_pre_model->check_weightItem($barcode);
            //         if($result2->num_rows() != 0 )
            //         {
            //             $this->session->set_flashdata('message', 'Item is sold by weight.');
            //             $data['result'] = $this->stktake_pre_model->check_binID($binID);
            //             $data['last_scan'] = $this->stktake_pre_model->last_scan($binID);
            //             $this->session->set_userdata($sessiondata);
            //             $this->load->view('header');
            //             $this->load->view('stktake_pre/pre_itemscan', $data, $sessiondata);
            //             $this->load->view('footer');                            
            //         }
            //         else
            //         {
            //             $data['itemEdit'] = $this->stktake_pre_model->pre_itemEdit2($itemcode);
            //             $this->session->set_userdata($sessiondata);
            //             $this->load->view('header');
            //             $this->load->view('stktake_pre/pre_itemEdit', $data, $sessiondata);
            //             $this->load->view('footer');
            //         }
                     
            //     }
            //     else
            //     {
            //         $this->session->set_flashdata('message', 'Record Not Found !!!');
            //         $data['result'] = $this->stktake_pre_model->check_binID($binID);
            //         $data['last_scan'] = $this->stktake_pre_model->last_scan($binID);
            //         $this->load->view('header');
            //         $this->load->view('stktake_pre/pre_itemscan', $data, $sessiondata);
            //         $this->load->view('footer');
            //     }  
        
        }
        else
        {
            redirect('main_controller');
        }
    }


    public function pre_itemSave()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $itemcode = $this->input->post('Itemcode');
            $TRANS_GUID = $this->input->post('TRANS_GUID');

            $exist_data = $this->stktake_pre_model->exist_data($TRANS_GUID);

            $query_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid");
            $guid = $query_guid->row('guid');

            $query_now = $this->db->query("SELECT NOW() AS datetime");
            $datetime = $query_now->row('datetime');

            $query_itemmaster = $this->db->query("SELECT * FROM backend.itemmaster where 
                itemcode = '".$this->input->post('Itemcode')."' ");
            $row = $query_itemmaster->result();

            $result = $this->stktake_pre_model->get_itemmaster($itemcode); 
            
            $data = array(

                'BIN_ID' => $_SESSION['binID'],
                'Itemcode' => $result->row('Itemcode') ,
                'Itemlink' => $result->row('ItemLink'),
                'Barcode' => $this->input->post('Barcode') ,
                'Description' => addslashes($result->row('Description')) ,
                'Packsize' => $result->row('PackSize') ,
                'Qty' => (string)((float)$this->input->post('qty') + (float)$this->input->post('qty_add')),
                'UM' => $result->row('UM') ,
                'costmargin' => $result->row('costmargin') ,
                'costmarginvalue' => $result->row('costmarginvalue') ,
                'SoldByWeight' => $result->row('SoldByWeight') ,
                'WeightFactor' => $result->row('WeightFactor') ,
                'WeightPrice' => $result->row('WeightPrice') ,
                'Consign' => $result->row('Consign') ,
                'DEPT' => $result->row('Dept') ,
                'SUBDEPT' => $result->row('SubDept') ,
                'CATEGORY' => $result->row('Category') ,

                'Averagecost' => $result->row('AverageCost') ,
                'LastCost' => $result->row('LastCost') ,
                'exported' => '0',

                'UPDATED_AT' => $datetime,
                'UPDATED_BY' => $_SESSION['username'],

                'TRANS_GUID' => $guid,
                'CREATED_AT' => $datetime,
                'CREATED_BY' => $_SESSION['username'],

                );

            if($exist_data->num_rows() == 0)
            {
                $insert = $this->stktake_pre_model->insert($data);
                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('message', 'Successfully Add.');
                    redirect('stktake_pre_controller/pre_itemscan?locBin='.$_SESSION['locBin']);
                }
                else
                {
                    $this->session->set_flashdata('message', 'Unable To Add.');
                    redirect('stktake_pre_controller/pre_itemscan?locBin='.$_SESSION['locBin']);
                }
            }
            else
            {
                $data_update = array(
                    'Qty' => (string)((float)$this->input->post('qty') + (float)$this->input->post('qty_add')),
                    'UPDATED_AT' => $datetime,
                    'UPDATED_BY' => $_SESSION['username'],
                    );
                $update = $this->stktake_pre_model->update($TRANS_GUID, $data_update);
                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('message', 'Successfully Update.');
                    redirect('stktake_pre_controller/pre_itemscan?locBin='.$_SESSION['locBin']);
                }
                else
                {
                    $this->session->set_flashdata('message', 'Unable To Add.');
                    redirect('stktake_pre_controller/pre_itemscan?locBin='.$_SESSION['locBin']);
                }
            }
            
        }
        else
        {
            redirect('main_controller');
        }
    }

    public function pre_batch_itemSave()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $barcode = $this->input->post('barcode');
            $bin_ID = $_SESSION['bin_ID'];

            //Check whether exist in scan record
            $result = $this->stktake_pre_model->exist_data_batch($barcode);
            if($result->num_rows() != 0)
            {
                $this->session->set_flashdata('message', 'Barcode already exist @ '.$result->row('BIN_ID'));
                redirect('stktake_pre_controller/pre_batch_itemscan');
            }
            else
            {
                //Check whether barcode exist or not
                $result2 = $this->stktake_pre_model->exist_barcode_batch($barcode);
                if($result2->num_rows() == 0)
                {
                    $this->session->set_flashdata('message', 'Barcode does not exist .');
                    redirect('stktake_pre_controller/pre_batch_itemscan');
                }
                else
                {
                    $query_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid");
                    $guid = $query_guid->row('guid');

                    $query_now = $this->db->query("SELECT NOW() AS datetime");
                    $datetime = $query_now->row('datetime');

                    $data = array(

                        'TRANS_GUID' => $guid ,
                        'BIN_ID' => $_SESSION['bin_ID'] ,
                        'BATCH_BARCODE' => $barcode,

                        'UPDATED_AT' => $datetime,
                        'UPDATED_BY' => $_SESSION['username'],

                        'CREATED_AT' => $datetime,
                        'CREATED_BY' => $_SESSION['username'],
                    );

                    $insert = $this->stktake_pre_model->insert_batch($data);
                    if($this->db->affected_rows() > 0)
                    {
                        $this->session->set_flashdata('message', 'Successfully Add.');
                        redirect('stktake_pre_controller/pre_batch_itemlist?bin_ID='.$bin_ID);
                    }
                    else
                    {
                        $this->session->set_flashdata('message', 'Unable To Add.');
                        redirect('stktake_pre_controller/pre_batch_itemlist?bin_ID='.$bin_ID);
                    }
                }
            }

        }
        else
        {
            redirect('main_controller');
        }
    }

    public function pre_batch_itemView()
    {
        if($this->session->userdata('loginuser') == true)
        {
            $batch_barcode = $_REQUEST['batch_barcode'];
            $data['result'] = $this->stktake_pre_model->pre_batch_itemView($batch_barcode);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/stktake_pre/pre_batch_itemView', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('stktake_pre/pre_batch_itemView', $data);
                    $this->load->view('footer');
                }    
            
        }
        else
        {
            redirect('main_controller');
        }

    }

    public function pre_itemDelete()
    {
        $TRANS_GUID = $_REQUEST['TRANS_GUID'];
        $bin_ID = $_SESSION['bin_ID'];
        
        $this->stktake_pre_model->pre_itemDelete($TRANS_GUID);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('message', 'Succesfully Delete .');
            redirect('stktake_pre_controller/pre_itemlist?bin_ID='.$bin_ID);
        }
        else
        {
            $this->session->set_flashdata('message', 'Unable to Delete .');
            redirect('stktake_pre_controller/pre_itemlist?bin_ID='.$bin_ID);
        }

    }

    public function pre_batch_itemDelete()
    {
        $batch_barcode = $_REQUEST['batch_barcode'];
        $bin_ID = $_SESSION['bin_ID'];

        $this->stktake_pre_model->pre_batch_itemDelete($batch_barcode);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('message', 'Succesfully Delete .');
            redirect('stktake_pre_controller/pre_batch_itemlist?bin_ID='.$bin_ID);
        }
        else
        {
            $this->session->set_flashdata('message', 'Unable to Delete .');
            redirect('stktake_pre_controller/pre_batch_itemlist?bin_ID='.$bin_ID);
        }

    }

    public function pre_itemPrint()
    {
        $bin_ID = $_REQUEST['bin_ID'];
        $this->stktake_pre_model->pre_itemPrint($bin_ID);

        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('message', 'Print send .');
            redirect('stktake_pre_controller/pre_itemlist?bin_ID='.$bin_ID);
        }
        else
        {
            $this->session->set_flashdata('message', 'Print not send .');
            redirect('stktake_pre_controller/pre_itemlist?bin_ID='.$bin_ID);
        }

    }
    
}
?>