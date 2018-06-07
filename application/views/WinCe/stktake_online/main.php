<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Stock Cycle Count</b></h5></td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<!-- <p>Location : <?php echo $_SESSION['location'];?></p> -->
<p>Date</p>
<p>
  <input disabled type="text" class="form-control" value="<?php echo $_SESSION['stktake_date']?>">
</p>
<p>
<a href="<?php echo site_url('stktake_online_controller/scan_item'); ?>" class="btn_info" value="go" name="go" type="submit"><b>NEXT</b></a></p>
</div>
<p>&nbsp;</p>
</body>
</html>