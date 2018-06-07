<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120">
    <h5><b>Online Stock Take </b></h5></td>
    <td width="20"><a href="<?php echo site_url('stktake_online_controller/main')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p>
<b>Location : <?php echo $_SESSION['location'];?> </b><br>
<h5>Stock Take @ <?php echo $_SESSION['stktake_date'];?></h5>
</p>

<form method="POST" action="<?php echo site_url('stktake_online_controller/scan_item_result'); ?>">
  <label>Scan Item<br>
  </label>
  <input type="text" style="background-color: #e6fff2" class="form-control input-md" name="barcode" id="textarea" required autofocus onblur="this.focus()"/>
 </form>
  <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>