<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>Scan Item</b><br>
    </h5></td>
    <td width="20"> <a href="<?php echo site_url('dnbatch_controller/main') ?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('dnbatch_controller/scan_supresult'); ?>">
  <p>
  <b><i>Scan Item to create a supplier batch</i></b><br><br>
    <label for="textfield">Scan Barcode</label>
    <br>
    <input type="text" name="barcode" id="autofocus" class="form-control input-md" style="background-color: #e6fff2">
  </p>
   <h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
</form>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>

