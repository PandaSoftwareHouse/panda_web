<html>
<body onLoad="autofocus()">
	<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>Error</b></h5></td>
    <td width="20"><a href="<?php echo site_url('general_scan_controller/scan_item')?>?web_guid=<?php echo $_SESSION['web_guid'];?>&acc_code=<?php echo $_SESSION['acc_code']; ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<!-- <p><h4>Barcode Not Found In Selected Supplier</h4></p> -->
<p><h4>Barcode : <?php echo $barcode_error; ?></h4></p>
<p><h4>Itemcode Is Not Assigned On This Supplier</h4></p>
</div>
</body>
</html>