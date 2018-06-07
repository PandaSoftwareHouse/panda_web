<html>
<body>
<div class="container">
<table width="200" border="0">
  <tr>
    <td width="150"><h5><b>Shelve Label</b></h5></td>
    <td width="20"><a href="<?php echo site_url('shelveLabel_controller/barcode_scan')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
  <p><b>Bin ID :</b><?php echo $_SESSION['get_binID']?>&nbsp;&nbsp;<br><b>Barcode :</b><?php echo $_SESSION['get_barcode']?> <br>
   <?php echo $description?>&nbsp;&nbsp;<br><b>RM: </b><?php echo $price?>
    
  <br>
  <form role="form" method="POST" id="myForm" action="<?php echo site_url('shelveLabel_controller/save'); ?>">

<?php
  if($_SESSION['formatButton'] == '1')
  {
?>
  <input type="radio" name="format" value="0">UP &nbsp;&nbsp;
  <input checked type="radio" name="format" value="1"> DOWN
<?php
  }
  else
  {
?>
  <input checked type="radio" name="format" value="0">UP &nbsp;&nbsp;
  <input type="radio" name="format" value="1"> DOWN
<?php
    }
?>
                     
</p>
  <p>
    <input type="submit" name="button" id="button" value="SAVE" class="btn_success">
  </p>
</form>
<p>&nbsp;</p>
</div>
</body>
</html>
