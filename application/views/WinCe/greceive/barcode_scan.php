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
<br>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/barcode_scan_result'); ?>">
  <label for="textfield">Scan Barcode</label><br>
  <input type="text" class="form-control" placeholder="Scan Barcode" name="barcode" id="autofocus" style="background-color: #e6fff2" required autofocus onblur="this.focus()"/>
</form>
<p><h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4></p>

  <?php if($by_batch == 1) 
    { 
  ?>
  <?php if($_SESSION['method'] == 'by_qty') 
    { 
  ?>
    <a href="<?php echo site_url('greceive_controller/barcode_scan')?>?by_batch" class="btn_primary">Scan By Batch</a>
  <?php
    }
    else
    {
  ?>
    <a href="<?php echo site_url('greceive_controller/barcode_scan')?>?by_qty" class="btn_success">Scan By Qty</a>
  <?php
    }
  ?>
  <?php
    }
  ?>
  <?php
  if($this->session->userdata('message_update_success'))
  {
    echo $this->session->userdata('message_update_success') <> '' ? $this->session->userdata('message_update_success') : ''; 
  }
  ?>
<p>&nbsp;</p>
</div>
</body>
</html>

