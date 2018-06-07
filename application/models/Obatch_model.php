<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class obatch_model extends CI_Model
{
  
    public function __construct()
	{
		parent::__construct();
	}

    public function insertsysrun()
    {
        $sql = "INSERT INTO backend_warehouse.set_sysrun (run_type,run_code,run_currentno,run_digit,run_year,run_month,run_day,run_date) (SELECT 'BATCH_TRANS','TR',0,4,YEAR(NOW()),MONTH(NOW()),DAY(NOW()),DATE(NOW()) )";
        $query = $this->db->query($sql);
        return $query;

    }

    public function updatesysrun()
    {
        $sql = "UPDATE backend_warehouse.set_sysrun SET run_year=YEAR(NOW()),run_month=MONTH(NOW()),run_day=DAY(NOW()),run_date=DATE(NOW()),run_currentno=0 WHERE run_type='BATCH_TRANS'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function updaterunningnum()
    {
        $sql = "UPDATE backend_warehouse.set_sysrun set run_currentno = run_currentno+1 where 
        run_type = 'BATCH_TRANS'";
        $query = $this->db->query($sql);
        return $query;    
    }

    public function insert_batchno($remark,$get_subloc,$get_loc)
    {

        $sql = "INSERT INTO backend_warehouse.b_trans (trans_guid, trans_type, refno, loc_group_from, location_from, sublocation_from, location_to, sublocation_to, remark, delivered,created_at,created_by,updated_at,updated_by)
            (SELECT REPLACE(UPPER(UUID()), '-', '') AS trans_guid
            , 'BATCH_TRANS' AS trans_type
            , '".$_SESSION['refno']."' AS refno
            , '".$_SESSION['loc_group']."' AS loc_group_from
            , '".$_SESSION['location']."' AS location_from
            , '".$_SESSION['sub_location']."' AS sublocation_from
            , '$get_loc' AS location_to
            , '$get_subloc' AS sublocation_to
            , '$remark' AS remark
            , '0' AS delivered
            , NOW() AS created_at
            , '".$_SESSION['username']."' AS created_by
            , NOW() AS updated_at
            , '".$_SESSION['username']."' AS updated_by)";
        $query = $this->db->query($sql);
        return $query;
    }

    public function insert_b_child($barcode,$batch_guid, $goods_pallet_weight, $iqty,$variance,$remark)
    {

        $sql = "INSERT INTO backend_warehouse.b_trans_c (child_guid, trans_guid, batch_barcode, batch_guid, goods_pallet_weight, pick_gdpl_weight, pick_weight_variance, pick_remark, verified_remark, verified_by, created_at, created_by, updated_at, updated_by)
            (SELECT  REPLACE(UPPER(UUID()), '-', '') AS child_guid
            , '".$_SESSION['trans_guid']."' AS trans_guid 
            , '$barcode' AS batch_barcode 
            , '$batch_guid' AS batch_guid
            , '$goods_pallet_weight' AS goods_pallet_weight
            , '$iqty' AS pick_gdpl_weight
            , '$variance' AS pick_weight_variance
            , '$remark' AS pick_remark
            , '' AS verified_remark
            , '' AS verified_by
            , NOW() AS created_at
            ,'".$_SESSION['username']."' AS created_by
            , NOW() AS updated_at
            ,'".$_SESSION['username']."' AS updated_by) ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function update_child($child_guid,$iqty,$variance,$remark)
    {
        $sql = "UPDATE backend_warehouse.b_trans_c SET pick_gdpl_weight = '$iqty', pick_weight_variance = '$variance', pick_remark = '$remark', updated_at = NOW(), updated_by = '".$_SESSION['username']."'  WHERE child_guid='$child_guid' ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function updateremark($remark,$get_subloc,$get_loc,$trans_guid)
    {
        $sql = "UPDATE backend_warehouse.b_trans set remark = '$remark', sublocation_to ='$get_subloc', location_to = '$get_loc' where trans_guid = '$trans_guid' ";
        $query = $this->db->query($sql);
        return $query;
    }

}
?>