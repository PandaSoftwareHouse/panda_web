<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>FORM PALLET</b></h5><br><small><b>POST</b></small></td>
    <td width="20"><a href="<?php echo site_url('formpallet_controller/m_batch')?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table> 
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('formpallet_controller/m_post_stock_scan'); ?>">
<label>Scan Transaction Barcode</label><br>
<input type="text" class="form-control input-md" placeholder="Scan Transaction Barcode" name="batch_barcode" id="autofocus" required autofocus onblur="this.focus()"/>
</form>
<br>
<h4><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
</div>
<p>&nbsp;</p>
</body>
</html>