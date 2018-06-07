<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="120"><h5><b>GRN BY PO</b><br><small><b><?php echo $title?> <?php echo $type?></b></small></h5></td>
    <td width="20"><a href="<?php echo site_url('greceive_controller/barcode_scan')?>">
    <img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form role="form" method="POST" id="myForm" action="<?php echo $form_action ?>">  
<p><h5><b><?php echo $description?></b></h5></p>
  <p>
    <label for="textfield">Qty:</label><br>
     <input autofocus required value="<?php echo $qty_do?>" class="form-control" name="qty_do" style="width:80px;background-color:#80ff80" onfocus="this.select()" type="number"/>           
  </p>
  <p>
    <input name="save" type="submit" class="btn_success" id="save" value="SAVE">
  </p>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>

