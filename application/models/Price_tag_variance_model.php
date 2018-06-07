<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class price_tag_variance_model extends CI_Model
{
  
    public function __construct()
    {
        parent::__construct();
    }

    public function decode_barcode($barcode)
    {
    	if(strpos($barcode,'*'))
        {
            $barcode_explode = explode('*', $barcode);
            $decode_barcode = $barcode_explode[1];

            return $decode_barcode;
        }
    }

    public function decode_price($barcode)
    {
        if(strpos($barcode,'*'))
        {
            $barcode_explode = explode('*', $barcode);

            $decode_price = number_format(round($barcode_explode[0])/100,2);

            return $decode_price;
        }
    }

    public function check_variance($barcode , $price)
    {
        $sql = "SELECT a.price_include_tax FROM backend.itemmaster a INNER JOIN backend.itembarcode b 
                ON a.Itemcode=b.itemcode WHERE a.price_include_tax = '$price' AND b.barcode = '$barcode'";
        
        $query = $this->db->query($sql)->num_rows();

        return $query;
    }

    public function get_variance_info($barcode , $price)
    {
        $sql = "SELECT a.Itemcode,a.Description, '$price' AS Price, a.price_include_tax, articleno,Remark,barcode,a.PackSize,a.Size 
            FROM backend.itemmaster a INNER JOIN backend.itembarcode b ON a.Itemcode=b.itemcode WHERE b.barcode = '$barcode'";
        
        $query = $this->db->query($sql);

        return $query;
    }

    public function get_item_info($barcode)
    {
        $sql = "SELECT a.Itemcode,a.Description,a.price_include_tax AS Price,articleno,Remark,barcode,a.PackSize,a.Size FROM backend.itemmaster a INNER JOIN backend.itembarcode b ON a.Itemcode=b.itemcode WHERE b.barcode = '$barcode'";
        
        $query = $this->db->query($sql);

        return $query;
    }

    function save($data)
    {
        $this->db->insert('backend_stktake.price_tag_verifier', $data);
    }

    function save_shelf_label($data)
    {
        $this->db->insert('backend_stktake.shelf_label', $data);
    }

    public function get_price($barcode)
    {
        $sql = "SELECT a.price_include_tax AS Price FROM backend.itemmaster a INNER JOIN backend.itembarcode b ON a.Itemcode=b.itemcode WHERE b.barcode = '$barcode'";
        $query = $this->db->query($sql)->row('Price');

        return $query;
    }
}