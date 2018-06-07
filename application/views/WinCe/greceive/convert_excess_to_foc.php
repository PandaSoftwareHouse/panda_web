<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b><br>
    </h5></td>
    <td width="20"><a href="<?php echo site_url('greceive_controller/barcode_scan')?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p><h4><b style="color:red">Exess Qty !!!</b></h4></p>
<p><h4><b><?php echo $description?></b></h4><br>
  <h3><b style="color:red"><?php echo $qty_diff?></b></h3></p>
<p>
<a href="<?php echo site_url('greceive_controller/convert_excess_to_foc_1')?>?item_guid=<?php echo $item_guid?>" class="btn_primary"><b>FOC</b></a>

&nbsp;&nbsp;&nbsp;

 <a href="<?php echo site_url('greceive_controller/barcode_scan')?>" class="btn_success"><b>NEXT</b></a></p>
</div>
<p>&nbsp;</p>
</body>
</html>

