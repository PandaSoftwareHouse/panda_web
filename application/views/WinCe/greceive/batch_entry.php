<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b></h5></td>
    <td width="20"><a href="<?php echo $backbutton?>?grn_guid=<?php echo $_SESSION['grn_guid']?>&po_no=<?php echo $_SESSION['po_no']?>&sname=<?php echo $_SESSION['sname']?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<small><b><?php echo $_SESSION['sname']?></b> (<?php echo $_SESSION['po_no']?>) </small>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<?php
  if($postButton == '1' && $_SESSION['grn_by_weight'] == '0')
  {
?>
  <a href="<?php echo site_url('greceive_controller/po_post_grn_scan?get_refno='.$grn_id)?>" class="btn_default"><small>POST DOCUMENT</small></a>
<?php
  }
?>

<table width="300">
<tr>
  <td>
<br>
   <a href="<?php echo site_url('greceive_controller/barcode_scan?by_qty'); ?>" class="btn_primary">+ ADD ITEM</a>
<?php
  if($_SESSION['grn_by_weight'] == '0')
  {
      ?>
      <a class="btn_default" href="<?php echo site_url('greceive_controller/po_print')?>?batch_guid=<?php echo $_SESSION['batch_guid']?>&print_type=batch_only&grn_guid=<?php echo $_SESSION['grn_guid']?>"><img src="<?php echo base_url('assets/icons/print.jpg');?>"> <medium>ITEM LIST</medium>
      <input type="checkbox" 
      <?php
      if($batch->row('send_print') != 0)
      {
          ?>
          checked disabled
          <?php
      }
      else
      {
          ?>
          disabled
          <?php
      }
       ?>
      ></a>
      <?php
      if($grda_button != 0)
      {
          ?>
          <a class="btn_default" href="<?php echo site_url('greceive_controller/po_print')?>?grn_guid=<?php echo $_SESSION['grn_guid']?>&print_type=batch_list"><img src="<?php echo base_url('assets/icons/printgrda.jpg');?>"><medium>GRDA LIST</medium></a>
          <?php

      };
                                
  };
  ?><br><br>
  </td>
  </tr>
</table>
  <h5><b>Batch ID :</b><?php echo $batch->row('batch_id')?><br>
      <b>B.Barcode :</b><?php echo $batch->row('batch_barcode')?></h5></p>
   <h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
<table class="cTable" cellspacing="2" width="350">
  <thead>
    <tr>
        <th class="cTD">Line</th>
        <th class="cTD">DO.<br>Qty</th>
        <th class="cTD">Rec.<br>Qty</th>
        <th class="cTD">Var.<br>Qty</th>
        <th class="cTD">Description</th>
        <th class="cTD">Total Weight</th>
        <th class="cTD">Average Unit Weight</th>
    </tr>
  </thead>
  <tbody>
    <?php
        foreach ($item->result() as $row)
        {  
    ?>
    <tr>
        <td class="cTD"><?php echo $row->lineno; ?></td>
        <td class="cTD"><center><?php echo $row->qty_do; ?></center></td>
        <td class="cTD"><center><?php echo $row->qty_rec; ?></center></td>
        <td class="cTD"><center><?php echo $row->qty_diff; ?></center></td>
        <td class="cTD">
          <?php
            if($row->scan_type == 'BATCH')
            {
          ?>
              <a href="<?php echo site_url('greceive_controller/item_c')?>?item_guid=<?php echo $row->item_guid?>&batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->scan_description; echo '&nbsp'?><img src="<?php echo base_url('assets/icons/batch.jpg');?>"></a>
          <?php
            }
            else
            {
          ?>
              <a href="<?php echo site_url('greceive_controller/item_entry_flow')?>?item_guid=<?php echo $row->item_guid?>&batch_guid=<?php echo $row->batch_guid?>"><?php echo $row->scan_description; ?></a>
          <?php
            }
          ?>
        </td>
        <td class="cTD"><?php echo $row->scan_weight_total; ?></td>
        <td class="cTD"><?php echo $row->scan_weight; ?>
        <a style="float:right;" href="<?php echo site_url('greceive_controller/batch_itemDelete')?>?item_guid=<?php echo $row->item_guid?>&batch_guid=<?php echo $row->batch_guid?>" onclick="return check()"><img src="<?php echo base_url('assets/icons/garbage.jpg');?>">
        </a></td>
    </tr>
    <?php
        }
    ?>
  </tbody>
  </table>
<p>&nbsp;</p>  
</div>
</body>
</html>

