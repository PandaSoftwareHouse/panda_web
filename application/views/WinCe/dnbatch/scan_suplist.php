<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>DN Batch</b><br>
    </h5></td>
    <td width="20"><a onclick="history.go(-1); else false;" href="<?php echo site_url('dnbatch_controller/main')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<table width="200" border="0" cellspacing="2">
  <thead>
  <tr>
    <td>Code</td>
    <td>Supplier</td>
  </tr>
  </thead>
    <?php 
      foreach($result->result() as $row)
      {
    ?>
  <tr>
    <td><h5><?php echo $row->code;?></h5></td>
    <td><h5><a href="<?php echo site_url('dnbatch_controller/scan_supconfirm?sup_code='.$row->code)?>"><?php echo $row->name;?></h5></td>
  </tr>
     <?php
       }
     ?>
</table>
<p>&nbsp;</p>
</div>
</body>
</html>

