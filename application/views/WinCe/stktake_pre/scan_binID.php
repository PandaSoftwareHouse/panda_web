<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Stock Take - Prelisting </b></h5></td>
    <td width="20"><a href="<?php echo $back ?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p>
<form method="POST" action="<?php echo $form_action ?>">
<label>Scan Bin ID</label><br>
<input type="text" style="background-color: #e6fff2" class="form-control input-md" name="bin_ID" id="autofocus" required autofocus onblur="this.focus()"/>
 </form>

</p>
  <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
</div>
</body>
</html>