<html>
<body onload="autofocus()">
<div class="container">
<table width="200" border="0" >
  <tr>
    <td width="120">
    <h5><b>Stock Cycle Count </b></h5></td>
    <td width="20"><a href="<?php echo site_url('stktake_online_controller/itemlink_list')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
</table>
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>
<p><b><?php echo $Desc?></b> <small>P/size : <?php echo $Size?></small><br>
<b>QOH : </b><?php echo $OnHand?> </p>
<p>Actual :</p>
<form role="form" method="POST" id="myForm" action="<?php echo site_url('stktake_online_controller/item_edit_save')?>">
  <table width="70" border="0">
    <tr>
      <td>
      <input type="number" class="form-control" style="text-align:center;background-color: #e6fff2;width: 80px" min="0" max="100000" step="any" disabled value="<?php echo $Actual?>">
      </td>
      <td><center><b>+</b></center></td>
      <td>
      <input autofocus required type="number" class="form-control" value="0" onfocus="this.select()" name="qty_add" id="autofocus" style="text-align:center;background-color: #e6fff2;width: 80px" max="100000" step="any">
      </td>
       <input type="hidden" name="qty_actual" value="<?php echo $Actual?>">
       <input type="hidden" name="qty_curr" value="<?php echo $OnHand?>">
       <input type="hidden" name="trans_guid" value="<?php echo $_REQUEST['trans_guid']?>">
    </tr>
  </table>
  <br>
  <p><input type="submit" name="submit" value="SAVE" class="btn_success">
  </p>
</form>
</div>
<p>&nbsp;</p>
</body>
</html>