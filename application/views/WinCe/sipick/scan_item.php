<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>SI MOBILE PICK</b></h5></td>
    <td width="20"><a href="<?php echo site_url('sipick_controller')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

 <form role="form" method="POST" id="myForm" action="<?php echo site_url('sipick_controller/scan_item_result'); ?>">

	<p><h5><b>Request No :</b><a target="_blank" href="<?php echo site_url('sipick_controller/itemlist') ?>?si_refno=<?php echo $si_refno?>"> <?php echo $si_refno?></a></h5>
    </p>
          <label>Item Barcode</label><br>
          <input type="text" style="background-color: #e6fff2" class="form-control input-md" placeholder="Search by" name="barcode" id="autofocus" required autofocus onblur="this.focus()"/>
</form>
	<p> <h4 style="color:black"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4> </p>
  <br><br><br><br>
</div>	
</body>
</html>
