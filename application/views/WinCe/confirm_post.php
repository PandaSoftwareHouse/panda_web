<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b><?php echo $title?></b></h5></td>
    <td width="20"><a href="<?php echo $back_button?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table> 
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>           
     
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo $action?>">
<h4><?php echo $content?></h4>
<br>
<input type="submit" name="submit" class="btn_primary" value="POST">
</form>

</div>
<p>&nbsp;</p>
</body>
</html>
                 