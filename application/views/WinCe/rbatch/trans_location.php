<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>BATCH TRANSFER (IN)</b></h5>
    <small><?php echo $_SESSION['location'] ?></small></td>
    <td width="20"><a href="<?php echo site_url('rbatch_controller/main') ?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>         
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('rbatch_controller/rbatch_trans'); ?>">
<label>Scan Transaction Barcode</label>
<input type="text" class="form-control" style="background-color: #E6FFF2" placeholder="Scan Transaction Barcode" name="barcode" required autofocus />
<br>
<h4 style = "color:red"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></h4>
</form>                        
<table class="cTable">
<tbody>
  <?php 
    foreach($trans_location->result() as $row)
    { 
  ?>
<tr>
  <td class="cTD" style="color:green"><b><?php echo $row->batch_barcode; ?></b></td>
  <td class="cTD" ><b><?php echo $row->created_by; ?></b></td>
  <td class="cTD" ><b><?php echo $row->created_at; ?></b></td>
</tr>
<tr>
  <td class="cTD"><b><?php echo $row->pick_weight_variance; ?></td>
  <td class="cTD" colspan="2" style="color:red;"><b><?php echo $row->varified_weight_variance; ?></b></td>
</tr>
<?php 
  }
?>
</tbody>
</table>

</div>
<p>&nbsp;</p>
</body>
</html>                             