<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>BATCH TRANSFER OUT</b></h5></td>
    <td width="20"><a href="<?php echo site_url('obatch_controller/main') ?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>  
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>          
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('obatch_controller/post_refno'); ?>">
<label>Transaction Scan Barcode</label><br>
<input type="text" class="form-control" style="background-color: #e6fff2" placeholder="Transaction Scan Barcode" name="refno" id="autofocus" autofocus />
<br>
<h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
</form>
</div>
<p>&nbsp;</p>
</body>
</html>
          