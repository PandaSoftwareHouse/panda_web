<html>
<body>
<div class="container">

<table width="200" border="0">
  <tr>
    <td width="130"><h5><b><?php echo $heading?></b></h5></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo $form_action ?>">

<label>Scan Bin_ID</label><br>
<input type="text" class="form-control" style="background-color: #e6fff2" placeholder="Scan Bin_ID" name="bin_ID" id="autofocus" required autofocus onblur="this.focus()"/>

</form>

<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>

</div>
<p>&nbsp;</p>
</body>
</html>