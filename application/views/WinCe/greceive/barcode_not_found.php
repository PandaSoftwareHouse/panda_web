<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b></h5></td>
    <td width="20"><a href="<?php echo site_url('greceive_controller/barcode_scan')?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<small><b><?php echo $_SESSION['sname']?></b> (<?php echo $_SESSION['po_no']?>) </small>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p>
<h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
</p>
<p>Option :<br>
  1. <a href="<?php echo site_url('greceive_controller/entry_as_itemcode_view')?>?itemcode=<?php echo $_SESSION['barcode']?>">Receive as Item Code</a><br>
 <!-- <?php
    if(isset($_SESSION['item_guid']))
    {
  ?>
  2. <a href="<?php echo site_url('greceive_controller/entry_as_RTV')?>?item_guid=<?php echo $_SESSION['item_guid']?>">RTV - Return To Vendor</a>
  <?php
    }
    else
  {
  ?>
  2. <a href="<?php echo site_url('greceive_controller/entry_as_RTV')?>?item_guid=">RTV - Return To Vendor</a>
  <?php
  }
  ?> -->

  <a href="<?php echo site_url('greceive_controller/entry_as_RTV')?>?item_guid=">RTV - Return To Vendor</a>
</p>
</div>
</body>
</html>

