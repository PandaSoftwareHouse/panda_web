<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b></h5></td>
    <td width="20"><a href="<?php echo site_url('greceive_controller/po_batch')?>?grn_guid=<?php echo $_SESSION['grn_guid']?>&po_no=<?php echo $_SESSION['po_no']?>&sname=<?php echo $_SESSION['sname']?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('greceive_controller/batch_weight_save')?>">

  <p><h4>Method: <?php echo $Method ?>&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $PalletID?></b></h4></p>
  <p><b><?php echo $MethodCode?></b>
    <?php
      if($StockValueShow == true)
      {
    ?>
      <input type="number" autofocus id="autofocus" class="form-control" value="<?php echo $StockValue?>" style="text-align:center;background-color: #e6fff2;width: 80px;" name="StockValue" onfocus="this.select()"/>
    <?php
      }
    ?>
     <br><b><?php echo $UOM?></b>
      <?php
        if($MultiplyShow == true)
        {
      ?>
      <input value="<?php echo $Multiply ?>" class="form-control" name="Multiply" style="text-align:center;background-color: #e6fff2;width: 80px;" size="5"/>
      <?php
        }
      ?>
                                    
  </p>
  <p>
    <input type="hidden" name="guid" value="<?php echo $guid?>">
    <br><input type="submit" name="submit" value="SAVE" class="btn_success">
</form>
<p>&nbsp;</p>
</div>
</body>
</html>

