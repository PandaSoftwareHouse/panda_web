<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>Goods Return</b></h5></td>
    <td width="20"><a href="<?php echo site_url('greturn_controller/dn_list'); ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

<form role="form" method="POST" id="myForm" action="<?php echo site_url('greturn_controller/scan_item_result'); ?>">
    <label>Scan Barcode</label><br>  
    <input type="text" style="background-color: #e6fff2" class="form-control input-md" placeholder="Scan Barcode" name="barcode" id="autofocus" required /> 
    <p>
    <h4 style="color:black"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4></p>    
</form>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>