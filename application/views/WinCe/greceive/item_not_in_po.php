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
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p><h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4></p>
<p>Option :<br>
  1. <a href="<?php echo site_url('greceive_controller/entry_as_RTV_or_FOC')?>?item_guid=&rec_type=FOC">Receive as FOC Item</a><br>
  2. <a href="<?php echo site_url('greceive_controller/entry_as_RTV_or_FOC')?>?item_guid=&rec_type=RTV">RTV - Return To Vendor</a>

</p>
</div>
</body>
</html>

