<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reprint_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reprint_model');
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

            $data = array(
                'module' => $this->db->query("SELECT * from backend_warehouse.reprint_table order by module_name asc"),
            );

            $this->load->view('header');
            $this->load->view('reprint/index',$data);
            $this->load->view('footer');

        }
        else
        {
            redirect('main_controller/index');
        }
    }

    public function choose_module()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $print_guid = $this->input->post('module');

            $query = $this->db->query("SELECT query from backend_warehouse.reprint_table where print_guid = '$print_guid'")->row('query');

            $result = $this->db->query($query);

            $data = array(
                'result' => $result,
                'topic' => $print_guid,
            );

            $this->load->view('header');
            $this->load->view('reprint/display_data',$data);
            $this->load->view('footer');
        }
        else
        {
            redirect('main_controller/index');
        }
    }

    public function flag()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $print_guid = $_REQUEST['topic'];
            $trans_guid = $_REQUEST['trans_guid'];

            $check_module = $this->db->query("SELECT module_name from backend_warehouse.reprint_table where print_guid = '$print_guid'")->row('module_name');

            if($check_module == 'Price Change')
            {
                $this->db->query("UPDATE backend.price_change_req set print_req = '2' where trans_guid = '$trans_guid'");
                echo 'asdasd';
                $this->session->set_flashdata('message', 'Printed!');
                redirect("Reprint_controller");
            };
        }
        else
        {
            redirect('main_controller/index');
        }
    }

 
}
?>

