<html>
<body>
<div class="container">
  
  <table width="200" border="0">
  <tr>
    <td width="120"><h5><b>Gondola Stock</b></h5></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>      
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<a href="<?php echo site_url('gondolastock_controller/pre_item'); ?>" class="btn"><b style="font-size:16px"> Gondola Stock By Item</b></a>

</div>
</body>
</html>