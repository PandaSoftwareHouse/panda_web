<html>
<body>
<div class="container">

<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>STOCK REQUEST</b><br>
    </h5></td>
    <td width="20"><a href="<?php echo site_url('pandarequest_controller/view_transaction')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('pandarequest_controller/backhome')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('pandarequest_controller/scan_binID'); ?>">
                       
  <label>Scan Bin ID:</label><br>
  <input type="text" id="autofocus" placeholder="Scan Bin_ID" class="form-control input-md" name="bin_ID" style="background-color:#E6fff2" required />
                      
</form><br>

</div>
</body>
</html>