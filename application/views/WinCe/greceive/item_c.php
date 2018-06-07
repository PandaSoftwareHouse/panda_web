<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b></h5></td>
    <td width="20"><a href="<?php echo site_url('greceive_controller/batch_entry')?>?batch_guid=<?php echo $_SESSION['batch_guid']?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<small><b><?php echo $_SESSION['sname']?></b> (<?php echo $_SESSION['po_no']?>) </small>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<a href='<?php echo site_url('greceive_controller/barcode_scan?by_qty'); ?>' class="btn_primary">+ ADD ITEM</a>

<form role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/item_c_update_do_qty')?>?item_guid=<?php echo $_REQUEST['item_guid']?>&batch_guid=<?php echo $_REQUEST['batch_guid']?>">
<h5 ><b>DO Qty</b></h5>
<input value="<?php echo $do_qty?>" style="text-align:center;width:80px;background-color:#ffff99" name="do_qty" type="number" step="any" onchange="this.form.submit()" onfocus="this.select()"/>
</form>

<h4>Scan By Batch List</h4>
<h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                            
<table class="cTable" cellspacing="2" width="400">
  <thead>
    <tr>
        <th class="cTD">Line</th>
        <th class="cTD">Rec.<br>Qty</th>
        <th class="cTD">Description</th>
        <th class="cTD">Barcode</th>
        <th class="cTD">Created At</th>
    </tr>
  </thead>
  <tbody>
  <?php
      foreach ($get_item_c->result() as $row)
      {  
  ?>
    <tr>
      <td class="cTD"><?php echo $row->lineno; ?></td>
      <td class="cTD"><?php echo $row->qty_rec; ?></td>
      <td class="cTD"><?php echo $row->scan_description; ?></td>
      <td class="cTD"><?php echo $row->scan_barcode; ?></td>
      <td class="cTD"><?php echo $row->created_at; ?>
        <a style="float:right;" href="<?php echo site_url('greceive_controller/item_entry_edit')?>?item_c&item_guid_c=<?php echo $row->item_guid_c?>&item_guid=<?php echo $row->item_guid ?>&batch_guid=<?php echo $row->batch_guid?>&redirect=<?php echo $_SERVER['REQUEST_URI']?>" onclick="return check()"><img src="<?php echo base_url('assets/icons/garbage.jpg');?>">
        </a>
      </td>
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

