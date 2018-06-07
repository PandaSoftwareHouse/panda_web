<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dnbatch_model extends CI_Model
{
  
    public function __construct()
	{
		parent::__construct();
	}

    public function insertsysrun()
    {
        $sql = "INSERT INTO sysrun (TYPE,CODE,CurrentNo,NoDigit,YYYY,MM,Remarks) (SELECT 'DNBAT','DNB',0,4,YEAR(NOW()),MONTH(NOW()),'Mobile DN by Batch')";
        $query = $this->db->query($sql);
        return $query;

    }

    public function updatesysrun()
    {
        $sql = "UPDATE sysrun set YYYY=Year(Now()),MM=Month(Now()),CurrentNo=0 where type='DNBAT'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function updaterunningnum()
    {
        $sql = "UPDATE sysrun set CurrentNo=CurrentNo+1 where type='DNBAT'";
        $query = $this->db->query($sql);
        return $query;    
    }

    public function insert_batchno()
    {
        $dnbatch_sup_code = $_SESSION['dnbatch_sup_code'];
        $dnbatch_sup_name = addslashes($_SESSION['dnbatch_sup_name']);
        $username = $_SESSION['username'];
        $location = $_SESSION['location'];
        $sublocation = $_SESSION['sub_location'];
        $batch_no = $_SESSION['batch_no'];

        $sql = "INSERT INTO dbnote_batch(dbnote_guid,created_at,updated_at,converted,canceled,       
                batch_no,sup_code,sup_name,created_by,updated_by,send_print,location,sub_location)  
                SELECT REPLACE(UPPER(UUID()),'-','') AS dbnote_guid,NOW() AS created_at ,   
                NOW() AS updated_at,0 AS converted,0 AS canceled, 
                '$batch_no' AS batch_no,'$dnbatch_sup_code' AS sup_code, 
                '$dnbatch_sup_name' AS sup_name,  
                '$username' created_by,
                '$username' updated_by, 1 AS send_print, 
                '$location' as location,
                '$sublocation' as sub_location ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function insert_dbnote_c($dbnote_c_guid, $itemcode, $iqty, $barcode)
    {

        $sql = "INSERT INTO dbnote_batch_c(dbnote_c_guid,created_at,updated_at,dbnote_guid,itemcode,qty,created_by,updated_by,scan_barcode)
            VALUE(
            '".$dbnote_c_guid."' 
            ,NOW() 
            ,NOW()  
            , '".$_SESSION['dbnote_guid']."'  
            , '$itemcode' 
            , '$iqty'  
            , '".$_SESSION['username']."' 
            , '".$_SESSION['username']."'  
            , '$barcode')";
        $query = $this->db->query($sql);
        return $query;
    }

    public function update_dbnote_c()
    {
        $sql = "UPDATE dbnote_batch_c a INNER JOIN itemmaster b ON a.itemcode=b.itemcode 
            SET a.itemlink=b.itemlink,a.packsize=b.packsize,a.description=b.description
            ,a.dept=b.dept, a.subdept=b.subdept,a.category=b.category
            ,a.lastcost=b.lastcost,a.averagecost=b.averagecost
            ,a.sellingprice=b.sellingprice, a.um=b.um WHERE dbnote_guid='".$_SESSION['dbnote_guid']."'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function update_qty($dbnote_c_guid,$iqty)
    {
        $sql = "UPDATE dbnote_batch_c SET qty= '$iqty', updated_at = NOW(), updated_by = '".$_SESSION['username']."'  WHERE dbnote_c_guid='$dbnote_c_guid' ";
        $query = $this->db->query($sql);
        return $query;
    }


}
?>