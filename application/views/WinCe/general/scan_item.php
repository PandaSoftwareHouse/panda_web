<html>
<body>
	<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>Scan Item</b></h5></td>
    <td width="20"><a href="<?php echo $back ?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

<form ole="form" method="POST" id="myForm" action="<?php echo site_url('general_scan_controller/scan_itemresult'); ?>">
<?php
  $web_guid = $this->session->userdata('web_guid');
  $acc_code = $this->session->userdata('acc_code');
  ?>

  <input value="<?php echo $web_guid?>" name="web_guid" type="hidden">
  <input value="<?php echo $acc_code?>" name="acc_code" type="hidden">
                           <!-- <input value="<?php echo $_SESSION['acc_code']?>" name="acc_code" type="hidden"> -->
    
  <?php 
    foreach ($module_desc->result() as $row) 
    {
  ?>
  <input value= "<?php echo $row->module_desc?>" name = "module_desc" type = "hidden">
  <?php 
    }
  ?>

	<p><label>Scan Barcode</label><br>
	  <input type="text" style="background-color: #e6fff2" placeholder="Scan Barcode" class="form-control" name="barcode" id="autofocus"/>
    </p>
</form>
 <h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
</div>
</body>
</html>