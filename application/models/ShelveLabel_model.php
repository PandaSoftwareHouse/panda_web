<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class shelveLabel_model extends CI_Model
{
  
    public function __construct()
    {
        parent::__construct();
    }

    function save($data)
    {
        $this->db->insert('backend_stktake.shelf_label', $data);
    }

}