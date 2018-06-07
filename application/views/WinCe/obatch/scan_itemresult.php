<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>BATCH TRANSFER OUT</b></h5></td>
    <td width="20"><a onclick="history.go(-1); else false;" href="<?php echo site_url('obatch_controller/scan_item')?>" style="float:right">
    <img src="<?php echo base_url('assets/icons/back.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>            
<small><?php echo $_SESSION['refno'] ?> &nbsp&nbsp <?php echo $_SESSION['location'] ?></small>        
<br>                  
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo site_url('obatch_controller/add_qty'); ?>">
<?php 
  foreach($item->result() as $row)
  {
?>
<h5><b>Batch Barcode: </b><?php echo $row->batch_barcode; ?></h5>
<h5><b style="color:red" >Original Gross Weight : </b><?php echo $row->goods_pallet_weight?></h5>
<input value="<?php echo $row->goods_pallet_weight?>" name="goods_pallet_weight" type="hidden"> 
<input value="<?php echo $row->batch_barcode?>" name="barcode" type="hidden">
                            
<?php
  }
?>
<h5><b style="color:blue">Re Weight : </b>&nbsp;
<input autofocus required value="<?php foreach($qty->result() as $row) { echo $row->pick_gdpl_weight; } ?>" type="number" step ="any" id="autofocus" class="form-control" name="iqty" onfocus="this.select()" style="text-align:center;width:80px;" />
</h5>
<br>
<input type="submit" name="view" class="btn_success" value="SAVE"><br>
<br>
<label>Remarks</label><br>
<input type="text" class="form-control" placeholder="Remarks" style="background-color: #e6fff2" name="remarks" id="autofocus" />

</form>

</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>