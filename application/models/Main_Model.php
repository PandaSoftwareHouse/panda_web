<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_Model extends CI_Model
{
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general_scan_model');
    }


    public function location()
    {
        //data is retrive from this query
        $sql = "SELECT sublocation FROM backend_warehouse.set_sublocation ORDER BY sublocation DESC";
        $query = $this->db->query($sql);
        return $query;
        
    }

    public function login_data($username, $userpass)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM backend_warehouse.set_user WHERE user_name='$username' AND user_password='$userpass'";
        $query = $this->db->query($sql);
        return $query->num_rows();
        
    }
    
    public function home_data()  
    {  
        //data is retrive from this query
       /* $sql = "SELECT * FROM backend_warehouse.module_menuci WHERE hide_menu != '1' order by Sequence";*/
       $sql = "SELECT a.* FROM backend_warehouse.module_menu a INNER JOIN backend_warehouse.set_user_group_webmodule b ON a.`module_name`=b.module_name INNER JOIN backend_warehouse.set_user_group c ON b.user_group_guid=c.user_group_guid INNER JOIN backend_warehouse.set_user d ON d.user_group_guid=c.user_group_guid  WHERE hide_menu<>1 AND user_name='".$_SESSION['username']."' ORDER BY Sequence";
        $query = $this->db->query($sql);  
        return $query;  
    }

    public function general_post_grn($data,$grn_guid)
    {
        $this->db->where('grn_guid', $grn_guid);
        $this->db->update('backend_warehouse.d_grn', $data);
    }

    public function general_post_trx_out($data,$trans_guid)
    {
        $this->db->where('trans_guid', $trans_guid);
        $this->db->update('backend_warehouse.b_trans', $data);
        // echo $this->db->last_query();die;
    }

    public function general_post_trx_rec_child($data, $child_guid)
    {
        $this->db->where('child_guid', $child_guid);
        $this->db->update('backend_warehouse.b_trans_c', $data);
        // echo $this->db->last_query();die;
    }

    public function general_post_trx_rec($data, $trans_guid)
    {
        $this->db->where('trans_guid', $trans_guid);
        $this->db->update('backend_warehouse.b_trans', $data);
        // echo $this->db->last_query();die;
    }

    public function b_transfer_rec_post($trans_guid)  
    {  
        //data is retrive from this query
        $sql = "CALL backend_warehouse.b_transfer_rec_post('$trans_guid')";
        $query = $this->db->query($sql);  
    }

    public function add_detail($data)
    {
        $this->db->insert('backend_warehouse.set_user_group_setting', $data);
       /* echo $this->db->last_query();die;*/
    }

        public function update_details($data,$guid)
    {
        $this->db->where('user_group_guid',$guid);
        $this->db->update('backend_warehouse.set_user_group_setting', $data);
    }

    public function decode_barcode($barcode,$module)//sold by weight item
    {
        $encode_barcode = $barcode;
            // check if need decode
            $barcode_type1 = $this->general_scan_model->check_itemmaster_all($barcode);
            if($barcode_type1-> num_rows() > 0)
            {
                foreach($barcode_type1->result() as $row)
                {
                    $barcode_type = $row->barcodetype;
                    $getsellingprice = $row->sellingprice;
                    $getsoldbyweight = $row->soldbyweight;
                    $get_weight = '';
                }

            }
            else if ($barcode_type1-> num_rows() == 0 )
            {
                $barcode_type2 = $this->general_scan_model->check_itemmaster_18D($barcode);
                if($barcode_type2-> num_rows() > 0 )
                {
                    $barcode_type = $barcode_type2->row('barcodetype');
                    $getsellingprice = $barcode_type2->row('sellingprice');
                    $getsoldbyweight = $barcode_type2->row('soldbyweight');
                }// end barcodetype2
                else
                {
                    $barcode_type = '';
                }

                $eighteenD = $this->general_scan_model->check_decode($module);
                if ($eighteenD->num_rows() != 0)
                {

                    $weight_type_code               =  $eighteenD->row('weight_type_code');
                    $weight_capture_price           =  $eighteenD->row('weight_capture_price');
                    $weight_bar_pos_start           =  $eighteenD->row('weight_bar_pos_start');
                    $weight_bar_pos_count           =  $eighteenD->row('weight_bar_pos_count');
                    $weight_capture_factor          =  $eighteenD->row('weight_capture_factor');
                    $weight_capture_weight          =  $eighteenD->row('weight_capture_weight');
                    $weight_capture_pos_start       =  $eighteenD->row('weight_capture_pos_start');
                    $weight_capture_pos_count       =  $eighteenD->row('weight_capture_pos_count');
                    $weight_capture_weight_type     =  $eighteenD->row('weight_capture_weight_type');
                    $weight_capture_price_factor    =  $eighteenD->row('weight_capture_price_factor');
                    $weight_capture_price_pos_start =  $eighteenD->row('weight_capture_price_pos_start');
                    $weight_capture_price_pos_count =  $eighteenD->row('weight_capture_price_pos_count');

                    if ($weight_capture_weight == 1)
                    {
                        if($weight_capture_weight_type == 'actual weight')
                        {
                            if($barcode_type == 'Q') // sold by qty
                            {
                                $get_weight = substr($barcode, $weight_capture_pos_start-1, $weight_capture_pos_count);
                            }
                            else // sold by weight
                            {
                                $get_weight = (float)substr($barcode,(int)$weight_capture_pos_start-1, (int)$weight_capture_pos_count)/(float)$weight_capture_factor;
                                
                            }
                        }
                        else
                        {
                            $get_weight = (substr($barcode, $weight_capture_pos_start-1, $weight_capture_pos_count)/$weight_capture_factor)/* /$getsellingprice;*/ ;
                        } // end actual weight

                        $get_weight = round($get_weight,3);
                    };

                    // echo $weight_capture_price;die;

                    if($weight_capture_price == 1)
                    {
                        $get_price = substr($barcode, $weight_capture_price_pos_start-1,$weight_capture_price_pos_count)/$weight_capture_price_factor;
                    };

                    $get_price = round($get_price,3);

                    $temp_weight_price = array(
                                'get_weight' =>$get_weight,
                                'get_price' => $get_price,
                                );
                    $this->session->set_userdata($temp_weight_price); 

                    // force to find itemcode and truncate the barcode to get the front part
                    if (strlen($barcode) == '18')
                    {
                       /*$_barcode = substr($barcode,0,-11);*/
                       $_barcode = substr($barcode, $weight_bar_pos_start-1,$weight_bar_pos_count);
                       $c_barcode = $this->db->query("SELECT * from itemmaster as a inner join itembarcode as b on a.itemcode = b.itemcode where barcode = '$_barcode'")->num_rows();
                        if($c_barcode == 0)
                        {   
                            $this->session->set_flashdata('message', 'Itemlink Not Found!!! : '.$barcode);
                            redirect('pchecker_controller/scan_barcode');
                        }else
                        {
                            $barcode = $_barcode;     
                        }

                       
                    }
                    else if (strlen($barcode) == '13')
                    {
                        /*$_barcode = substr($barcode,0,-6);*/
                        $_barcode = substr($barcode, $weight_bar_pos_start-1,$weight_bar_pos_count);
                        $c_barcode = $this->db->query("SELECT * from itemmaster as a inner join itembarcode as b on a.itemcode = b.itemcode where barcode = '$_barcode'")->num_rows();
                        if($c_barcode == 0)
                        {   
                            $this->session->set_flashdata('message', 'Itemlink Not Found!!! : '.$barcode);
                            redirect('pchecker_controller/scan_barcode');
                        }else
                        {
                            $barcode = $_barcode;     
                        }
                    }

                    return $barcode;
                }
                else
                {
                    $barcode = $encode_barcode;
                    return $barcode;
                } 
                
            } 
            else
            {
                $barcode = $encode_barcode;
                return $barcode;
                //echo 'Please check barcode type and barcode. Please close and reopen browser.';
            }
        
    }

    public function decode_barcode_receiving($barcode)// basically tct use 
    {
        $encode_barcode = $barcode;
        $length_barcode = strlen($barcode);

        $get_barcode_setup = $this->db->query("SELECT * FROM backend_warehouse.`set_barcode_parameter` a WHERE a.`type_code` =  '$length_barcode' ");
        //echo $this->db->last_query();die;
        if($get_barcode_setup->num_rows() > 0)
        {
            $decode_barcode = substr($encode_barcode, $get_barcode_setup->row('bar_start')-1,$get_barcode_setup->row('bar_count'));
            $_SESSION['decode_qty'] = substr($encode_barcode, $get_barcode_setup->row('packsize_start')-1,$get_barcode_setup->row('packsize_count'));
        }   
        else
        {
            $decode_barcode = $encode_barcode;
            $_SESSION['decode_qty'] = 0;
        }
        return $decode_barcode;
    }   

    public function decode_barcode_general($barcode)// all customer
    {
        if(strpos($barcode,'*'))
        {
            $barcode_explode = explode('*', $barcode);

            $decode_barcode = $barcode_explode[1];
            $_SESSION['decode_qty'] = round($barcode_explode[0]);
        }
        else
        {
            $xsetup = $this->db->query("SELECT decode_receiving_barcode FROM backend.xsetup")->row('decode_receiving_barcode');
            if($xsetup <> 0)
            {

                $length_barcode = strlen($barcode);

                $get_barcode_setup = $this->db->query("SELECT * FROM backend_warehouse.`set_barcode_parameter` a WHERE a.`type_code` =  '$length_barcode' ");
                //echo $this->db->last_query();die;
                if($get_barcode_setup->num_rows() > 0)
                {
                    $decode_barcode = substr($barcode, $get_barcode_setup->row('bar_start')-1,$get_barcode_setup->row('bar_count'));
                    $_SESSION['decode_qty'] = substr($barcode, $get_barcode_setup->row('packsize_start')-1,$get_barcode_setup->row('packsize_count'));
                }   
                else
                {
                    $decode_barcode = $barcode;
                    $_SESSION['decode_qty'] = 0;
                }
            }
            else
            {
                $decode_barcode = $barcode;
                $_SESSION['decode_qty'] = 0;
            }
        }
        return  $decode_barcode;
    }
       
       

    
}
?> 
