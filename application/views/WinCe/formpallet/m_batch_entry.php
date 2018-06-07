<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>FORM PALLET</b></h5></td>
    <td width="5"><a href="<?php echo site_url('formpallet_controller/m_po_print')?>?batch_guid=<?php echo $_SESSION['batch_guid']?>&print_type=batch_only"><img src="<?php echo base_url('assets/icons/print.jpg') ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('formpallet_controller/m_batch')?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p> 
<small><b><?php echo $_SESSION['manual_batch_barcode']?></b></small>
<br>
<a href='<?php echo site_url('formpallet_controller/m_barcode_scan')?>' class="btn_primary">+ ADD ITEM</a><br> 
<h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
<h5><b>Batch :</b><?php echo $batch->row('batch_id')?></h5>
                         
<table class="cTable">
    <thead>
        <tr>
            <th class="cTD">Line</th>
            <th class="cTD">DO.Qty</th>
            <th class="cTD">Rec.Qty</th>
            <th class="cTD">Description</th>
            <th class="cTD">Total Weight</th>
            <th class="cTD">Average <br>Unit Weight</th>
        </tr>
    </thead>
<tbody>

<?php
    foreach ($item->result() as $row)
    {  
?>
        <tr>
            <td class="cTD"><?php echo $row->lineno; ?></td>
            <td class="cTD"><?php echo $row->qty_do; ?></td>
            <td class="cTD"><?php echo $row->qty_rec; ?></td>
            <td class="cTD"><a href="<?php echo site_url('formpallet_controller/m_item_entry_edit')?>?item_guid=<?php echo $row->item_guid?>&batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->scan_description; ?></a>
            <a style="float:right;" href="<?php echo site_url('formpallet_controller/batch_itemDelete')?>?item_guid=<?php echo $row->item_guid?>&batch_guid=<?php echo $row->batch_guid?>" onclick="return check()"><img src="<?php echo base_url('assets/icons/garbage.jpg') ?>"></a>
            </td>
            <td class="cTD"><?php echo $row->scan_weight_total; ?></td>
            <td class="cTD"><?php echo $row->scan_weight; ?></td>
         </tr>
    <?php
        }
    ?>
    </tbody>
</table>

</div>
<p>&nbsp;</p>
</body>
</html>