<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>FORM PALLET</b></h5><small><b><?php echo $heading?></b></small></td>
    <td width="20"><a href="<?php echo site_url('formpallet_controller/m_batch_entry?batch_guid='.$_SESSION['batch_guid'])?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>         
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('formpallet_controller/item_entry_update')?>">

<h4><b><?php echo $line_no?>&nbsp;&nbsp; <?php echo $WeightTraceQtyUOM?></b></h4>
<h4><b><?php echo $description?></b></h4>
<h5><b>Weight(kg)</b></h5><br>
<input autofocus onfocus="this.select()" value="<?php echo $scan_weight?>" class="form-control" id="autofocus" type="number" step="any" style="text-align:center;width:80px;background-color:#ffff99" name="weight" />
<br>
<h5><b>Received Qty</b></h5>
<input autofocus name="rec_qty" type="number" step="any" class="form-control" style="text-align:center;width:80px;background-color:#80ff80" onfocus="this.select()" value="<?php echo $received_qty?>"/>
                                
  <?php
  if($check_trace_qty == '1')
  {
    ?>
    <h5><b>Trace Qty</b></h5>
    <input  value="<?php echo $trace_qty?>" type="number" step="any" name="trace_qty" style="text-align:center;width:80px;background-color:#f4b042"/>
    <br><br>
     <?php
  }
  else
  {
    ?>
      <input value="<?php echo $trace_qty?>" name="trace_qty" type="hidden"> 
    <?php
  }
  ?>
  <br>
 <input type="submit" name="submit" class="btn_success" value="SAVE"> 
</form>
</div>
<p>&nbsp;</p>
</body>
</html>