<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pchecker_model extends CI_Model
{
  
    public function __construct()
	{
		parent::__construct();
	}

	public function scan_result($barcode)
	{
		$sql = "SELECT a.itemcode,b.itemlink,b.packsize,a.Barcode,a.barDesc,CONCAT(b.price_include_tax,' (',IF(b.tax_code_supply='ZRL','Z','S'),')') 
		AS barPrice,b.AverageCost,b.StdCost,b.LastCost,CONCAT(ROUND((b.price_include_tax-b.AverageCost)/b.price_include_tax,2)*100,'%') AS Margin
		FROM itembarcode a INNER JOIN itemmaster b ON a.Itemcode=b.Itemcode WHERE a.Barcode= '$barcode'";
		$query = $this->db->query($sql);
        return $query;
	}

	public function itemlink($itemlink)
	{
		/*$sql = "SELECT Itemcode,Itemlink,Description,CONCAT('PS:',PackSize) 
		AS PackSize,price_include_tax AS SellingPrice FROM backend.itemmaster 
		WHERE itemlink='$itemlink' ORDER BY price_include_tax";*/
    $sql ="SELECT a.itemcode,a.itemlink,description,a.packsize, um, price_include_tax AS sellingprice, a.onhandqty, FORMAT(sumqoh/packsize,2) AS psqoh, sumqoh FROM itemmaster AS a
INNER JOIN (SELECT SUM(packsize*onhandqty) AS sumqoh, itemlink FROM itemmaster WHERE itemlink = '$itemlink') b ON a.itemlink = b.itemlink WHERE a.itemlink = '$itemlink'";
		$query = $this->db->query($sql);
		return $query;
	}

	public function stock($itemlink, $packsize)
	{
		$sql = "SELECT FORMAT(SUM(IF(b.Packsize=0,0,a.OnHandQty*b.PackSize))/'$packsize',3) AS OnHandQty,
		a.Location FROM locationstock a INNER JOIN itemmaster b ON a.itemcode=b.itemcode 
		WHERE b.itemlink='$itemlink' GROUP BY a.Location";
		$query = $this->db->query($sql);
		return $query;
	}

	function get_itemdetails()
     {

            $barcode = $_SESSION['barcode'];

           $query = $this -> db -> select('a.itemcode, a.itemlink, Description, a.um, Barcode,
                    ROUND(price_include_tax,2) AS price_include_tax,ROUND(sellingprice,2) AS sellingprice,
                    tax_code_supply, tax_code_purchase,
                    ROUND(averagecost,4) AS averagecost,
                    CONCAT("(GP   ",ROUND((sellingprice-averagecost)/sellingprice*100,1)," %)") AS avg_profit,
                    ROUND(lastcost,4) AS lastcost,
                    CONCAT("(GP   ",ROUND((sellingprice-lastcost)/sellingprice*100,1)," %)") AS last_profit,
                    ROUND(fifocost,4) AS fifocost,
                    CONCAT("(GP   ",ROUND((sellingprice-fifocost)/sellingprice*100,1)," %)") AS fifo_profit,
                    ROUND(stdcost,4) AS stdcost,
                    CONCAT("(GP   ",ROUND((sellingprice-stdcost)/sellingprice*100,1)," %)") AS std_profit,
                    CONCAT(itemtype,IF(consign = 1," (Consign) ","")) AS itemtype')
               -> from('(SELECT * FROM (
SELECT a.*,b.barcode FROM backend.itemmaster a
INNER JOIN backend.itembarcode b ON a.itemcode = b.itemcode
WHERE a.`SoldByWeight` = 0 AND b.barcode = "'.$barcode.'" ) a1
UNION ALL
SELECT * FROM (
SELECT a.*,b.barcode FROM backend.itemmaster a
INNER JOIN backend.itembarcode b ON a.itemcode = b.itemcode
WHERE a.`SoldByWeight` = 1 AND b.barcode = LEFT("'.$barcode.'",7)) a2) a')
               ->get();
               //echo $this->db->last_query();die;
           return $query->result_array();

     }

     public function get_item_qoh($itemlink)
     {

            $barcode = $_SESSION['barcode'];
/*           $query = $this -> db -> select('SUM(`ActualQty` * packsize)/packsize AS qoh')
               -> from('(SELECT itemlink FROM backend.itemmaster a inner join backend.`itembarcode` b on a.`Itemcode` = b.`Itemcode` where b.`Barcode` = "'.$barcode.'")a')
               -> join('backend.`itemmaster` b','a.itemlink = b.`ItemLink`')
               ->get();

           return $query->result_array();*/
            $sql = "SELECT FORMAT(sumqoh/packsize,2) AS qoh FROM itemmaster AS a
INNER JOIN (SELECT SUM(packsize*onhandqty) AS sumqoh, itemlink FROM itemmaster WHERE itemlink = '$itemlink') b
ON a.itemlink = b.itemlink
INNER JOIN itembarcode AS c ON a.itemcode = c.itemcode
WHERE barcode = '$barcode'";
    $query = $this->db->query($sql);
    return $query->result_array();


     }

     function get_item_qoh_c()
     {

            $barcode = $_SESSION['barcode'];


           $query = $this -> db -> select('ads, ams, aws, doh, min_date, max_date')
               -> from('(select a.itemcode,a.ads, a.ams, a.aws, a.doh, date_start AS min_date, date_stop AS max_date from backend.`po_ex_c` a
                    INNER JOIN backend.`itembarcode` b ON a.`Itemcode` = b.`Itemcode`
                    WHERE b.`Barcode` = "'.$barcode.'")a
                    GROUP BY a.itemcode;')
               ->get();

           return $query->result_array();

     }

     function get_item_promo()
     {

            $barcode = $_SESSION['barcode'];


           $query = $this -> db -> select('refno,datefrom,dateto,loc_group,cardtype,price_target,discount,price_net,promo_type ')
               -> from('(SELECT a.refno,datefrom,dateto,c.loc_group,IF(promo_by_tragetprice=1,price_target,price_system) AS price_target,
                    price_net,
                    b.cardtype,

                    IF(disc1value+disc2value=0,"",CONCAT(IF(promo_by_tragetprice=1,"","Sys $ Less "),IF(disc1type="%",CONCAT(ROUND(disc1value,1),disc1type),CONCAT(disc1type,disc1value)),
                    IF(disc2value=0,"",CONCAT("+",IF(disc2type="%",CONCAT(ROUND(disc2value,1),disc2type),CONCAT(disc2type,disc2value)))))) AS discount,

                    "Normal Promotion" AS promo_type

                    FROM backend.promo_supplier a

                    INNER JOIN
                    backend.promo_supplier_c b
                    ON a.pvc_guid=b.pvc_guid

                    INNER JOIN
                    backend.promo_supplier_loc c
                    ON a.pvc_guid=c.pvc_guid

                    INNER JOIN
                    (SELECT a.itemcode FROM backend.itemmaster a
                    INNER JOIN backend.itembarcode d
                    ON a.itemcode = d.itemcode
                    WHERE barcode="'.$barcode.'") d
                    ON b.itemcode=d.itemcode

                    WHERE a.`Posted` = 1 AND a.`CancelPromo` = 0 AND ((CURDATE() BETWEEN datefrom AND dateto) OR datefrom >= CURDATE())
                    AND trans_type IN ("pgl","psc") AND c.loc_group=(SELECT CODE FROM backend.locationgroup LIMIT 1) AND set_active=1) a

                    UNION ALL

                    SELECT refno,datefrom,dateto,loc_group,price_target,price_net,
                    cardtype,
                    IF(set_type="any",CONCAT("Buy any ",set_qty," @ ",ROUND(set_target_price,2)),CONCAT("Qty=",qtylimit," ->Buy 1 set @ ",ROUND(set_target_price,2))) AS discount,
                    promo_type

                    FROM

                    (SELECT refno,datefrom,dateto,loc_group,price_target,price_net,set_type,set_qty,
                    set_target_price,cardtype,promo_type,qtylimit

                    FROM

                    (SELECT a.refno,datefrom,dateto,c.loc_group,price_target,set_target_price AS price_net,set_type,
                    set_qty,set_target_price,qtylimit,
                    IF(b.cardtype="NA","",b.cardtype) AS cardtype,"Mix & Match" AS promo_type

                    FROM backend.promo_supplier a

                    INNER JOIN
                    backend.promo_supplier_c b
                    ON a.pvc_guid=b.pvc_guid

                    INNER JOIN
                    backend.promo_supplier_loc c
                    ON a.pvc_guid=c.pvc_guid

                    INNER JOIN
                    (SELECT a.itemcode FROM backend.itemmaster a
                    INNER JOIN backend.itembarcode d
                    ON a.itemcode = d.itemcode
                    WHERE barcode="'.$barcode.'") d
                    ON b.itemcode=d.itemcode

                    WHERE a.`Posted` = 1 AND a.`CancelPromo` = 0 AND ((CURDATE() BETWEEN datefrom AND dateto) OR datefrom >= CURDATE())
                    AND trans_type="Mix" AND c.loc_group = (SELECT CODE FROM backend.locationgroup LIMIT 1) AND set_active=1) a) a

                    ')

                   ->order_by('refno','cardtype')
                   ->get();

           return $query->result_array();

     }

     function get_podetails()
     {

           $session_data = $this->session->userdata('scan_barcode');
            $barcode = $session_data['barcode'];

            $query = $this->db->query("SELECT a.refno,CONCAT(a.scode,' - ',a.sname) AS supcode,podate,
                    IF(MOD(SUM(qty*b.packsize)/bar_packsize,1)=0,SUM(qty*b.packsize)/bar_packsize,
                    ROUND(SUM(qty*b.packsize)/bar_packsize,1)) AS qty_order,

                    0 AS qty_sent,

                    IF(MOD(SUM(temprecvqty*b.packsize)/bar_packsize,1)=0,SUM(temprecvqty*b.packsize)/bar_packsize,
                    ROUND(SUM(temprecvqty*b.packsize)/bar_packsize,1)) AS qty_rec,

                    IF(MOD(SUM(balanceqty*b.packsize)/bar_packsize,1)=0,SUM(balanceqty*b.packsize)/bar_packsize,
                    ROUND(SUM(balanceqty*b.packsize)/bar_packsize,1)) AS qty_bal,

                    deliverdate,expiry_date
                    FROM backend.pomain a

                    INNER JOIN backend.pochild b
                    ON a.refno=b.refno 

                    INNER JOIN 
                    (SELECT itemlink,a.itemcode AS bar_item,a.packsize AS bar_packsize FROM backend.itemmaster a
                    INNER JOIN backend.itembarcode b
                    ON a.itemcode=b.itemcode
                    WHERE barcode='$barcode') c
                    ON b.itemlink=c.itemlink

                    WHERE billstatus=1 AND expiry_date>=CURDATE() AND completed=0 /*removed on 17-04-23 - AND balanceqty>0*/

                    GROUP BY refno,b.itemlink

                    UNION ALL

                    SELECT refno,supcode,podate,qty_order,qty_sent,qty_rec,qty_bal,deliverdate,expiry_date FROM

                    (SELECT '1' AS sort,bar_item,a.refno,CONCAT('Stock in Transit from : ',locfrom) AS supcode,
                    docdate AS podate,
                    IF(MOD(SUM(b.qty*b.packsize)/bar_packsize,1)=0,SUM(b.qty*b.packsize)/bar_packsize,ROUND(SUM(b.qty*b.packsize)/bar_packsize,1)) AS qty_order,
                    IF(MOD(SUM(b.qty_actual*b.packsize)/bar_packsize,1)=0,SUM(b.qty_actual*b.packsize)/bar_packsize,ROUND(SUM(b.qty_actual*b.packsize)/bar_packsize,1)) AS qty_sent,
                    0 AS qty_rec,
                    0 AS qty_bal,
                    deliverdate,expiry_date
                    FROM backend.dc_pick a

                    INNER JOIN backend.dc_pick_child b
                    ON a.trans_guid=b.trans_guid

                    INNER JOIN 
                    (SELECT itemlink,a.itemcode AS bar_item,a.packsize AS bar_packsize FROM backend.itemmaster a
                    INNER JOIN backend.itembarcode b
                    ON a.itemcode=b.itemcode
                    WHERE barcode='$barcode') d
                    ON b.itemlink=d.itemlink

                    WHERE post_status=1 AND converted=0 AND expiry_date>=CURDATE()
                    AND locto=(SELECT CODE FROM backend.locationgroup LIMIT 1)

                    GROUP BY a.refno,b.itemlink

                    UNION ALL

                    SELECT '2' AS sort,bar_item,a.refno,
                    CONCAT('Stock Request from :',locfrom) AS supcode,
                    docdate AS podate,
                    IF(MOD(SUM(b.qty*b.packsize)/bar_packsize,1)=0,SUM(b.qty*b.packsize)/bar_packsize,ROUND(SUM(b.qty*b.packsize)/bar_packsize,1)) AS qty_order,
                    0 AS qty_sent,
                    0 AS qty_rec,
                    0 AS qty_bal,
                    deliverdate,expiry_date
                    FROM backend.dc_req a

                    INNER JOIN backend.dc_req_child b
                    ON a.trans_guid=b.trans_guid

                    INNER JOIN 
                    (SELECT itemlink,a.itemcode AS bar_item,a.packsize AS bar_packsize FROM backend.itemmaster a
                    INNER JOIN backend.itembarcode b
                    ON a.itemcode=b.itemcode
                    WHERE barcode='$barcode') d
                    ON b.itemlink=d.itemlink

                    LEFT JOIN backend.dc_pick_child c
                    ON b.child_guid=c.linkchildguid

                    WHERE post_status=1 AND converted=0 AND expiry_date>=CURDATE()
                    AND locto=(SELECT CODE FROM backend.locationgroup LIMIT 1)
                    AND c.linkchildguid IS NULL

                    GROUP BY a.refno,b.itemlink

                    ORDER BY sort) a

                    GROUP BY bar_item;");

           // $query = $this -> db -> select('refno, supcode,podate,qty_order,deliverdate,expiry_date')
           //     -> from('(SELECT a.refno,CONCAT(a.scode," - ",a.sname) AS supcode,podate,
           //          IF(MOD(SUM(balanceqty*b.packsize)/bar_packsize,1)=0,SUM(balanceqty*b.packsize)/bar_packsize,ROUND(SUM(balanceqty*b.packsize)/bar_packsize,1)) AS qty_order,
           //          deliverdate,expiry_date

           //          FROM backend.pomain a

           //          INNER JOIN backend.pochild b
           //          ON a.refno=b.refno

           //          INNER JOIN
           //          (SELECT itemlink,a.itemcode AS bar_item,a.packsize AS bar_packsize FROM backend.itemmaster a
           //          INNER JOIN backend.itembarcode b
           //          ON a.itemcode=b.itemcode
           //          WHERE barcode="'.$barcode.'") c
           //          ON b.itemlink=c.itemlink

           //          WHERE billstatus=1 AND expiry_date>=CURDATE() AND completed=0 AND balanceqty>0

           //          GROUP BY refno,b.itemlink)a

           //          UNION ALL

           //          SELECT * FROM (

           //          SELECT a.refno,locfrom AS supcode,docdate AS podate,
           //          IF(MOD(SUM(b.qty*b.packsize)/bar_packsize,1)=0,SUM(b.qty*b.packsize)/bar_packsize,ROUND(SUM(b.qty*b.packsize)/bar_packsize,1)) AS qty_order,
           //          deliverdate,expiry_date
           //          FROM backend.dc_req a

           //          INNER JOIN backend.dc_req_child b
           //          ON a.trans_guid=b.trans_guid

           //          INNER JOIN
           //          (SELECT itemlink,a.itemcode AS bar_item,a.packsize AS bar_packsize FROM backend.itemmaster a
           //          INNER JOIN backend.itembarcode b
           //          ON a.itemcode=b.itemcode
           //          WHERE barcode="'.$barcode.'") d
           //          ON b.itemlink=d.itemlink

           //          LEFT JOIN backend.dc_pick_child c
           //          ON b.child_guid=c.linkchildguid

           //          WHERE post_status=1 AND converted=0 AND expiry_date>=CURDATE()
           //          AND locto=(SELECT CODE FROM backend.locationgroup LIMIT 1)
           //          AND c.linkchildguid IS NULL

           //          GROUP BY a.refno,b.itemlink)a

           //          UNION ALL

           //          SELECT * FROM (

           //          SELECT a.refno,a.locfrom AS supcode,a.docdate AS podate,
           //          IF(MOD(SUM(c.qty_actual*c.packsize)/bar_packsize,1)=0,SUM(c.qty_actual*c.packsize)/bar_packsize,ROUND(SUM(c.qty_actual*c.packsize)/bar_packsize,1)) AS qty_po,
           //          a.deliverdate,a.expiry_date
           //          FROM backend.dc_req a

           //          INNER JOIN backend.dc_req_child b
           //          ON a.trans_guid=b.trans_guid

           //          INNER JOIN
           //          (SELECT itemlink,a.itemcode AS bar_item,a.packsize AS bar_packsize FROM backend.itemmaster a
           //          INNER JOIN backend.itembarcode b
           //          ON a.itemcode=b.itemcode
           //          WHERE barcode="'.$barcode.'") d
           //          ON b.itemlink=d.itemlink

           //          INNER JOIN backend.dc_pick_child c
           //          ON b.child_guid=c.linkchildguid

           //          INNER JOIN backend.dc_pick d
           //          ON c.trans_guid=d.trans_guid

           //          WHERE a.post_status=1 AND d.post_status=0 AND a.locto=(SELECT CODE FROM backend.locationgroup LIMIT 1)

           //          GROUP BY a.refno,b.itemlink)a')

           //         ->get();

                   return $query->result_array();

     }


     function get_grdetails()
     {

            $session_data = $this->session->userdata('scan_barcode');
            $barcode = $session_data['barcode'];

            $query = $this->db->query("SELECT a.`RefNo`,CONCAT(a.`Code`,' - ',a.`Name`) AS supcode,
            a.`grdate`,
            IF(MOD(SUM(b.`Qty`*b.packsize)/bar_packsize,1)=0,SUM(b.`Qty`*b.packsize)/bar_packsize,ROUND(SUM(b.`Qty`*b.packsize)/bar_packsize,1)) AS qty_received,
            ROUND(SUM(b.totalprice)/(SUM(b.`Qty`*b.packsize)/bar_packsize),4) AS netunitprice

            FROM backend.`grmain` a 
            INNER JOIN backend.`grchild` b 
            ON a.refno = b.refno

            INNER JOIN 
            (SELECT itemlink,a.itemcode AS bar_item,
            a.packsize AS bar_packsize FROM backend.itemmaster a
            INNER JOIN backend.itembarcode b
            ON a.itemcode=b.itemcode
            WHERE barcode='$barcode') c
            ON b.itemlink=c.itemlink

            WHERE qty<>0 AND billstatus=1

            GROUP BY refno,b.itemlink

            ORDER BY grdate DESC LIMIT 3;");

           // $query = $this -> db -> select('refno, supcode, grdate, qty_received,netunitprice')
           //     -> from('(SELECT a.`RefNo`,CONCAT(a.`Code`," - ",a.`Name`) AS supcode,
           //      a.`grdate`,
           //      IF(MOD(SUM(b.`Qty`*b.packsize)/bar_packsize,1)=0,SUM(b.`Qty`*b.packsize)/bar_packsize,ROUND(SUM(b.`Qty`*b.packsize)/bar_packsize,1)) AS qty_received,
           //      ROUND(SUM(b.totalprice)/(SUM(b.`Qty`*b.packsize)/bar_packsize),4) AS netunitprice

           //      FROM backend.`grmain` a
           //      INNER JOIN backend.`grchild` b
           //      ON a.refno = b.refno

           //      INNER JOIN
           //      (SELECT itemlink,a.itemcode AS bar_item,
           //      a.packsize AS bar_packsize FROM backend.itemmaster a
           //      INNER JOIN backend.itembarcode b
           //      ON a.itemcode=b.itemcode
           //      WHERE barcode="'.$barcode.'") c
           //      ON b.itemlink=c.itemlink

           //      WHERE qty<>0

           //      GROUP BY refno,b.itemlink)a

           //      ORDER BY grdate DESC LIMIT 3')
           //     ->get();

               return $query->result_array();

     }

}
?>