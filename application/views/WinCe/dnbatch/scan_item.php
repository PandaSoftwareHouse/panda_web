<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>DN Batch</b><br>
    </h5></td>
    <td width="20"><a href="<?php echo site_url('Dnbatch_controller/itemlist?batch_no='.$_SESSION['batch_no']) ?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('Dnbatch_controller/scan_itemresult'); ?>">
  <label for="textfield">Scan Barcode</label><br>
  <input type="text" name="barcode" id="autofocus" class="form-control input-md" style="background-color: #e6fff2">
</form>
  <h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
<p>&nbsp;</p>
</div>
</body>
</html>

