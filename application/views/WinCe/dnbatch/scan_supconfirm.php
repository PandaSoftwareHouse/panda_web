<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>DN Batch</b><br>
    </h5></td>
    <td width="20"><a href="<?php echo site_url('dnbatch_controller/scan_supplier')?>" style="float:right"><img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p><b>Create New Batch</b></p>
  <?php foreach($supdetail->result() as $row)
    {
  ?>
<p><b>Supplier: </b><?php echo $row->Name;?><br>
  <b>Code : </b><?php echo $row->Code;?></p>
<p><a href="<?php echo site_url("dnbatch_controller/create_batch?sup_code=$row->Code")?>" class="btn_success">CREATE</a></p>
 <?php 
    } 
 ?>
</div>
</body>
</html>

