<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>FORM PALLET</b></h5></td>
    <td width="20"><a href="<?php echo site_url('formpallet_controller/m_batch_entry')?>?batch_guid=<?php echo $_SESSION['batch_guid']?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<small><b><?php echo $_SESSION['manual_batch_barcode']?></b> </small>
<br>                  
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('formpallet_controller/m_barcode_scan_result'); ?>">

<label>Scan Barcode</label><br>                      
<input type="text" class="form-control input-md" style="background-color: #e6fff2" placeholder="Scan Barcode" name="barcode" id="autofocus" required autofocus onblur="this.focus()"/>

</form>

<br>
<h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
                
</div>
<p>&nbsp;</p>
</body>
</html>