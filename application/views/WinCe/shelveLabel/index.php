<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>Shelve Label</b></h5></td>
    <td width="20">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>

<form role="form" method="POST" id="myForm" action="<?php echo site_url('shelveLabel_controller/scan_binID'); ?>">
      		<label>Scan Bin ID</label>
   		  <br>
          <input type="text" style="background-color: #e6fff2" class="form-control input-md" placeholder="Search by" name="bin_ID" id="autofocus" required autofocus onblur="this.focus()"/>
          <p><h4 style="color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4></p>     
</form><p>&nbsp;</p>
</div>
</body>
</html>
