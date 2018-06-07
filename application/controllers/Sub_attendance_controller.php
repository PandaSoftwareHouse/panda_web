<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/views/MyReport.php";

class sub_attendance_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('sub_attendance_model');
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
        $data['supp_array'] = $this->sub_attendance_model->get_data();
        $browser_id = $_SERVER["HTTP_USER_AGENT"];

        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/header');
            $this->load->view('WinCe/sub_attendance/main',$data);
        }
        else
        {
            $this->load->view('header');
            $this->load->view('sub_attendance/main',$data);
            $this->load->view('footer');
        }
    }

    public function display_date() //add
    {  
        $this->form_validation->set_rules('date', 'Date', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            redirect('Sub_attendance_controller/main');
        }
        else
        {
            $input_date = $this->input->post('date');

            $row['join_date'] = $input_date;
            $date = date('Y-m-d', strtotime( $row['join_date'] ));

            $data['supp_array'] = $this->sub_attendance_model->get_date_data($date);
            $browser_id = $_SERVER["HTTP_USER_AGENT"];

            if(strpos($browser_id,"Windows CE"))
            {
                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/sub_attendance/main',$data);
            }
            else
            {
                $this->load->view('header');
                $this->load->view('sub_attendance/main',$data);
                $this->load->view('footer');
            }
        }  
    }

    public function display_date1() //add
    {  
        $date = $_SESSION['date'];
        $data['supp_array'] = $this->sub_attendance_model->get_date_data($date);
        $browser_id = $_SERVER["HTTP_USER_AGENT"];

        if(strpos($browser_id,"Windows CE"))
        {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/sub_attendance/main',$data);
        }
        else
        {
            $this->load->view('header');
            $this->load->view('sub_attendance/main',$data);
            $this->load->view('footer');
        }
    }

    public function add_record()
    {
        $this->load->model('sub_attendance_model');
        $data['supp_array'] = $this->sub_attendance_model->get_supplier();
        $browser_id = $_SERVER["HTTP_USER_AGENT"];

        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/header');
            $this->load->view('WinCe/sub_attendance/supp_list',$data);
        }
        else
        {
            $this->load->view('header');
            $this->load->view('sub_attendance/supp_list',$data);
            $this->load->view('footer');
        }
    }

    public function proceed_supp()
    {
        /*$supplier['array'] = $this->input->post('supplier');*/
        $code = $this->input->post('supplier');
        $supplier = array (
            'supp'=> $this->db->query("SELECT Code, name from backend.supcus where Code = '$code'")->row('name'),
            'code' => $code,
             );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];

        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/header');
            $this->load->view('WinCe/sub_attendance/add_att',$supplier);
        }
        else
        {
            $this->load->view('header');
            $this->load->view('sub_attendance/add_att',$supplier);
            $this->load->view('footer');
        }
    }

    public function insert()
    {        
        /*$this->form_validation->set_rules('refno', 'Reference No.', 'trim|required');
        $this->form_validation->set_rules('Amount', 'Amount', 'trim|required');

        if ($this->form_validation->run() == FALSE)
                {
                    $code = $this->input->post('supplier');
                    $supplier = array (
                            'supp'=> $this->db->query("SELECT Code, name as supplier from backend.supcus where Code = '$code'")->row('supplier'),
                            'code' => $code,
                             );
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];

                    if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/sub_attendance/add_att',$supplier);
                    }
                    else
                    {
                        $this->load->view('header');
                        $this->load->view('sub_attendance/add_att',$supplier);
                        $this->load->view('footer');
                    }
                    
                }
                else
                {*/
                    $code = $this->input->post("code");
                    $supplier = addslashes($this->input->post("supplier"));//change
                    $refno = addslashes($this->input->post("refno"));//change
                    $Amount = $this->input->post("Amount");
                    $gst = $this->input->post("gst");
                    $remark = addslashes($this->input->post("remark"));//change

                    $result = $this->db->query("SELECT Suppliers,RefNo,Amount FROM backend_warehouse.attendance WHERE Suppliers='$supplier' AND RefNo='$refno'")->num_rows();

                    if ($result >= 1)
                    {
                        $this->session->set_flashdata('message', "Supplier and reference no. already exists.");
                        redirect('sub_attendance_controller/main');
                    }
                    else
                    {
                        $this->sub_attendance_model->insert_data($gst,$code,$supplier,$refno,$Amount,$remark);
                        $this->session->set_flashdata('message', "Data inserted successfully.");
                        redirect ("sub_attendance_controller/main");
                    }
    }

    public function update()
    {        
        $trans = $_REQUEST['trans']; //get input from view
        $data ["refno"] = $this->sub_attendance_model->fetch_single_data($trans);
        $browser_id = $_SERVER["HTTP_USER_AGENT"];

        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/header');
            $this->load->view('WinCe/sub_attendance/update_att',$data);
        }
        else
        {
            $this->load->view('header');
            $this->load->view('sub_attendance/update_att',$data);
            $this->load->view('footer'); 
        }
        
    }

    public function update_into()
    {        
        $this->form_validation->set_rules('refno', 'Reference No.', 'trim|required');
        $this->form_validation->set_rules('Amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('gst', 'GST', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $trans = $_REQUEST['trans'];
            $data ["refno"] = $this->sub_attendance_model->fetch_single_data($trans);
            $browser_id = $_SERVER["HTTP_USER_AGENT"];

            if(strpos($browser_id,"Windows CE"))
            {
                $this->load->view('WinCe/header');
                $this->load->view('WinCe/sub_attendance/update_att',$data);
            }
            else
            {
                $this->load->view('header');
                $this->load->view('sub_attendance/update_att',$data);
                $this->load->view('footer');
            }
            
        }
        else
        {
            $supplier = addslashes($this->input->post("supplier")); //change
            $refno = addslashes($this->input->post("refno")); //change
            $Amount = $this->input->post("Amount");
            $gst = $this->input->post("gst");
            $remark = addslashes($this->input->post("remark")); //change
            $date = $this->input->post("date"); //add
            $sessiondata = array('date' => $date); //add
            $this->session->set_userdata($sessiondata); //add

            $result = $this->db->query("SELECT Suppliers,RefNo,Amount,GST FROM backend_warehouse.attendance WHERE Suppliers='$supplier' AND RefNo='$refno' AND Amount='$Amount' AND Remark='$remark' AND GST='$gst' ")->num_rows();

            if ($result >= 1)
            {
                $this->session->set_flashdata('message', "Data unchanged.");
                redirect('Sub_attendance_controller/display_date1');
            }
            else
            {
                $trans = $_REQUEST['trans']; //get input from view
                /*$supplier = $this->input->post("supplier");
                $refno = $this->input->post("refno");
                $Amount = $this->input->post("Amount");
                $remark = $this->input->post("remark");*/

                /*$created_at = $this->db->query("SELECT created_at as A FROM backend_warehouse.att WHERE web_guid = '$trans'")->row('A');
                $created_by = $this->db->query("SELECT created_by as B FROM backend_warehouse.att WHERE web_guid = '$trans'")->row('B');*/
                $username = $_SESSION['username'];

                $db_supplier = addslashes($this->db->query("SELECT Suppliers FROM backend_warehouse.attendance WHERE web_guid = '$trans'")->row('Suppliers'));
                
                switch ($db_supplier) 
                {
                    case $supplier:
                        break;
                    default:
                        $this->db->query("INSERT INTO backend_warehouse.attendance_user_log (trans_guid,module,field,value_guid,value_from,value_to,updated_at,updated_by) VALUES (REPLACE(UPPER(UUID()),'-',''),'Attendance','Suppliers','$trans','$db_supplier','$supplier',NOW(),'$username')");
                }

                $db_refno = addslashes($this->db->query("SELECT RefNo FROM backend_warehouse.attendance WHERE web_guid = '$trans'")->row('RefNo'));

                switch ($db_refno) 
                {
                    case $refno:
                        break;
                    default:
                        $this->db->query("INSERT INTO backend_warehouse.attendance_user_log (trans_guid,module,field,value_guid,value_from,value_to,updated_at,updated_by) VALUES (REPLACE(UPPER(UUID()),'-',''),'Attendance','Reference No.','$trans','$db_refno','$refno',NOW(),'$username')");
                }

                $db_Amount = addslashes($this->db->query("SELECT Amount FROM backend_warehouse.attendance WHERE web_guid = '$trans'")->row('Amount'));

                switch ($db_Amount) 
                {
                    case $Amount:
                        break;
                    default:
                        $this->db->query("INSERT INTO backend_warehouse.attendance_user_log (trans_guid,module,field,value_guid,value_from,value_to,updated_at,updated_by) VALUES (REPLACE(UPPER(UUID()),'-',''),'Attendance','Amount','$trans','$db_Amount','$Amount',NOW(),'$username')");
                }

                $db_gst = addslashes($this->db->query("SELECT GST FROM backend_warehouse.attendance WHERE web_guid = '$trans'")->row('GST'));

                switch ($db_gst) 
                {
                    case $gst:
                        break;
                    default:
                        $this->db->query("INSERT INTO backend_warehouse.attendance_user_log (trans_guid,module,field,value_guid,value_from,value_to,updated_at,updated_by) VALUES (REPLACE(UPPER(UUID()),'-',''),'Attendance','GST','$trans','$db_gst','$gst',NOW(),'$username')");
                }

                $db_remark = addslashes($this->db->query("SELECT Remark FROM backend_warehouse.attendance WHERE web_guid = '$trans'")->row('Remark'));

                switch ($db_remark) 
                {
                    case $remark:
                        break;
                    default:
                        $this->db->query("INSERT INTO backend_warehouse.attendance_user_log (trans_guid,module,field,value_guid,value_from,value_to,updated_at,updated_by) VALUES (REPLACE(UPPER(UUID()),'-',''),'Attendance','Remark','$trans','$db_remark','$remark',NOW(),'$username')");
                }

                $this->sub_attendance_model->update_data($gst,$supplier,$refno,$Amount,$remark, $trans);
                $this->session->set_flashdata('message', "Successfully updated.");
                redirect ("Sub_attendance_controller/display_date1");
            }

            
        } 
    }  
       

    /*public function add_supp()
    {
        $browser_id = $_SERVER["HTTP_USER_AGENT"];

        if(strpos($browser_id,"Windows CE"))
        {
            $this->load->view('WinCe/header');
            $this->load->view('WinCe/sub_attendance/sub_attendance_view4');
        }
        else
        {
            $this->load->view('header');
            $this->load->view('sub_attendance/sub_attendance_view4');
            $this->load->view('footer');
        }
        
    }*/

    /*public function insert_supp()
    {        
        $this->form_validation->set_rules('code', 'Code', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == FALSE)
                { 
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];

                    if(strpos($browser_id,"Windows CE"))
                    {
                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/sub_attendance/sub_attendance_view4');
                    }
                    else
                    {
                        $this->load->view('header');
                        $this->load->view('sub_attendance/sub_attendance_view4');
                        $this->load->view('footer');
                    }
                    
                }
                else
                {
                    $code = $this->input->post("code");
                    $name = $this->input->post("name");
                    $address = $this->input->post("address");                   
                    $this->sub_attendance_model->insert_supplier($code,$name,$address);
                    redirect ("sub_attendance_controller/add_record");
                }   
    }*/

    public function report_ui()
    {    
        $data['supp_array'] = $this->sub_attendance_model->get_supplier();

        $this->load->view('header');
        $this->load->view('sub_attendance/report', $data);
        $this->load->view('footer'); 
    }

    public function generate_report()
    {    
        $supplier = $this->input->post('supplier');
        $code = $this->input->post('code');
        //$new_supp = json_encode($supplier);
        //echo $new_supp;
        //$new_supp1 = str_replace("[","","$new_supp");
        //$new_supp2 = str_replace("]","","$new_supp1");
        //echo $new_supp2;
        //$this->db->query("UPDATE backend_warehouse.attendance SET Remark='1' WHERE Suppliers In ($new_supp2)");
        $report = new MyReport(array("supplier" => $supplier,
            "code" => $code));
        $report->run()->render();    
    }

}
?>