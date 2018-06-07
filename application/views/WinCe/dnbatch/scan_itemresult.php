<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>DN Batch</b><br>
    </h5></td>
    <td width="20"><a onclick="history.go(-1); else false;" href="<?php echo site_url('Dnbatch_controller/scan_item')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('Dnbatch_controller/add_qty'); ?>">
 <?php 
    foreach($item->result() as $row)
    {
 ?>
	<p><?php echo $_SESSION['batch_no'] ?><br>
	  <?php echo $row->name; ?><br>
	  <b>Description : </b><?php echo $row->description?><br>
	  <b>Barcode: </b><?php echo $row->barcode;?><br>
    <b>Tax Code Supply: </b><?php echo $row->tax_code_supply;?><br>
    <b>Tax Code Purchase: </b><?php echo $row->tax_code_purchase;?><br>
    <b>Last Purchase: </b><?php echo $row->podate;?>
	</p>
    <!-- <input value="<?php echo $row->itemcode?>" name="itemcode" type="hidden">
    <input value="<?php echo $row->barcode?>" name="barcode" type="hidden"> -->

    <input value="<?php echo $row->itemcode?>" name="itemcode" type="hidden">
    <input value="<?php echo $row->barcode?>" name="barcode" type="hidden">
    <input value="<?php echo $_SESSION['batch_no'];?>" name="batch_no" type="hidden">
    <input value="<?php echo convert_to_chinese($row->description, "UTF-8", "GB-18030");?>" name="description" type="hidden">
    <input value="<?php echo $scan_barcode;?>" name="scan_barcode" type="hidden">
    <input value="<?php echo $_SESSION['decode_qty'];?>" name="decode_qty" type="hidden">
  
  <?php
      }
  ?>  
    <p>
      <label for="textfield"><b>Qty :</b></label>
      <br>
      
      <input autofocus required value="<?php echo $qty;?>" type="number" step ="any" name="iqty" onfocus="this.select()" style="text-align:center;width:80px;" />
    </p>
    <p>
      <input type="submit" value="SAVE" name="view" class="btn_success">
    </p>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>

