<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>FORM PALLET</b></h5></td>
    <td width="20"><a href="<?php echo site_url('formpallet_controller/m_batch')?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table> 
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('formpallet_controller/m_batch_weight_save')?>">

<h4>Method: <?php echo $Method ?>&nbsp&nbsp&nbsp&nbsp<b><?php echo $PalletID?></b></h4>
<br>
                                                           
<label><b><?php echo $MethodCode?></b></label>
<?php
if($StockValueShow == true)
{
  ?>
  <input type="number" id="autofocus" autofocus value="<?php echo $StockValue?>" class="form-control" style="text-align:center;width:80px;background-color:" name="StockValue" onfocus="this.select()"/>
<?php
  }
?>                                   
 <br>
                    
<label><b><?php echo $UOM?></b></label>
<?php
if($MultiplyShow == true)
{
  ?>
  <input value="<?php echo $Multiply ?>" class="form-control" name="Multiply" style="text-align:center;width:80px;background-color:"/>
<?php
  }
?>
                                    
<br>
<input type="hidden" name="guid" value="<?php echo $guid?>">
<input type="submit" name="submit" class="btn_success" value="SAVE">

</form>

</div>
<p>&nbsp;</p>
</body>
</html>