<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gondolastock_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('gondolastock_model');
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

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/gondolastock/main');
            }
        else
            {
                $this->load->view('header');
                $this->load->view('gondolastock/main');
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
            $data['pre_item'] = $this->gondolastock_model->pre_item();
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE")) 
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/gondolastock/pre_item', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('gondolastock/pre_item', $data);
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
                'form_action' => site_url('gondolastock_controller/pre_itemlist'),
                'back' => site_url('gondolastock_controller/pre_item'),
                'heading' => 'Gondola Stock',
                );
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/gondolastock/scan_binID', $data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('gondolastock/scan_binID', $data);
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

                $data['result'] = $result  = $this->gondolastock_model->check_binID($bin_ID);   
                if($result->num_rows() != 0 )
                {
                    $bin_ID_Data = array(
                                              
                    'bin_ID' => $bin_ID,
                    'locBin' => $result->row('Location')
                    );
                    $this->session->set_userdata($bin_ID_Data);
                    $data['itemlist'] = $result2 = $this->gondolastock_model->pre_itemlist($bin_ID);
                    if($result2->num_rows() != 0)
                    {

                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                                $this->load->view('WinCe/header');
                                $this->load->view('WinCe/gondolastock/pre_itemlist', $data, $bin_ID_Data);
                            }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('gondolastock/pre_itemlist', $data, $bin_ID_Data);
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
                        $data['result'] = $this->gondolastock_model->check_binID($bin_ID);
                        $data['last_scan'] = $this->gondolastock_model->last_scan($bin_ID);
                        
                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                              $this->load->view('WinCe/header');
                              $this->load->view('WinCe/gondolastock/pre_itemscan', $data, $bin_ID_Data);
                            }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('gondolastock/pre_itemscan', $data, $bin_ID_Data);
                                $this->load->view('footer');
                            }    
                        
                    }

                }
                else
                {
                    $data = array(
                        'form_action' => site_url('gondolastock_controller/pre_itemlist'),
                        'back' => site_url('gondolastock_controller/pre_item'),
                        'heading' => 'Gondola Stock',
                    );
                    $this->session->set_flashdata('message', 'Bin ID Not Exist. ');
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE"))
                        {
                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/gondolastock/scan_binID', $data);
                        }
                    else
                        {
                            $this->load->view('header');
                            $this->load->view('gondolastock/scan_binID', $data);
                            $this->load->view('footer');
                        }    
                    
                } 
            }
            else
            {
                $bin_ID = $this->input->post('bin_ID');
                $data['result'] = $result  = $this->gondolastock_model->check_binID($bin_ID);   
                if($result->num_rows() != 0 )
                {
                    $bin_ID_Data = array(
                                          
                    'bin_ID' => $bin_ID,
                    'locBin' => $result->row('Location')
                    );
                    $this->session->set_userdata($bin_ID_Data);
                    $data['itemlist'] = $result2 = $this->gondolastock_model->pre_itemlist($bin_ID);
                    if($result2->num_rows() != 0)
                    {
                        
                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                                $this->load->view('WinCe/header');
                                $this->load->view('WinCe/gondolastock/pre_itemlist', $data, $bin_ID_Data);
                            }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('gondolastock/pre_itemlist', $data, $bin_ID_Data);
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
                        $data['result'] = $this->gondolastock_model->check_binID($bin_ID);
                        $data['last_scan'] = $this->gondolastock_model->last_scan($bin_ID);
                        $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                          {
                             $this->load->view('WinCe/header');
                             $this->load->view('WinCe/gondolastock/pre_itemscan', $data, $bin_ID_Data);
                          }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('gondolastock/pre_itemscan', $data, $bin_ID_Data);
                                $this->load->view('footer');
                            }    
                    }

                }
                else
                {
                    $data = array(
                        'form_action' => site_url('gondolastock_controller/pre_itemlist'),
                        'back' => site_url('gondolastock_controller/pre_item'),
                        'heading' => 'Gondola Stock',
                    );
                    $this->session->set_flashdata('message', 'Bin ID Not Exist. ');
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                        if(strpos($browser_id,"Windows CE"))
                            {
                                $this->load->view('WinCe/header');
                                $this->load->view('WinCe/gondolastock/scan_binID', $data);
                            }
                        else
                            {
                                $this->load->view('header');
                                $this->load->view('gondolastock/scan_binID', $data);
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
            $data['result'] = $this->gondolastock_model->check_binID($bin_ID);
            $data['last_scan'] = $this->gondolastock_model->last_scan($bin_ID);

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE"))
                {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/gondolastock/pre_itemscan', $data, $locBin_Data);
                }
            else
                {
                    $this->load->view('header');
                    $this->load->view('gondolastock/pre_itemscan', $data, $locBin_Data);
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
                $loc_group = $_SESSION['loc_group'];
            }
            else
            {
                $barcode = $this->input->post('barcode');
                $locBin = $this->input->post('locBin');
                $binID = $this->input->post('binID');
                $loc_group = $_SESSION['loc_group'];
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

            $check_itembarcode = $this->db->query("SELECT a.itemcode,a.BarDesc,a.barcode from backend.itembarcode a inner join backend.itemmaster b on a.itemcode=b.itemcode where barcode='$barcode'");

            $data = array(

                'Itemcode' => $check_itembarcode->row('itemcode') ,
                'BarDesc' => $check_itembarcode->row('BarDesc'),
                'barcode' => $check_itembarcode->row('barcode'),

            );
            $itemcode = $check_itembarcode->row('itemcode');
            if($check_itembarcode->num_rows() == 0)
            {
                $this->session->set_flashdata('message', 'Record Not Found !!!');
                $data['result'] = $this->gondolastock_model->check_binID($binID);
                $data['last_scan'] = $this->gondolastock_model->last_scan($binID);

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/gondolastock/pre_itemscan', $data, $sessiondata);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('gondolastock/pre_itemscan', $data, $sessiondata);
                        $this->load->view('footer');
                    }    
            }
            else
            {
                $data['itemEdit'] = $this->gondolastock_model->pre_itemEdit2($itemcode);
                $data['check_gondolastock'] = $this->db->query("SELECT itemcode, bin_id, barcode, description, qty as g_qty FROM backend_warehouse.gondola_stock WHERE bin_id <> '$binID' AND itemcode = '$itemcode'  ");
                $this->session->set_userdata($sessiondata);
                 $query_minmax = $this->db->query("SELECT itemcode, sum(set_min) as set_min, sum(set_max) as set_max from backend_warehouse.set_min_max where itemcode = '$itemcode' and loc_group = '$loc_group' ");
                $query_curminmax = $this->db->query("SELECT SUM(qty) as curqty from backend_warehouse.gondola_stock where itemcode = '$itemcode'");
                $set_min = $query_minmax->row('set_min');
                $set_max = $query_minmax->row('set_max');
                $curqty = $query_curminmax->row('curqty');

                if($curqty > $set_max)
                {
                     $this->session->set_flashdata('warning', 'Item has already reach maximum level');
                }
                elseif ($curqty < $set_min)
                {
                    $this->session->set_flashdata('warning', 'Item is at minimum level');
                }
                else
                {
                    $this->session->set_flashdata('warning', ' ');
                }
                

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/gondolastock/pre_itemEdit', $data, $sessiondata);
                    }
                else
                    {
                        $this->load->view('header');
                        $this->load->view('gondolastock/pre_itemEdit', $data, $sessiondata);
                        $this->load->view('footer');
                    }    
            }
            
            // $result = $this->gondolastock_model->pre_itemEdit($barcode);
            // $itemcode = $result->row('itemcode');
            
            // $data = array(

            //     'Itemcode' => $result->row('itemcode') ,
            //     'BarDesc' => $result->row('BarDesc'),
            //     'barcode' => $result->row('barcode') ,
            // );
                   
            //     if($result->num_rows() != 0 )
            //     {
            //         $data['weightItem'] = $result2 = $this->gondolastock_model->check_weightItem($barcode);
            //         if($result2->num_rows() != 0 )
            //         {
            //             $this->session->set_flashdata('message', 'Item is sold by weight.');
            //             $data['result'] = $this->gondolastock_model->check_binID($binID);
            //             $data['last_scan'] = $this->gondolastock_model->last_scan($binID);
            //             $this->session->set_userdata($sessiondata);
            //             $this->load->view('header');
            //             $this->load->view('gondolastock/pre_itemscan', $data, $sessiondata);
            //             $this->load->view('footer');                            
            //         }
            //         else
            //         {
            //             $data['itemEdit'] = $this->gondolastock_model->pre_itemEdit2($itemcode);
            //             $this->session->set_userdata($sessiondata);
            //             $this->load->view('header');
            //             $this->load->view('gondolastock/pre_itemEdit', $data, $sessiondata);
            //             $this->load->view('footer');
            //         }
                     
            //     }
            //     else
            //     {
            //         $this->session->set_flashdata('message', 'Record Not Found !!!');
            //         $data['result'] = $this->gondolastock_model->check_binID($binID);
            //         $data['last_scan'] = $this->gondolastock_model->last_scan($binID);
            //         $this->load->view('header');
            //         $this->load->view('gondolastock/pre_itemscan', $data, $sessiondata);
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
            $bin_ID = $_SESSION['bin_ID'];


            $itemcode = $this->input->post('Itemcode');
            $TRANS_GUID = $this->input->post('TRANS_GUID');

            $exist_data = $this->gondolastock_model->exist_data($TRANS_GUID);

            $query_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid");
            $guid = $query_guid->row('guid');

            $query_now = $this->db->query("SELECT NOW() AS datetime");
            $datetime = $query_now->row('datetime');

            $query_itemmaster = $this->db->query("SELECT * FROM backend.itemmaster where 
                itemcode = '".$this->input->post('Itemcode')."' ");
            $row = $query_itemmaster->result();

            $result = $this->gondolastock_model->get_itemmaster($itemcode); 



            $data = array(

                'BIN_ID' => $_SESSION['binID'],
                'Itemcode' => $result->row('Itemcode') ,
                'Itemlink' => $result->row('ItemLink'),
                'Barcode' => $this->input->post('Barcode') ,
                'Description' => $result->row('Description') ,
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
                $insert = $this->gondolastock_model->insert($data);
                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('message', 'Successfully Add.');
                    redirect('gondolastock_controller/pre_itemscan?locBin='.$_SESSION['locBin']);
                }
                else
                {
                    $this->session->set_flashdata('message', 'Unable To Add.');
                    redirect('gondolastock_controller/pre_itemscan?locBin='.$_SESSION['locBin']);
                }
            }
            else
            {
                $data_update = array(
                    'Qty' => (string)((float)$this->input->post('qty') + (float)$this->input->post('qty_add')),
                    'UPDATED_AT' => $datetime,
                    'UPDATED_BY' => $_SESSION['username'],
                    );
                $update = $this->gondolastock_model->update($TRANS_GUID, $data_update);
                if($this->db->affected_rows() > 0)
                {
                    $this->session->set_flashdata('message', 'Successfully Update.');
                    redirect('gondolastock_controller/pre_itemscan?locBin='.$_SESSION['locBin']);
                }
                else
                {
                    $this->session->set_flashdata('message', 'Unable To Add.');
                    redirect('gondolastock_controller/pre_itemscan?locBin='.$_SESSION['locBin']);
                }
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
        
        $this->gondolastock_model->pre_itemDelete($TRANS_GUID);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('message', 'Succesfully Delete .');
            redirect('gondolastock_controller/pre_itemlist?bin_ID='.$bin_ID);
        }
        else
        {
            $this->session->set_flashdata('message', 'Unable to Delete .');
            redirect('gondolastock_controller/pre_itemlist?bin_ID='.$bin_ID);
        }

    }

    public function pre_batch_itemDelete()
    {
        $batch_barcode = $_REQUEST['batch_barcode'];
        $bin_ID = $_SESSION['bin_ID'];

        $this->gondolastock_model->pre_batch_itemDelete($batch_barcode);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('message', 'Succesfully Delete .');
            redirect('gondolastock_controller/pre_batch_itemlist?bin_ID='.$bin_ID);
        }
        else
        {
            $this->session->set_flashdata('message', 'Unable to Delete .');
            redirect('gondolastock_controller/pre_batch_itemlist?bin_ID='.$bin_ID);
        }

    }

    public function pre_itemPrint()
    {
        $bin_ID = $_REQUEST['bin_ID'];
        $this->gondolastock_model->pre_itemPrint($bin_ID);

        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('message', 'Print send .');
            redirect('gondolastock_controller/pre_itemlist?bin_ID='.$bin_ID);
        }
        else
        {
            $this->session->set_flashdata('message', 'Print not send .');
            redirect('gondolastock_controller/pre_itemlist?bin_ID='.$bin_ID);
        }

    }
    
}
?>