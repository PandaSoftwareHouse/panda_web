<html>
<body>
<div class="container">
	<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Prelisting Stock Take</b></h5></td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p>
<center <?php echo $button_hidden?>>
<a href="<?php echo site_url('stktake_pre_controller/pre_item'); ?>" class="btn">
<b style="font-size:16px"> Prelisting By Item</b></button></a>
</p>
<p>
<a href="<?php echo site_url('stktake_pre_controller/pre_batch'); ?>" class="btn">
<b style="font-size:16px"> Prelisting By Pallet</b></button></a>
</center>
</p>
</div>
</body>
</html>
