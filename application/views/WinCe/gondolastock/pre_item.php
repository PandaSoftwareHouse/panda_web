<html>
<body>
<div class="container">
    
  <table width="200" border="0">
  <tr>
    <td width="130"><h5><b>Gondola Stock</b></h5></td>
    <td width="20"><a href="<?php echo site_url('gondolastock_controller/main')?>"><img src="<?php echo base_url('assets/icons/back.jpg'); ?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('main_controller/home')?>" style="float:right"><img src="<?php echo base_url('assets/icons/home.jpg');?>"></a></td>
    <td width="5">&nbsp;</td>
    <td width="20"><a href="<?php echo site_url('logout_c/logout')?>" style="float:right"><img src="<?php echo base_url('assets/icons/sign-out.jpg');?>"></a></td>
  </tr>
  </table>      
<p><small><b>Location : </b> <?php echo $_SESSION["location"] ?> </small></p>      
<p>
<a href="<?php echo site_url('gondolastock_controller/scan_binID'); ?>" class="btn_primary">+ SCAN BIN ID </a>
</p>

<?php
    foreach($pre_item->result() as $row)
    {
?>
  <h4><a href="<?php echo site_url('gondolastock_controller/pre_itemlist')?>?bin_ID=<?php echo $row->BIN_ID?>" style="color:black"><i class="fa fa-dot-circle-o" style="color:grey"></i>
<b><?php echo $row->BIN_ID; ?></b></a></h4><br>

<?php
  }
?>