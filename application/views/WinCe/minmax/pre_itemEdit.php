<html>
<body>
<div class="container">

<table width="200" border="0">
  <tr>
    <td width="130"><h5><b><?php echo $heading?></b></h5></td>
    <td width="20"><a href="<?php echo site_url('main_controller/scan_barcode')?>?bin_ID=<?php echo $_SESSION['bin_ID']?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>        
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<form class="form-inline" role="form" method="POST" id="myForm" action="<?php echo $form_action ?>">

<p>                        
<b>Loc: </b><?php echo $_SESSION['locBin']?><br>
<b>BinID: </b><?php echo  $_SESSION['bin_ID']?><br>
<b>Description: </b><?php echo $bardesc?><br>
<b>Barcode: </b><?php echo $barcode?><br>
<b>Itemcode: </b><?php echo $itemcode?>
</p>

<table>
  <tr>
    <th><b>Set Min</b></th>
    <th>&nbsp;</th>
    <th><b>Set Max</b></th>
  </tr>
  <tr>
    <td><input  class="form-control" autofocus onfocus="this.select()" required type="number" name="set_min" style="text-align:center;width:50px;" min="0" value="<?php echo $set_min ?>"/></td>
    <td>&nbsp;</td>
    <td><input class="form-control" onclick="this.select()" required type="number" name="set_max" style="text-align:center;width:50px;" max="100000" value="<?php echo $set_max ?>"/></td>
  </tr>
</table>

<input type="hidden" value="<?php echo $itemcode ?>" name="itemcode">
<input type="submit" name="submit" value="SAVE" class="btn_success">
                    
</form>
<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>

</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>