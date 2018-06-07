<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b><br><small><b>RTV <?php echo $type?></b></small>
    </h5></td>
    <td width="20"><a href="<?php echo site_url('greceive_controller/batch_entry')?>?batch_guid=<?php echo $_SESSION['batch_guid']?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo $form_action ?>">
  <p>
    <label for="description">Description :</label><br>

    <input required <?php echo $disabled?> class="form-control" value="<?php echo $description?>" style="background-color:#ffff99;width: 150px" name="description">
  </p>
  <p>
    <label for="qty">QTY :</label><br>
    <input autofocus onfocus="this.select()" required value="<?php echo $qty_do?>"  name="qty_do" style="width:80px;background-color:#80ff80;width: 80px" class="form-control" type="number">
  </p>
  <p>
  <input type="hidden" name="guid" value="<?php echo $guid?>">
  <input type="hidden" name="scan_barcode" value="<?php echo $scan_barcode?>">
    <input type="submit" name="submit" id="submit" value="SAVE" class="btn_success">
  </p>
</form>

<p>&nbsp;</p>
</div>
</body>
</html>

